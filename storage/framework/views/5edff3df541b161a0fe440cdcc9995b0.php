<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Koperasi</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        /* =========================================
           GLOBAL STYLE
           ========================================= */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6f9;
            margin: 0;
            color: #2c3e50;
        }

        /* =========================================
           LAYOUT UTAMA
           ========================================= */
        .container {
            max-width: 900px;
            margin: 50px auto; /* Jarak atas bawah diperbesar sedikit */
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 20px; /* Sudut melengkung modern */
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); /* Bayangan lembut */
        }

        /* =========================================
           TOMBOL & INTERAKSI
           ========================================= */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e6f0ff;
            color: #005bfd;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #cce0ff;
        }

        /* =========================================
           TABEL KERANJANG
           ========================================= */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th {
            padding: 15px 10px;
            text-align: left;
            color: #888;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 20px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            font-weight: 500;
        }

        .product-name {
            font-weight: 700;
            font-size: 16px;
        }

        .text-muted {
            color: #666;
            font-size: 14px;
            font-weight: 600;
        }

        /* =========================================
           FORM UPDATE QTY
           ========================================= */
        .qty-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            font-family: inherit;
            font-weight: bold;
            outline: none;
            transition: 0.3s;
        }

        .qty-input:focus {
            border-color: #005bfd;
        }

        .btn-update {
            background: #f4f6f9;
            color: #005bfd;
            border: none;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-family: inherit;
            transition: 0.2s;
        }

        .btn-update:hover {
            background: #005bfd;
            color: white;
        }

        .btn-remove {
            background: #ffe5e5;
            color: #FF4D4D;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
            transition: 0.2s;
        }

        .btn-remove:hover {
            background: #ffcccc;
        }

        /* =========================================
           BAGIAN TOTAL & CHECKOUT
           ========================================= */
        .checkout-area {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-top: 30px;
            padding-top: 20px;
        }

        .total-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .total-label {
            font-size: 16px;
            color: #666;
            font-weight: 600;
        }

        .total-amount {
            font-size: 28px;
            font-weight: 800;
            color: #2c3e50;
        }

        .btn-checkout {
            background: #005bfd;
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 4px 15px rgba(0, 91, 253, 0.3);
            transition: 0.3s ease;
        }

        .btn-checkout:hover {
            background: #0046c7;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 91, 253, 0.4);
        }

        /* =========================================
           STATE KERANJANG KOSONG
           ========================================= */
        .empty-cart {
            text-align: center;
            padding: 60px 0;
        }

        .empty-cart p {
            color: #888;
            font-size: 16px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">

        <a href="<?php echo e(route('user.belanja')); ?>" class="btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali Belanja
        </a>

        <?php if(session('success')): ?>
            <div style="margin-top: 16px; padding: 12px 14px; border-radius: 10px; background: #e6f9ee; color: #166534; border: 1px solid #86efac; font-size: 14px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div style="margin-top: 16px; padding: 12px 14px; border-radius: 10px; background: #ffeaea; color: #b42318; border: 1px solid #fecaca; font-size: 14px;">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if(empty($cart)): ?>
            <div class="empty-cart">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 15px;">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <p>Keranjang Anda masih kosong.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td class="product-name">
                                <?php echo e($item['name']); ?>

                            </td>
                            <td class="text-muted">
                                Rp <?php echo e(number_format($item['price'], 0, ',', '.')); ?>

                            </td>
                            <td>
                                <form action="<?php echo e(route('user.cart.update', $id)); ?>" method="POST" class="qty-form">
                                    <?php echo csrf_field(); ?>
                                    <input type="number" name="qty" class="qty-input" value="<?php echo e($item['qty']); ?>" min="1">
                                    <button class="btn-update">Simpan</button>
                                </form>
                            </td>
                            <td style="font-weight: 700; color: #2c3e50;">
                                Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('user.cart.remove', $id)); ?>" class="btn-remove">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="checkout-area">
                <div class="total-wrapper">
                    <span class="total-label">Total Pembayaran:</span>
                    <span class="total-amount">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                </div>

                <form action="<?php echo e(route('user.checkout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn-checkout">Lanjutkan Checkout</button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/user/cart.blade.php ENDPATH**/ ?>