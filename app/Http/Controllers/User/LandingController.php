<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LandingController extends Controller
{

    public function landing()
    {
        $products = DB::table('products')
            ->where('status','Aktif')
            ->orderBy('name','asc')
            ->limit(4)
            ->get();

        return view('user.landing', compact('products'));
    }


    public function belanja()
    {
        $products = DB::table('products')
            ->where('status','Aktif')
            ->orderBy('name','asc')
            ->get();

        return view('user.belanja', compact('products'));
    }

    public function pinjaman()
    {
        Carbon::setLocale('id');

        $userId = session('user_id') ?? auth()->id() ?? 1;

        $user = DB::table('users')->where('id', $userId)->first();

        $userName = null;
        if ($user) {
            $userName = $user->nama ?? $user->name ?? null;
        }

        $loansQuery = DB::table('loans')->orderBy('created_at', 'desc');

        if (!empty($userName)) {
            $loansQuery->where('nama_peminjam', $userName);
        }

        $loans = $loansQuery->get();

        $activeLoan = $loans->firstWhere('status', 'MENUNGGU')
            ?? $loans->firstWhere('status', 'DISETUJUI')
            ?? $loans->first();

        $activeLoanData = null;
        if ($activeLoan) {
            $amount = (float) $activeLoan->jumlah;
            $tenor = (int) $activeLoan->tenor;

            $activeLoanData = [
                'status' => $activeLoan->status,
                'jumlah' => $amount,
                'sisa' => $activeLoan->status === 'LUNAS' ? 0 : $amount,
                'angsuran' => $tenor > 0 ? ($amount / $tenor) : 0,
                'tenor' => $tenor,
                'mulai' => $activeLoan->created_at
                    ? Carbon::parse($activeLoan->created_at)->translatedFormat('F Y')
                    : '-',
            ];
        }

        return view('user.pinjaman', [
            'user' => $user,
            'userName' => $userName,
            'loans' => $loans,
            'activeLoan' => $activeLoanData,
        ]);
    }

    public function submitPinjaman(Request $request)
    {
        if (!auth()->check()) {
            return redirect()
                ->route('user.pinjaman')
                ->with('error', 'Silakan login terlebih dahulu untuk mengajukan pinjaman.');
        }

        $validated = $request->validate(
            [
                'penghasilan' => ['required', 'numeric', 'min:1'],
                'jumlah' => ['required', 'numeric', 'min:1'],
                'tenor' => ['required', 'integer', 'min:1', 'max:120'],
                'keperluan' => ['required', 'string', 'min:5', 'max:500'],
                'mulai' => ['required', 'date'],
                'paraf' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ],
            [
                'penghasilan.required' => 'Penghasilan wajib diisi.',
                'penghasilan.numeric' => 'Penghasilan harus berupa angka.',
                'penghasilan.min' => 'Penghasilan minimal 1.',
                'jumlah.required' => 'Jumlah permohonan wajib diisi.',
                'jumlah.numeric' => 'Jumlah permohonan harus berupa angka.',
                'jumlah.min' => 'Jumlah permohonan minimal 1.',
                'tenor.required' => 'Jangka waktu wajib diisi.',
                'tenor.integer' => 'Jangka waktu harus berupa angka bulat.',
                'tenor.min' => 'Jangka waktu minimal 1 bulan.',
                'tenor.max' => 'Jangka waktu maksimal 120 bulan.',
                'keperluan.required' => 'Keperluan pinjaman wajib diisi.',
                'keperluan.min' => 'Keperluan pinjaman minimal 5 karakter.',
                'keperluan.max' => 'Keperluan pinjaman maksimal 500 karakter.',
                'mulai.required' => 'Tanggal mulai wajib diisi.',
                'mulai.date' => 'Tanggal mulai tidak valid.',
                'paraf.image' => 'Paraf harus berupa file gambar.',
                'paraf.mimes' => 'Format paraf hanya boleh JPG, JPEG, atau PNG.',
                'paraf.max' => 'Ukuran paraf maksimal 2MB.',
            ]
        );

        $user = auth()->user();
        $borrowerName = $user->name ?? null;

        if (empty($borrowerName)) {
            return redirect()
                ->route('user.pinjaman')
                ->withInput()
                ->with('error', 'Nama peminjam tidak ditemukan. Hubungi admin.');
        }

        $hasActiveLoan = DB::table('loans')
            ->where('nama_peminjam', $borrowerName)
            ->whereIn('status', ['MENUNGGU', 'DISETUJUI'])
            ->exists();

        if ($hasActiveLoan) {
            return redirect()
                ->route('user.pinjaman')
                ->withInput()
                ->with('error', 'Anda masih memiliki pinjaman aktif atau menunggu persetujuan.');
        }

        if (Schema::hasColumn('users', 'gaji')) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'gaji' => $validated['penghasilan'],
                    'updated_at' => now(),
                ]);
        }

        $parafPath = null;
        if ($request->hasFile('paraf')) {
            $parafPath = $request->file('paraf')->store('paraf', 'public');
        }

        $nextSequence = (int) (DB::table('loans')->max('id') ?? 0) + 1;
        do {
            $kode = 'PJ' . str_pad((string) $nextSequence, 3, '0', STR_PAD_LEFT);
            $kodeExists = DB::table('loans')->where('kode', $kode)->exists();
            $nextSequence++;
        } while ($kodeExists);

        $catatan = "Keperluan: {$validated['keperluan']}\nMulai: {$validated['mulai']}";
        if ($parafPath !== null) {
            $catatan .= "\nParaf: {$parafPath}";
        }

        DB::table('loans')->insert([
            'kode' => $kode,
            'nama_peminjam' => $borrowerName,
            'jumlah' => $validated['jumlah'],
            'tenor' => $validated['tenor'],
            'status' => 'MENUNGGU',
            'catatan_admin' => $catatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('user.pinjaman')
            ->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }

    public function riwayat()
    {
        Carbon::setLocale('id');

        $userId = session('user_id') ?? auth()->id() ?? 1;

        $orders = DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $itemsByOrder = collect();

        if ($orders->isNotEmpty()) {
            $itemsByOrder = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select(
                    'order_items.order_id',
                    'order_items.qty',
                    'order_items.price',
                    'products.category',
                    'products.image',
                    'products.name'
                )
                ->whereIn('order_items.order_id', $orders->pluck('id'))
                ->get()
                ->groupBy('order_id');
        }

        $ordersView = $orders->map(function ($order) use ($itemsByOrder) {
            $items = $itemsByOrder->get($order->id, collect());

            $totalQty = $items->sum('qty');

            $categorySummary = $items
                ->groupBy('category')
                ->map(fn($group) => $group->sum('qty'))
                ->map(fn($qty, $category) => $category . ' x' . $qty)
                ->values()
                ->implode(' | ');

            $total = $order->total ?? $items->reduce(function ($carry, $item) {
                return $carry + ($item->price * $item->qty);
            }, 0);

            $thumbImage = $items->first()->image ?? null;

            return (object) [
                'id' => $order->id,
                'kode' => str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'tanggal' => $order->created_at
                    ? Carbon::parse($order->created_at)->translatedFormat('j F Y')
                    : '-',
                'waktu' => $order->created_at
                    ? Carbon::parse($order->created_at)->format('H:i')
                    : '',
                'total' => $total,
                'total_qty' => $totalQty,
                'other_items' => max(0, $totalQty - 1),
                'category_summary' => $categorySummary,
                'thumb' => $thumbImage,
            ];
        });

        return view('user.riwayat', [
            'orders' => $ordersView,
        ]);
    }

    public function riwayatDetail(int $id)
    {
        if (!auth()->check()) {
            return redirect()
                ->route('user.landing')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = (int) auth()->id();

        $order = DB::table('orders')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            return redirect()
                ->route('user.riwayat')
                ->with('error', 'Detail pesanan tidak ditemukan.');
        }

        $items = DB::table('order_items as oi')
            ->leftJoin('products as p', 'p.id', '=', 'oi.product_id')
            ->select(
                'oi.qty',
                'oi.price',
                'p.name',
                'p.category',
                'p.image'
            )
            ->where('oi.order_id', $id)
            ->get()
            ->map(function ($item) {
                $item->name = $item->name ?? 'Produk';
                $item->category = $item->category ?? 'Lainnya';
                $item->subtotal = ((int) $item->price) * ((int) $item->qty);
                return $item;
            });

        return view('user.riwayat-detail', [
            'order' => $order,
            'items' => $items,
        ]);
    }

}
