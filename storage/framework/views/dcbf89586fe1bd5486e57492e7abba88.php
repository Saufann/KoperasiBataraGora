<?php $__env->startSection('title', 'Dashboard Kasir | Admin'); ?>

<?php $__env->startSection('content'); ?>

<style>
.cashier-page .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.cashier-page .page-title {
    margin: 0;
    font-size: 24px;
    color: #111827;
}

.cashier-page .page-subtitle {
    margin: 4px 0 0;
    color: #6b7280;
    font-size: 14px;
}

.cashier-page .stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}

.cashier-page .stats .stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 14px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.cashier-page .stats .stat-label {
    font-size: 12px;
    color: #6b7280;
}

.cashier-page .stats .stat-value {
    margin-top: 6px;
    font-size: 24px;
    font-weight: 700;
    color: #111827;
}

.cashier-page .grid {
    display: grid;
    grid-template-columns: minmax(0, 1.7fr) minmax(340px, 1fr);
    gap: 16px;
    align-items: start;
}

.cashier-page .card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    padding: 16px;
    min-width: 0;
}

.cashier-page .card h3 {
    margin: 0 0 12px;
    font-size: 18px;
}

.cashier-page .toolbar {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 12px;
}

.cashier-page .toolbar-note {
    margin: 4px 0 0;
    font-size: 12px;
    color: #64748b;
}

.cashier-page .order-filter-form {
    margin: 0;
    display: grid;
    grid-template-columns: 180px 160px auto auto;
    gap: 8px;
    align-items: center;
}

.cashier-page .active-filter {
    margin: 0 0 10px;
    font-size: 12px;
    color: #334155;
}

.cashier-page .field-control {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 14px;
    color: #0f172a;
    background: #ffffff;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.cashier-page .field-control::placeholder {
    color: #9ca3af;
}

.cashier-page .field-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.cashier-page .field-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 38px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M5.5 7.5L10 12L14.5 7.5' stroke='%2364748B' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 16px;
}

.cashier-page .action-form .field-select {
    min-width: 160px;
}

.cashier-page .alert {
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 12px;
    font-size: 13px;
}

.cashier-page .alert-success {
    background: #ecfdf5;
    color: #166534;
    border: 1px solid #86efac;
}

.cashier-page .alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.cashier-page .table-wrap {
    overflow: auto;
    max-height: min(62vh, 620px);
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    max-width: 100%;
}

.cashier-page table {
    width: 100%;
    border-collapse: collapse;
}

.cashier-page .orders-table {
    min-width: 860px;
}

.cashier-page th {
    background: #1f2937;
    color: #ffffff;
    font-size: 13px;
    text-align: left;
    padding: 10px;
    position: sticky;
    top: 0;
    z-index: 1;
    white-space: nowrap;
}

.cashier-page td {
    border-bottom: 1px solid #e5e7eb;
    padding: 10px;
    font-size: 13px;
    vertical-align: middle;
}

.cashier-page .badge {
    display: inline-block;
    border-radius: 20px;
    font-weight: 700;
    font-size: 11px;
    padding: 6px 10px;
    color: #ffffff;
}

.cashier-page .status-paid {
    background: #16a34a;
}

.cashier-page .status-salary {
    background: #2563eb;
}

.cashier-page .status-unpaid {
    background: #f59e0b;
}

.cashier-page .action-form {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

.cashier-page .btn {
    border: none;
    border-radius: 8px;
    cursor: pointer;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 600;
}

.cashier-page .btn-primary {
    background: #2563eb;
    color: #ffffff;
}

.cashier-page .btn-light {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #e2e8f0;
    color: #0f172a;
    text-decoration: none;
}

.cashier-page .manual-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.cashier-page .manual-form label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.cashier-page .manual-form .hint {
    margin: 0;
    font-size: 12px;
    color: #6b7280;
}

.cashier-page .manual-search-wrap {
    position: relative;
}

.cashier-page .search-results {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    right: 0;
    z-index: 20;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    max-height: 220px;
    overflow-y: auto;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.14);
}

.cashier-page .search-empty {
    padding: 10px 12px;
    font-size: 12px;
    color: #6b7280;
}

.cashier-page .search-item-btn {
    width: 100%;
    border: none;
    border-bottom: 1px solid #f1f5f9;
    background: #ffffff;
    text-align: left;
    padding: 10px 12px;
    cursor: pointer;
    transition: background .15s ease;
}

.cashier-page .search-item-btn:hover {
    background: #eff6ff;
}

