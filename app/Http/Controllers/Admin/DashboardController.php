<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function index(Request $request)
    {
        $filter = strtoupper((string) $request->query('payment_status', 'ALL'));
        $allowedStatus = ['ALL', 'TELAH_DIBAYAR', 'POTONG_GAJI', 'BELUM_DIBAYAR'];
        if (!in_array($filter, $allowedStatus, true)) {
            $filter = 'ALL';
        }

        $periodFilter = $this->resolvePeriodFilter($request);

        return view('admin.dashboard', [
            'orders' => $this->getOrders($filter, $periodFilter, 100),
            'customers' => $this->getCustomers(),
            'products' => $this->getCashierProducts(),
            'filter' => $filter,
            'summary' => $this->getOrderSummary($periodFilter),
            'periodFilter' => $periodFilter,
            'filters' => [
                'payment_status' => $filter,
                'exact_date' => (string) ($periodFilter['value'] ?? now()->toDateString()),
            ],
            'adminName' => session('admin_name', 'Admin')
        ]);
    }

    /**
     * Update status pembayaran order
     */
    public function updatePaymentStatus(Request $request, int $id): RedirectResponse
    {
        if (!Schema::hasTable('orders')) {
            return back()->with('error', 'Tabel pesanan belum tersedia');
        }

        $data = $request->validate([
            'payment_status' => 'required|in:TELAH_DIBAYAR,POTONG_GAJI,BELUM_DIBAYAR',
        ]);

        $order = DB::table('orders')->where('id', $id)->first();

        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan');
        }

        $update = [
            'updated_at' => now(),
            'status' => $data['payment_status'] === 'BELUM_DIBAYAR'
                ? 'MENUNGGU'
                : 'SELESAI',
        ];

        if ($data['payment_status'] === 'POTONG_GAJI') {
            $update['metode'] = 'Potong Gaji';
        }

        DB::table('orders')
            ->where('id', $id)
            ->update($update);

        return back()->with('success', 'Status pembayaran pesanan diperbarui');
    }

    /**
     * Buat pesanan manual dari kasir
     */
    public function storeManualOrder(Request $request): RedirectResponse
    {
        if (!Schema::hasTable('orders') || !Schema::hasTable('order_items')) {
            return back()->with('error', 'Tabel transaksi belum tersedia');
        }

        if (!Schema::hasTable('products')) {
            return back()->with('error', 'Tabel produk belum tersedia');
        }

        $data = $request->validate([
            'user_id' => 'required|integer',
            'metode' => 'required|string|max:50',
            'payment_status' => 'required|in:TELAH_DIBAYAR,POTONG_GAJI,BELUM_DIBAYAR',
            'items_payload' => 'required|string',
        ]);

        if (Schema::hasTable('users') &&
            !DB::table('users')->where('id', $data['user_id'])->exists()) {
            return back()->with('error', 'Customer tidak ditemukan');
        }

        $decodedItems = json_decode((string) $data['items_payload'], true);

        if (!is_array($decodedItems) || empty($decodedItems)) {
            return back()->with('error', 'Daftar produk belanja kasir tidak valid');
        }

        $cartItems = [];

        foreach ($decodedItems as $item) {
            $productId = isset($item['product_id']) ? (int) $item['product_id'] : 0;
            $qty = isset($item['qty']) ? (int) $item['qty'] : 0;

            if ($productId < 1 || $qty < 1) {
                continue;
            }

            if (!isset($cartItems[$productId])) {
                $cartItems[$productId] = 0;
            }

            $cartItems[$productId] += $qty;
        }

        if (empty($cartItems)) {
            return back()->with('error', 'Tambahkan minimal 1 produk ke keranjang kasir');
        }

        DB::beginTransaction();

        try {
            $productIds = array_keys($cartItems);

            $products = DB::table('products')
                ->select('id', 'name', 'price', 'stock', 'status')
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== count($productIds)) {
                throw new \RuntimeException('Ada produk yang tidak ditemukan. Muat ulang halaman lalu coba lagi.');
            }

            $orderItems = [];
            $grandTotal = 0;

            foreach ($cartItems as $productId => $qty) {
                $product = $products->get($productId);
                $productName = (string) ($product->name ?? 'Produk');
                $stock = isset($product->stock) ? (int) $product->stock : null;
                $status = isset($product->status) ? (string) $product->status : 'Aktif';

                if (strcasecmp($status, 'Aktif') !== 0) {
                    throw new \RuntimeException("Produk {$productName} tidak aktif.");
                }

                if ($stock !== null && $stock < $qty) {
                    throw new \RuntimeException("Stok {$productName} tidak cukup. Tersisa {$stock}.");
                }

                $price = (int) round((float) ($product->price ?? 0));
                if ($price < 0) {
                    $price = 0;
                }

                $grandTotal += ($price * $qty);

                $orderItems[] = [
                    'product_id' => (int) $productId,
                    'qty' => (int) $qty,
                    'price' => $price,
                ];
            }

            if ($grandTotal < 1) {
                throw new \RuntimeException('Total transaksi tidak valid');
            }

            $orderId = DB::table('orders')->insertGetId([
                'user_id' => (int) $data['user_id'],
                'total' => $grandTotal,
                'metode' => $data['payment_status'] === 'POTONG_GAJI'
                    ? 'Potong Gaji'
                    : $data['metode'],
                'status' => $data['payment_status'] === 'BELUM_DIBAYAR'
                    ? 'MENUNGGU'
                    : 'SELESAI',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($orderItems as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('products')
                    ->where('id', $item['product_id'])
                    ->decrement('stock', $item['qty']);
            }

            DB::commit();

            return back()->with('success', 'Pesanan manual per produk berhasil dibuat');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Logout admin
     */
    public function logout(Request $request): RedirectResponse
    {
        // hapus semua session
        $request->session()->flush();

        // invalidate session
        $request->session()->invalidate();

        // regenerate token
        $request->session()->regenerateToken();

        return redirect()->route('user.landing');
    }

    private function getOrders(string $filter, array $periodFilter = [], ?int $limit = null): Collection
    {
        if (!Schema::hasTable('orders')) {
            return collect();
        }

        $nameColumn = $this->getUserNameColumn();

        $query = DB::table('orders as o');

        if (Schema::hasTable('users')) {
            $query->leftJoin('users as u', 'u.id', '=', 'o.user_id');
        }

        $query->select(
            'o.id',
            'o.total',
            'o.metode',
            'o.status',
            'o.created_at'
        );

        if ($nameColumn !== null) {
            $query->addSelect(DB::raw("u.{$nameColumn} as customer_name"));
        } else {
            $query->addSelect(DB::raw("'Customer' as customer_name"));
        }

        $this->applyPeriodFilter($query, $periodFilter);

        $query->orderByDesc('o.created_at');

        if ($limit !== null) {
            $query->limit($limit);
        }

        $orders = $query->get()
            ->map(function ($order) {
                $order->payment_status = $this->resolvePaymentStatus(
                    $order->status ?? null,
                    $order->metode ?? null
                );
                return $order;
            });

        if ($filter === 'ALL') {
            return $orders;
        }

        return $orders->filter(function ($order) use ($filter) {
            return $order->payment_status === $filter;
        })->values();
    }

    private function getCustomers(): Collection
    {
        if (!Schema::hasTable('users')) {
            return collect();
        }

        $nameColumn = $this->getUserNameColumn();
        if ($nameColumn === null) {
            return collect();
        }

        return DB::table('users')
            ->select('id', DB::raw("{$nameColumn} as name"))
            ->orderBy($nameColumn, 'asc')
            ->limit(200)
            ->get();
    }

    private function getOrderSummary(array $periodFilter = []): array
    {
        $orders = $this->getOrders('ALL', $periodFilter);

        return [
            'total' => $orders->count(),
            'paid' => $orders->where('payment_status', 'TELAH_DIBAYAR')->count(),
            'salary_cut' => $orders->where('payment_status', 'POTONG_GAJI')->count(),
            'unpaid' => $orders->where('payment_status', 'BELUM_DIBAYAR')->count(),
        ];
    }

    private function getCashierProducts(): Collection
    {
        if (!Schema::hasTable('products')) {
            return collect();
        }

        $query = DB::table('products')
            ->select('id', 'name', 'category', 'price', 'stock');

        if (Schema::hasColumn('products', 'status')) {
            $query->where('status', 'Aktif');
        }

        if (Schema::hasColumn('products', 'stock')) {
            $query->where('stock', '>', 0);
        }

        return $query
            ->orderBy('name', 'asc')
            ->limit(500)
            ->get();
    }

    private function getUserNameColumn(): ?string
    {
        if (!Schema::hasTable('users')) {
            return null;
        }

        if (Schema::hasColumn('users', 'nama')) {
            return 'nama';
        }

        if (Schema::hasColumn('users', 'name')) {
            return 'name';
        }

        return null;
    }

    private function resolvePaymentStatus(?string $status, ?string $metode): string
    {
        $status = strtoupper((string) $status);
        $metode = strtolower((string) $metode);

        if (str_contains($metode, 'potong gaji')) {
            return 'POTONG_GAJI';
        }

        if (in_array($status, ['SELESAI', 'LUNAS', 'TELAH_DIBAYAR'], true)) {
            return 'TELAH_DIBAYAR';
        }

        return 'BELUM_DIBAYAR';
    }

    private function resolvePeriodFilter(Request $request): array
    {
        $exactDate = trim((string) $request->query('exact_date', ''));
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $exactDate, $dateParts) === 1) {
            $year = (int) $dateParts[1];
            $month = (int) $dateParts[2];
            $day = (int) $dateParts[3];

            if (checkdate($month, $day, $year)) {
                return [
                    'type' => 'date',
                    'value' => sprintf('%04d-%02d-%02d', $year, $month, $day),
                ];
            }
        }

        return [
            'type' => 'date',
            'value' => now()->toDateString(),
        ];
    }

    private function applyPeriodFilter($query, array $periodFilter): void
    {
        $type = (string) ($periodFilter['type'] ?? 'none');
        $value = (string) ($periodFilter['value'] ?? '');

        if ($type === 'date' && $value !== '') {
            $query->whereDate('o.created_at', $value);
            return;
        }
    }
}
