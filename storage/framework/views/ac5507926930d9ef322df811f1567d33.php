<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Belanja - Koperasi BTN</title>

    <link rel="stylesheet" href="<?php echo e(asset('user/css/landing.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('user/css/riwayat.css')); ?>" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>  
    <nav class="navbar">
      <div class="logo-container">
        <img src="<?php echo e(asset('user/assets/logo_1.png')); ?>" alt="Logo BTN" class="logo-img" />
        <span class="logo-text">Coop</span>
      </div>

      <ul class="nav-links">
        <li><a href="<?php echo e(route('user.landing')); ?>" class="nav-item">Beranda</a></li>
        <li><a href="<?php echo e(route('user.belanja')); ?>" class="nav-item">Belanja</a></li>
        <li><a href="<?php echo e(route('user.riwayat')); ?>" class="nav-item active">Riwayat Belanja</a></li>
        <li><a href="<?php echo e(route('user.pinjaman')); ?>" class="nav-item">Pinjaman</a></li>
      </ul>

      <div class="auth-button">
        
        <?php if(auth()->guard()->guest()): ?>
        <a href="#" class="btn-login">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 21C20 19.6044 20 18.9067 19.8278 18.3389C19.44 17.0605 18.4395 16.06 17.1611 15.6722C16.5933 15.5 15.8956 15.5 14.5 15.5H9.5C8.10444 15.5 7.40665 15.5 6.83886 15.6722C5.56045 16.06 4.56004 17.0605 4.17224 18.3389C4 18.9067 4 19.6044 4 21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Login
        </a>
        <?php endif; ?>

        
        <?php if(auth()->guard()->check()): ?>
        <div class="user-logged-in" style="display: flex; align-items: center; gap: 15px;">
            
            
            <a href="<?php echo e(route('user.cart')); ?>" class="btn-cart" style="position: relative; color: #2c3e50; background: white; padding: 8px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd; width: 40px; height: 40px; box-sizing: border-box;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                
                <?php if(collect(session('cart', []))->sum('qty') > 0): ?>
                    <span style="position: absolute; top: -5px; right: -5px; background: #FF4D4D; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold;">
                        <?php echo e(collect(session('cart', []))->sum('qty')); ?>

                    </span>
                <?php endif; ?>
            </a>

            
            <a href="#" class="btn-profile" style="background-color: #005bfd; color: white; padding: 10px 20px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 14C8 14 9.5 16 12 16C14.5 16 16 14 16 14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 9H9.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15 9H15.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Hai, <?php echo e(Auth::user()->name); ?>

            </a>

            
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout" title="Keluar" style="background: white; border: 1px solid #ffe5e5; padding: 8px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="#FF4D4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 17L21 12L16 7" stroke="#FF4D4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12H9" stroke="#FF4D4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
        </div>
        <?php endif; ?>
      </div>
    </nav>

    <div class="history-wrapper">
      <div class="container">
        <div class="history-header">
          <h1>Riwayat Belanja</h1>

          <div class="dropdown">
            <button class="btn-dropdown">
              Terbaru
              <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1.5L6 6.5L11 1.5" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>

        <?php if(session('success')): ?>
          <div style="margin-bottom: 16px; padding: 12px 14px; border-radius: 10px; background: #e6f9ee; color: #166534; border: 1px solid #86efac; font-size: 14px;">
            <?php echo e(session('success')); ?>

          </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
          <div style="margin-bottom: 16px; padding: 12px 14px; border-radius: 10px; background: #ffeaea; color: #b42318; border: 1px solid #fecaca; font-size: 14px;">
            <?php echo e(session('error')); ?>

          </div>
        <?php endif; ?>

        <div class="order-list">
          <?php if($orders->isEmpty()): ?>
              <div class="order-card">
                <div class="card-body">
                  <div class="summary-text">
                    <h4>Belum ada riwayat belanja.</h4>
                    <p>Transaksi akan muncul setelah kamu checkout.</p>
                  </div>
                </div>
              </div>
          <?php else: ?>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $thumbImage = $order->thumb
                  ? asset('storage/'.$order->thumb)
                  : asset('user/assets/cimori.png');

                if ($order->total_qty > 1) {
                  $summaryTitle = '+' . $order->other_items . ' item lainnya';
                } elseif ($order->total_qty === 1) {
                  $summaryTitle = '1 item';
                } else {
                  $summaryTitle = 'Belum ada item';
                }

                $summaryLine = $order->category_summary ?: 'Item belum tersedia';
                $orderDateTime = $order->tanggal !== '-'
                  ? $order->tanggal . ($order->waktu ? ', Pkl ' . $order->waktu : '')
                  : '-';
              ?>

              <div class="order-card">
                <div class="card-top">
                  <div class="order-id">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#005BFD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span>Pesanan <?php echo e($order->kode); ?></span>
                  </div>
                  <span class="order-date"><?php echo e($orderDateTime); ?></span>
                </div>

                <hr class="card-divider">

                <div class="card-body">
                  <div class="product-summary">
                    <img src="<?php echo e($thumbImage); ?>" alt="Produk Thumbnail" class="thumb-img">
                    <div class="summary-text">
                      <h4><?php echo e($summaryTitle); ?></h4>
                      <p><?php echo e($summaryLine); ?></p>
                    </div>
                  </div>

                  <div class="price-section">
                    <h3>Rp. <?php echo e(number_format($order->total ?? 0, 0, ',', '.')); ?></h3>
                  </div>
                </div>

                <div class="card-footer">
                  <a href="<?php echo e(route('user.riwayat.detail', $order->id)); ?>" class="link-detail">Lihat Detail ></a>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div id="loginModal" class="modal-overlay <?php echo e($errors->login->any() ? 'show-modal' : ''); ?>">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-header">
                <h2>Masuk Akun</h2>
                <p>Silakan masuk menggunakan akun pegawai Anda.</p>
            </div>
            <form class="login-form" method="POST" action="<?php echo e(route('login.proses')); ?>">
                <?php echo csrf_field(); ?>
                <?php if($errors->login->any()): ?>
                    <div style="background-color: #ffe6e6; color: #d63031; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border: 1px solid #fab1a0; text-align: center; font-weight: 600;">
                        ⚠️ <?php echo e($errors->login->first('login') ?? $errors->login->first('nip') ?? $errors->login->first('password')); ?>

                    </div>
                <?php endif; ?>
                <div class="input-group">
                    <label for="nip">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" id="nip" name="nip" value="<?php echo e(old('nip')); ?>" placeholder="Contoh: 12345" required>
                    <?php if($errors->login->has('nip')): ?>
                      <small style="display:block; margin-top: 6px; color: #d63031;"><?php echo e($errors->login->first('nip')); ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
                    <?php if($errors->login->has('password')): ?>
                      <small style="display:block; margin-top: 6px; color: #d63031;"><?php echo e($errors->login->first('password')); ?></small>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-submit-login">Masuk Sekarang</button>
            </form>
        </div>
    </div>
    <script src="<?php echo e(asset('user/js/navbar.js')); ?>"></script>
  </body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/user/riwayat.blade.php ENDPATH**/ ?>