<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Belanja - Koperasi BTN</title>

    <link rel="stylesheet" href="<?php echo e(asset('user/css/landing.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('user/css/belanja.css')); ?>" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;600;700;800&display=swap"
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
        <li><a href="<?php echo e(route('user.belanja')); ?>" class="nav-item active">Belanja</a></li>
        <li><a href="<?php echo e(route('user.riwayat')); ?>" class="nav-item">Riwayat Belanja</a></li>
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
            
            
            <a href="<?php echo e(route('user.cart')); ?>" class="btn-cart" style="position: relative; color: #2c3e50; background: white; padding: 8px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                
                <?php if(collect(session('cart', []))->sum('qty') > 0): ?>
                    <span style="position: absolute; top: -5px; right: -5px; background: #FF4D4D; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold;">
                        <?php echo e(collect(session('cart', []))->sum('qty')); ?>

                    </span>
                <?php endif; ?>
            </a>

            
            <a href="#" class="btn-profile" style="background-color: #005bfd; color: white; padding: 10px 20px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 14C8 14 9.5 16 12 16C14.5 16 16 14 16 14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Hai, <?php echo e(Auth::user()->name); ?>

            </a>
            
            
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout" title="Keluar" style="background: white; border: 1px solid #ffe5e5; padding: 8px; border-radius: 50%; cursor: pointer;">
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

    <div class="shop-wrapper">
      <div class="container">
        <header class="shop-header">
          <h1 class="shop-title">Katalog Barang Koperasi</h1>
          <p class="shop-subtitle">Pilih kebutuhan anda mudah dan cepat</p>

          
          <?php if(auth()->guard()->check()): ?>
          <div class="search-container" style="margin: 20px 0; position: relative; width: 100%; max-width: 500px;">
            <input type="text" id="searchInput" placeholder="Cari barang (contoh: Wafer)..." style="width: 100%; padding: 12px 20px 12px 40px; border-radius: 30px; border: 1px solid #ccc; font-family: inherit; font-size: 14px; outline: none; box-sizing: border-box; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>
          <?php endif; ?>

          
          <div class="filter-buttons" style="margin-top: 10px;">
            <button class="filter-btn active" data-filter="semua"><span class="check-box">✔</span> Semua</button>
            <button class="filter-btn" data-filter="snack"><span class="check-box-outline"></span> Snack</button>
            <button class="filter-btn" data-filter="drink"><span class="check-box-outline"></span> Drink</button>
            <button class="filter-btn" data-filter="atk"><span class="check-box-outline"></span> ATK</button>
          </div>
        </header>

        <div class="product-grid">
          <?php $visibleLimit = 10; ?>

          <?php if(count($products) === 0): ?>
            <p>Belum ada produk.</p>
          <?php else: ?>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $isHidden = $loop->iteration > $visibleLimit;
                $productImage = !empty($product->image) ? asset('storage/'.$product->image) : asset('user/assets/cimori.png');
                $productPrice = $product->price ?? 0;
              ?>

              
              <div class="product-card<?php echo e($isHidden ? ' hidden-item' : ''); ?>" data-category="<?php echo e(strtolower($product->category ?? 'lainnya')); ?>">
                <span class="badge-category"><?php echo e($product->category ?? 'Produk'); ?></span>
                <div class="product-img-wrapper">
                  <img src="<?php echo e($productImage); ?>" alt="<?php echo e($product->name ?? 'Produk'); ?>" />
                </div>
                <div class="product-info">
                  <h3><?php echo e($product->name ?? 'Produk'); ?></h3>
                  <p class="product-desc"><?php echo e($product->description ?? 'Deskripsi belum tersedia.'); ?></p>
                  <p class="product-price">Rp. <?php echo e(number_format($productPrice, 0, ',', '.')); ?></p>

                  
                  <?php if(auth()->guard()->check()): ?>
                    <a href="#" class="btn-add-cart open-cart-modal" 
                       data-id="<?php echo e($product->id); ?>"
                       data-name="<?php echo e($product->name ?? 'Produk'); ?>"
                       data-price="<?php echo e($productPrice); ?>"
                       data-image="<?php echo e($productImage); ?>"
                       data-url="<?php echo e(route('user.cart.add', $product->id)); ?>">
                      Masukan Keranjang
                    </a>
                  <?php endif; ?>

                  <?php if(auth()->guard()->guest()): ?>
                    <a href="#" class="btn-add-cart open-login-modal" onclick="document.getElementById('loginModal').style.display='flex'; return false;">
                      Masukan Keranjang
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </div>

        <?php if(count($products) > $visibleLimit): ?>
          <div class="load-more-container">
            <button id="loadMoreBtn" class="btn-load-more">Muat Lebih Banyak</button>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <footer class="footer-section">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-col">
            <h3>Kantor Cabang Pembantu</h3>
            <p class="address-text">
              <strong>Bank BTN KCP Cakranegara</strong><br />
              Jl. Pejanggik No. 115, Cakranegara<br />
              Mataram, Nusa Tenggara Barat
            </p>
            <div class="contact-info">
              <p>📞 1500286 (Contact Center)</p>
              <p>📠 (0370) 633xxx (Fax)</p>
            </div>
          </div>
        </div>
        <hr class="footer-divider" />
        <div class="footer-bottom">
          <p>BTN berizin dan diawasi oleh OJK & Bank Indonesia.</p>
        </div>
      </div>
    </footer>

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

    
    <div id="cartModal" class="modal-overlay" style="display: none;">
        <div class="modal-content" style="max-width: 350px; text-align: center; padding: 25px;">
            <span class="close-cart-btn close-btn" style="cursor: pointer; float: right; font-size: 24px; font-weight: bold;">&times;</span>
            
            <h3 id="modalProductName" style="margin-top: 10px; font-size: 18px; color: #2c3e50;">Nama Produk</h3>
            
            <img id="modalProductImage" src="" alt="Product" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; margin: 15px auto; border: 1px solid #eee;">
            
            <p id="modalProductPrice" style="font-weight: bold; font-size: 18px; color: #005bfd; margin-bottom: 20px;">Rp. 0</p>

            <form id="cartForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                
                
                <div style="display: flex; justify-content: center; align-items: center; gap: 15px; margin: 20px 0; background: #f4f6f9; padding: 10px; border-radius: 50px;">
                    <button type="button" id="btnMinus" style="width: 35px; height: 35px; border-radius: 50%; border: none; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); cursor: pointer; font-size: 18px; font-weight: bold; color: #333;">-</button>
                    
                    
                    <input type="number" id="qtyInput" name="qty" value="1" min="1" style="width: 50px; text-align: center; border: none; background: transparent; font-size: 16px; font-weight: bold; outline: none;">
                    
                    <button type="button" id="btnPlus" style="width: 35px; height: 35px; border-radius: 50%; border: none; background: #005bfd; color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); cursor: pointer; font-size: 18px; font-weight: bold;">+</button>
                </div>

                <div style="margin-bottom: 20px; display: flex; justify-content: space-between; border-top: 1px dashed #ccc; padding-top: 15px;">
                    <span style="color: #666; font-size: 14px;">Subtotal: </span>
                    <strong id="modalSubtotal" style="font-size: 16px; color: #2c3e50;">Rp. 0</strong>
                </div>

                <button type="submit" class="btn-submit-login" style="width: 100%; border-radius: 30px;">Konfirmasi Keranjang</button>
            </form>
        </div>
    </div>

    <script src="<?php echo e(asset('user/js/navbar.js')); ?>"></script>
    <script src="<?php echo e(asset('user/js/belanja.js')); ?>"></script>
  </body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/user/belanja.blade.php ENDPATH**/ ?>