.cashier-page .search-item-btn:last-child {
    border-bottom: none;
}

.cashier-page .search-item-name {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
}

.cashier-page .search-item-meta {
    display: block;
    margin-top: 4px;
    font-size: 12px;
    color: #64748b;
}

.cashier-page .manual-cart-wrap {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: auto;
}

.cashier-page .manual-cart-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 520px;
}

.cashier-page .manual-cart-table th {
    position: static;
    background: #f8fafc;
    color: #64748b;
    border-bottom: 1px solid #e2e8f0;
    font-size: 12px;
    letter-spacing: .02em;
    text-transform: uppercase;
}

.cashier-page .manual-cart-table td {
    border-bottom: 1px solid #edf2f7;
    font-size: 13px;
}

.cashier-page .manual-cart-table tr:last-child td {
    border-bottom: none;
}

.cashier-page .manual-product {
    font-weight: 700;
    color: #0f172a;
}

.cashier-page .manual-subtotal {
    font-weight: 700;
    color: #0f172a;
}

.cashier-page .qty-cell {
    min-width: 210px;
}

.cashier-page .qty-control {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.cashier-page .qty-input {
    width: 78px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 8px 10px;
    font-size: 13px;
    font-weight: 700;
    text-align: center;
}

.cashier-page .btn-soft {
    border: none;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    background: #e2e8f0;
    color: #1d4ed8;
}

.cashier-page .btn-danger {
    border: none;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    background: #fee2e2;
    color: #dc2626;
}

.cashier-page .manual-total {
    display: flex;
    justify-content: flex-end;
    align-items: baseline;
    gap: 10px;
    margin-top: 14px;
}

.cashier-page .manual-total-label {
    font-size: 18px;
    color: #6b7280;
    font-weight: 600;
}

.cashier-page .manual-total-value {
    font-size: 34px;
    line-height: 1.1;
    color: #0f172a;
    font-weight: 800;
}

.cashier-page .manual-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 12px;
}

.cashier-page .manual-actions .btn-primary {
    padding: 10px 20px;
}

.cashier-page .manual-empty-row td {
    text-align: center;
    color: #64748b;
    font-size: 12px;
    padding: 16px 10px;
}

@media (max-width: 1320px) {
    .cashier-page .stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .cashier-page .grid {
        grid-template-columns: 1fr;
    }

    .cashier-page .manual-total {
        justify-content: flex-start;
    }

    .cashier-page .manual-actions {
        justify-content: flex-start;
    }
}

@media (max-width: 920px) {
    .cashier-page .order-filter-form {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    $paymentLabels = [
        'TELAH_DIBAYAR' => 'Telah Dibayar',
        'POTONG_GAJI' => 'Potong Gaji',
        'BELUM_DIBAYAR' => 'Belum Dibayar',
    ];

    $cashierProducts = ($products ?? collect())->map(function ($product) {
        return [
            'id' => (int) ($product->id ?? 0),
            'name' => (string) ($product->name ?? 'Produk'),
            'category' => (string) ($product->category ?? ''),
            'price' => (int) round((float) ($product->price ?? 0)),
            'stock' => (int) ($product->stock ?? 0),
        ];
    })->values();

    $cashierCustomers = ($customers ?? collect())->map(function ($customer) {
        return [
            'id' => (int) ($customer->id ?? 0),
            'name' => (string) ($customer->name ?? 'Customer'),
        ];
    })->values();

    $oldCustomerId = (int) old('user_id', 0);
    $selectedCustomer = $cashierCustomers->firstWhere('id', $oldCustomerId);
    $selectedCustomerName = (string) ($selectedCustomer['name'] ?? '');

    $filterValues = $filters ?? [
        'payment_status' => $filter ?? 'ALL',
        'exact_date' => now()->format('Y-m-d'),
    ];

    $activePeriodLabel = 'Hari Ini';
    if (($periodFilter['type'] ?? 'none') === 'date' && !empty($periodFilter['value'])) {
        $parts = explode('-', (string) $periodFilter['value']);
        if (count($parts) === 3) {
            $activePeriodLabel = 'Tanggal: ' . $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
    }
?>

<div class="cashier-page">
    <div class="page-header">
        <div>
            <h2 class="page-title">Dashboard Kasir</h2>
            <p class="page-subtitle">Kelola pembayaran pesanan dan input transaksi manual customer.</p>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-error"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value"><?php echo e($summary['total'] ?? 0); ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Telah Dibayar</div>
            <div class="stat-value"><?php echo e($summary['paid'] ?? 0); ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Potong Gaji</div>
            <div class="stat-value"><?php echo e($summary['salary_cut'] ?? 0); ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Belum Dibayar</div>
            <div class="stat-value"><?php echo e($summary['unpaid'] ?? 0); ?></div>
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <div class="toolbar">
                <div>
                    <h3>Daftar Pesanan</h3>
                    <p class="toolbar-note">Default menampilkan transaksi hari ini. Pilih tanggal untuk melihat hari lain.</p>
                </div>

                <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>" class="order-filter-form" id="orderFilterForm">
                    <select class="field-control field-select" name="payment_status">
                        <option value="ALL" <?php echo e(($filterValues['payment_status'] ?? 'ALL') === 'ALL' ? 'selected' : ''); ?>>Semua Status</option>
                        <option value="TELAH_DIBAYAR" <?php echo e(($filterValues['payment_status'] ?? 'ALL') === 'TELAH_DIBAYAR' ? 'selected' : ''); ?>>Telah Dibayar</option>
                        <option value="POTONG_GAJI" <?php echo e(($filterValues['payment_status'] ?? 'ALL') === 'POTONG_GAJI' ? 'selected' : ''); ?>>Potong Gaji</option>
                        <option value="BELUM_DIBAYAR" <?php echo e(($filterValues['payment_status'] ?? 'ALL') === 'BELUM_DIBAYAR' ? 'selected' : ''); ?>>Belum Dibayar</option>
                    </select>

                    <input class="field-control"
                           type="date"
                           name="exact_date"
                           id="filterExactDate"
                           value="<?php echo e((string) ($filterValues['exact_date'] ?? '')); ?>">

                    <button class="btn btn-primary" type="submit">Terapkan</button>
                    <a class="btn btn-light" href="<?php echo e(route('admin.dashboard')); ?>">Reset</a>
                </form>
            </div>

            <p class="active-filter">Periode Aktif: <?php echo e($activePeriodLabel); ?></p>

            <div class="table-wrap">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $statusClass = $order->payment_status === 'TELAH_DIBAYAR'
                                    ? 'status-paid'
                                    : ($order->payment_status === 'POTONG_GAJI' ? 'status-salary' : 'status-unpaid');
                                $displayCustomer = $order->customer_name ?: 'Customer Tidak Diketahui';
                            ?>
                            <tr>
                                <td>#<?php echo e(str_pad((string) $order->id, 5, '0', STR_PAD_LEFT)); ?></td>
                                <td><?php echo e($displayCustomer); ?></td>
                                <td>Rp <?php echo e(number_format((float) $order->total, 0, ',', '.')); ?></td>
                                <td><?php echo e($order->metode ?? '-'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($statusClass); ?>">
                                        <?php echo e($paymentLabels[$order->payment_status] ?? $order->payment_status); ?>

                                    </span>
                                </td>
                                <td><?php echo e($order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') : '-'); ?></td>
                                <td>
                                    <form class="action-form"
                                            method="POST"
                                            action="<?php echo e(route('admin.dashboard.order.payment-status', $order->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <select class="field-control field-select" name="payment_status">
                                            <option value="TELAH_DIBAYAR" <?php echo e($order->payment_status === 'TELAH_DIBAYAR' ? 'selected' : ''); ?>>Telah Dibayar</option>
                                            <option value="POTONG_GAJI" <?php echo e($order->payment_status === 'POTONG_GAJI' ? 'selected' : ''); ?>>Potong Gaji</option>
                                            <option value="BELUM_DIBAYAR" <?php echo e($order->payment_status === 'BELUM_DIBAYAR' ? 'selected' : ''); ?>>Belum Dibayar</option>
                                        </select>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" style="text-align:center;">Belum ada pesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h3>Input Pesanan Manual per Produk</h3>
            <form class="manual-form"
                  method="POST"
                  action="<?php echo e(route('admin.dashboard.order.manual')); ?>"
                  id="manualOrderForm">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="items_payload" id="manualItemsPayload" value="<?php echo e(old('items_payload', '')); ?>">

                <div class="manual-search-wrap">
                    <label>Customer</label>
                    <input type="hidden" name="user_id" id="manualCustomerId" value="<?php echo e(old('user_id', '')); ?>">
                    <input class="field-control"
                           type="text"
                           id="cashierCustomerSearch"
                           autocomplete="off"
                           placeholder="Ketik nama customer lalu pilih"
                           value="<?php echo e($selectedCustomerName); ?>">
                    <div class="search-results" id="cashierCustomerResults" style="display:none;"></div>
                </div>

                <div class="manual-search-wrap">
                    <label>Cari Produk</label>
                    <input class="field-control"
                           type="text"
                           id="cashierProductSearch"
                           placeholder="Ketik nama/kategori produk lalu pilih">
                    <div class="search-results" id="cashierSearchResults" style="display:none;"></div>
                </div>

                <div class="manual-cart-wrap">
                    <table class="manual-cart-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Kuantitas</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="manualCartBody">
                            <tr class="manual-empty-row">
                                <td colspan="5">Belum ada produk di keranjang kasir.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div>
                    <label>Metode Pembayaran</label>
                    <select class="field-control field-select" name="metode" id="manualMetode" required>
                        <option value="Tunai" <?php echo e(old('metode') === 'Tunai' ? 'selected' : ''); ?>>Tunai</option>
                        <option value="QRIS" <?php echo e(old('metode') === 'QRIS' ? 'selected' : ''); ?>>QRIS</option>
                        <option value="Transfer" <?php echo e(old('metode') === 'Transfer' ? 'selected' : ''); ?>>Transfer</option>
                        <option value="Potong Gaji" <?php echo e(old('metode') === 'Potong Gaji' ? 'selected' : ''); ?>>Potong Gaji</option>
                    </select>
                </div>

                <div>
                    <label>Status Pembayaran</label>
                    <select class="field-control field-select" name="payment_status" id="manualStatus" required>
                        <option value="TELAH_DIBAYAR" <?php echo e(old('payment_status', 'TELAH_DIBAYAR') === 'TELAH_DIBAYAR' ? 'selected' : ''); ?>>Telah Dibayar</option>
                        <option value="POTONG_GAJI" <?php echo e(old('payment_status') === 'POTONG_GAJI' ? 'selected' : ''); ?>>Potong Gaji</option>
                        <option value="BELUM_DIBAYAR" <?php echo e(old('payment_status') === 'BELUM_DIBAYAR' ? 'selected' : ''); ?>>Belum Dibayar</option>
                    </select>
                </div>

                <div class="manual-total">
                    <span class="manual-total-label">Total Pembayaran:</span>
                    <span class="manual-total-value" id="manualGrandTotal">Rp 0</span>
                </div>

                <div class="manual-actions">
                    <button class="btn btn-primary" type="submit">Buat Pesanan</button>
                </div>

                <p class="hint">Status "Potong Gaji" otomatis akan memakai metode Potong Gaji.</p>
            </form>
        </div>
    </div>
</div>

<script>
const manualStatus = document.getElementById('manualStatus');
const manualMetode = document.getElementById('manualMetode');
const manualOrderForm = document.getElementById('manualOrderForm');
const manualItemsPayload = document.getElementById('manualItemsPayload');
const manualCustomerIdInput = document.getElementById('manualCustomerId');
const customerSearchInput = document.getElementById('cashierCustomerSearch');
const customerSearchResults = document.getElementById('cashierCustomerResults');
const cashierSearchInput = document.getElementById('cashierProductSearch');
const cashierSearchResults = document.getElementById('cashierSearchResults');
const manualCartBody = document.getElementById('manualCartBody');
const manualGrandTotal = document.getElementById('manualGrandTotal');
const cashierCustomers = <?php echo json_encode($cashierCustomers, 15, 512) ?>;
const cashierCustomerMap = new Map(cashierCustomers.map((customer) => [Number(customer.id), customer]));
const cashierProducts = <?php echo json_encode($cashierProducts, 15, 512) ?>;
const cashierProductMap = new Map(cashierProducts.map((product) => [Number(product.id), product]));
let cashierCart = {};

if (manualStatus && manualMetode) {
    manualStatus.addEventListener('change', function () {
        if (this.value === 'POTONG_GAJI') {
            manualMetode.value = 'Potong Gaji';
        }
    });

    manualMetode.addEventListener('change', function () {
        if (this.value === 'Potong Gaji') {
            manualStatus.value = 'POTONG_GAJI';
        }
    });
}

function formatRupiah(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(value) || 0);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function persistManualPayload() {
    if (!manualItemsPayload) return;

    const payload = Object.entries(cashierCart)
        .map(([productId, qty]) => ({
            product_id: Number(productId),
            qty: Number(qty),
        }))
        .filter((item) => item.product_id > 0 && item.qty > 0);

    manualItemsPayload.value = JSON.stringify(payload);
}

function renderManualTotal() {
    if (!manualGrandTotal) return;

    const total = Object.entries(cashierCart).reduce((sum, [productId, qty]) => {
        const product = cashierProductMap.get(Number(productId));
        if (!product) return sum;
        return sum + (Number(product.price) * Number(qty));
    }, 0);

    manualGrandTotal.textContent = formatRupiah(total);
}

function renderManualCart() {
    if (!manualCartBody) return;

    const entries = Object.entries(cashierCart)
        .filter(([_, qty]) => Number(qty) > 0)
        .sort((a, b) => Number(a[0]) - Number(b[0]));

    if (entries.length === 0) {
        manualCartBody.innerHTML = '<tr class="manual-empty-row"><td colspan="5">Belum ada produk di keranjang kasir.</td></tr>';
        persistManualPayload();
        renderManualTotal();
        return;
    }

    let html = '';

    entries.forEach(([productId, qty]) => {
        const id = Number(productId);
        const product = cashierProductMap.get(id);

        if (!product) return;

        const safeName = escapeHtml(product.name || 'Produk');
        const price = Number(product.price) || 0;
        const subtotal = price * Number(qty);
        const maxStock = Number(product.stock) > 0 ? Number(product.stock) : Number(qty);

        html += `
            <tr>
                <td>
                    <div class="manual-product">${safeName}</div>
                    <small style="color:#64748b;">Stok: ${maxStock}</small>
                </td>
                <td>${formatRupiah(price)}</td>
                <td class="qty-cell">
                    <div class="qty-control">
                        <input class="qty-input" type="number" min="1" max="${maxStock}" value="${Number(qty)}" data-qty-input="${id}">
                        <button class="btn-soft" type="button" data-save-qty="${id}">Simpan</button>
                    </div>
                </td>
                <td class="manual-subtotal">${formatRupiah(subtotal)}</td>
                <td>
                    <button class="btn-danger" type="button" data-delete-item="${id}">Hapus</button>
                </td>
            </tr>
        `;
    });

    manualCartBody.innerHTML = html;

    manualCartBody.querySelectorAll('[data-save-qty]').forEach((button) => {
        button.addEventListener('click', function () {
            const productId = Number(this.getAttribute('data-save-qty'));
            const input = manualCartBody.querySelector(`[data-qty-input="${productId}"]`);
            const product = cashierProductMap.get(productId);
            if (!input || !product) return;

            const stock = Number(product.stock) || 1;
            let qty = Number.parseInt(input.value, 10);
            if (!Number.isFinite(qty) || qty < 1) qty = 1;
            if (qty > stock) qty = stock;

            cashierCart[productId] = qty;
            renderManualCart();
        });
    });

    manualCartBody.querySelectorAll('[data-delete-item]').forEach((button) => {
        button.addEventListener('click', function () {
            const productId = Number(this.getAttribute('data-delete-item'));
            delete cashierCart[productId];
            renderManualCart();
        });
    });

    persistManualPayload();
    renderManualTotal();
}

function addProductToManualCart(productId) {
    const id = Number(productId);
    const product = cashierProductMap.get(id);
    if (!product) return;

    const currentQty = Number(cashierCart[id] || 0);
    const stock = Number(product.stock) || 0;

    if (stock < 1) return;

    cashierCart[id] = Math.min(currentQty + 1, stock);
    renderManualCart();
}

function selectCustomer(customerId) {
    const id = Number(customerId);
    const customer = cashierCustomerMap.get(id);
    if (!customer || !manualCustomerIdInput || !customerSearchInput || !customerSearchResults) return;

    manualCustomerIdInput.value = String(id);
    customerSearchInput.value = customer.name || '';
    customerSearchResults.style.display = 'none';
}

function renderCustomerSearch(keyword) {
    if (!customerSearchResults || !customerSearchInput) return;

    const normalized = (keyword || '').toLowerCase().trim();
    const matched = cashierCustomers
        .filter((customer) => {
            if (!normalized) return true;
            const name = String(customer.name || '').toLowerCase();
            return name.includes(normalized);
        })
        .slice(0, 8);

    if (matched.length === 0) {
        customerSearchResults.innerHTML = '<div class="search-empty">Customer tidak ditemukan.</div>';
        customerSearchResults.style.display = 'block';
        return;
    }

    customerSearchResults.innerHTML = matched.map((customer) => `
        <button type="button" class="search-item-btn" data-customer-id="${Number(customer.id)}">
            <span class="search-item-name">${escapeHtml(customer.name || 'Customer')}</span>
            <span class="search-item-meta">ID: ${Number(customer.id)}</span>
        </button>
    `).join('');

    customerSearchResults.style.display = 'block';

    customerSearchResults.querySelectorAll('[data-customer-id]').forEach((button) => {
        button.addEventListener('click', function () {
            selectCustomer(this.getAttribute('data-customer-id'));
        });
    });
}

function renderCashierSearch(keyword) {
    if (!cashierSearchResults || !cashierSearchInput) return;

    const normalized = (keyword || '').toLowerCase().trim();
    const matched = cashierProducts
        .filter((product) => {
            const stock = Number(product.stock) || 0;
            if (stock < 1) return false;
            if (!normalized) return true;

            const name = String(product.name || '').toLowerCase();
            const category = String(product.category || '').toLowerCase();

            return name.includes(normalized) || category.includes(normalized);
        })
        .slice(0, 8);

    if (matched.length === 0) {
        cashierSearchResults.innerHTML = '<div class="search-empty">Produk tidak ditemukan.</div>';
        cashierSearchResults.style.display = 'block';
        return;
    }

    cashierSearchResults.innerHTML = matched.map((product) => {
        const category = escapeHtml(product.category || 'Produk');
        return `
            <button type="button" class="search-item-btn" data-product-id="${Number(product.id)}">
                <span class="search-item-name">${escapeHtml(product.name)}</span>
                <span class="search-item-meta">${category} | ${formatRupiah(product.price)} | stok ${Number(product.stock)}</span>
            </button>
        `;
    }).join('');

    cashierSearchResults.style.display = 'block';

    cashierSearchResults.querySelectorAll('[data-product-id]').forEach((button) => {
        button.addEventListener('click', function () {
            const productId = Number(this.getAttribute('data-product-id'));
            addProductToManualCart(productId);
            cashierSearchInput.value = '';
            cashierSearchResults.style.display = 'none';
        });
    });
}

if (customerSearchInput && customerSearchResults && manualCustomerIdInput) {
    customerSearchInput.addEventListener('focus', function () {
        renderCustomerSearch(this.value);
    });

    customerSearchInput.addEventListener('input', function () {
        const selectedCustomer = cashierCustomerMap.get(Number(manualCustomerIdInput.value || 0));
        if (!selectedCustomer || selectedCustomer.name !== this.value) {
            manualCustomerIdInput.value = '';
        }

        renderCustomerSearch(this.value);
    });
}

if (cashierSearchInput && cashierSearchResults) {
    cashierSearchInput.addEventListener('focus', function () {
        renderCashierSearch(this.value);
    });

    cashierSearchInput.addEventListener('input', function () {
        renderCashierSearch(this.value);
    });
}

document.addEventListener('click', function (event) {
    if (customerSearchResults && customerSearchInput) {
        if (!customerSearchResults.contains(event.target) && event.target !== customerSearchInput) {
            customerSearchResults.style.display = 'none';
        }
    }

    if (cashierSearchResults && cashierSearchInput) {
        if (!cashierSearchResults.contains(event.target) && event.target !== cashierSearchInput) {
            cashierSearchResults.style.display = 'none';
        }
    }
});

if (manualItemsPayload && manualItemsPayload.value) {
    try {
        const oldItems = JSON.parse(manualItemsPayload.value);
        if (Array.isArray(oldItems)) {
            oldItems.forEach((item) => {
                const productId = Number(item.product_id || 0);
                const qty = Number(item.qty || 0);
                const product = cashierProductMap.get(productId);
                if (!product || qty < 1) return;

                const stock = Number(product.stock) || qty;
                cashierCart[productId] = Math.min(qty, stock);
            });
        }
    } catch (error) {
        manualItemsPayload.value = '';
    }
}

if (manualOrderForm) {
    manualOrderForm.addEventListener('submit', function (event) {
        persistManualPayload();

        const selectedCustomerId = Number(manualCustomerIdInput ? manualCustomerIdInput.value : 0);
        if (!Number.isFinite(selectedCustomerId) || selectedCustomerId < 1) {
            event.preventDefault();
            alert('Pilih customer terlebih dahulu dari hasil pencarian.');
            return;
        }

        const payload = manualItemsPayload ? manualItemsPayload.value : '';
        if (!payload || payload === '[]') {
            event.preventDefault();
            alert('Tambahkan minimal 1 produk ke keranjang kasir.');
            return;
        }
    });
}

renderManualCart();
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>