<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar Koperasi BTN</title>

    <link rel="stylesheet" href="<?php echo e(asset('user/css/landing.css')); ?>" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;700;800&display=swap"
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
        <li><a href="<?php echo e(route('user.landing')); ?>" class="nav-item active">Beranda</a></li>
        <li><a href="<?php echo e(route('user.belanja')); ?>" class="nav-item">Belanja</a></li>
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

    <section class="hero-section">
      <div class="container">
        <div class="main-banner">
          <div class="banner-logo">
            <img src="<?php echo e(asset('user/assets/logo.png')); ?>" alt="Logo Koperasi" />
          </div>
          <div class="banner-content">
            <h1>
              Selamat datang
              <span class="highlight"
                >di <br />
                Koperasi Batara Gora</span
              >
            </h1>
            <p class="banner-desc">
              Sistem Koperasi Internal Bank BTN. Gunakan saldo plafon Anda untuk
              belanja ATK, Snack, dan Minuman tanpa uang tunai.
            </p>
            <a href="<?php echo e(route('user.belanja')); ?>" class="btn-cta">Lihat Katalog Sekarang</a>
          </div>
        </div>

        <div class="features-grid">
          <div class="feature-card">
            <div class="icon-circle pink-bg">
              <img src="<?php echo e(asset('user/assets/icon1.png')); ?>" alt="Belanja ATK" />
            </div>
            <h3>Belanja ATK & Snack</h3>
            <p>Belanja kebutuhan kantor dan camilan.</p>
          </div>

          <div class="feature-card">
            <div class="icon-circle grey-bg">
              <img src="<?php echo e(asset('user/assets/icon2.png')); ?>" alt="Tanpa Tunai" />
            </div>
            <h3>Tanpa Uang Tunai</h3>
            <p>Bayar di akhir bulan dengan bayar nanti.</p>
          </div>

          <div class="feature-card">
            <div class="icon-circle grey-bg">
              <img src="<?php echo e(asset('user/assets/icon3.png')); ?>" alt="Riwayat Belanja" />
            </div>
            <h3>Riwayat Belanja</h3>
            <p>Lihat riwayat belanja anda dengan mudah.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="about-section">
      <div class="container">
        <div class="about-card">
          <div class="about-content">
            <span class="badge-blue">TENTANG KAMI</span>
            <h2>Mitra Kesejahteraan <br> <span class="highlight">Karyawan Bank BTN</span></h2>
            <p>
              Koperasi Batara Gora hadir sebagai solusi finansial internal yang transparan.
              Kami menyediakan fasilitas pinjam dan pengadaan kebutuhan harian.
            </p>

            <ul class="feature-list">
              <li>
                <div class="check-icon">
                  <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 5L4.5 8.5L13 1" stroke="#00C853" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                Tanpa bunga pinjaman khusus karyawan
              </li>
              <li>
                <div class="check-icon">
                  <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 5L4.5 8.5L13 1" stroke="#00C853" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                Diawasi langsung oleh manajemen BTN
              </li>
            </ul>
          </div>

          <div class="about-image-wrapper">
            <img src="<?php echo e(asset('user/assets/office_btn.png')); ?>" alt="Kantor BTN" class="about-img">

            <div class="stats-card">
              <span class="stats-title">TOTAL ANGGOTA</span>
              <span class="stats-number">120+ Pegawai</span>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class="product-section">
      <div class="container">
        <h2 class="section-title">Pilihan Hari Ini Untuk Kamu</h2>

        <div class="product-grid">
          <?php if(isset($products) && count($products) > 0): ?>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $productImage = !empty($product->image)
                  ? asset('storage/'.$product->image)
                  : asset('user/assets/cimori.png');
                $productCategory = $product->category ?? 'Produk';
                $productDescription = $product->description ?? 'Deskripsi belum tersedia.';
                $productPrice = $product->price ?? 0;
              ?>

              <div class="product-card">
                <span class="badge-category"><?php echo e($productCategory); ?></span>
                <div class="product-img-wrapper">
                  <img src="<?php echo e($productImage); ?>" alt="<?php echo e($product->name ?? 'Produk'); ?>">
                </div>
                <div class="product-info">
                  <h3><?php echo e($product->name ?? 'Produk'); ?></h3>
                  <p class="product-desc"><?php echo e($productDescription); ?></p>
                  <p class="product-price">Rp. <?php echo e(number_format($productPrice, 0, ',', '.')); ?></p>
                  <form action="<?php echo e(route('user.cart.add', $product->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <a
                      href="#"
                      class="btn-add-cart"
                      onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                      Masukan Keranjang
                      <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 9L5 5L1 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </form>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
            <p style="text-align:center; width:100%; color:#666;">Belum ada produk yang ditampilkan.</p>
          <?php endif; ?>
        </div>

        <div class="more-button-wrapper">
          <a href="<?php echo e(route('user.belanja')); ?>" class="btn-see-more">Lihat Selengkapnya!</a>
        </div>

      </div>
    </section>

    <footer class="footer-section">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-col">
            <h3>Kantor Cabang Pembantu</h3>
            <p class="address-text">
              <strong>Bank BTN KCP Cakranegara</strong><br>
              Jl. Pejanggik No. 115, Cakranegara<br>
              Mataram, Nusa Tenggara Barat<br>
              Indonesia
            </p>

            <div class="contact-info">
              <p>📞 1500286 (Contact Center)</p>
              <p>📠 (0370) 633xxx (Fax)</p>
            </div>

            <div class="social-icons">
              <a href="#"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
              <a href="#"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
              <a href="#"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></a>
              <a href="#"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="white"></polygon></svg></a>
            </div>
          </div>

          <div class="footer-col">
            <h3>Pusat Bantuan</h3>
            <ul class="footer-links">
              <li><a href="#">Layanan Pengaduan</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">Lokasi ATM</a></li>
            </ul>
          </div>

          <div class="footer-col">
            <h3>Ekosistem Digital</h3>
            <ul class="footer-links">
              <li><a href="#">BTN Properti ↗</a></li>
              <li><a href="#">Rumah Murah BTN ↗</a></li>
              <li><a href="#">Smart Residence ↗</a></li>
              <li><a href="#">balé by BTN</a></li>
            </ul>
          </div>

          <div class="footer-col">
            <h3>Panduan & Informasi</h3>
            <ul class="footer-links">
              <li><a href="#">Ketentuan Penggunaan</a></li>
              <li><a href="#">Kebijakan Privasi</a></li>
              <li><a href="#">Procurement</a></li>
              <li><a href="#">Sitemap</a></li>
            </ul>
          </div>

        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
          <p>BTN berizin dan diawasi oleh Otoritas Jasa Keuangan & Bank Indonesia serta merupakan peserta penjaminan LPS.</p>
          <p>Maksimum nilai simpanan yang dijamin LPS per nasabah per bank adalah Rp 2 miliar.</p>
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
                    <input type="text" id="nip" name="nip" value="<?php echo e(old('nip')); ?>" placeholder="Contoh: 19902022..." required>
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

                <div class="form-actions">
                    <a href="#" class="forgot-pass">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="btn-submit-login">Masuk Sekarang</button>
            </form>
        </div>
    </div>
    <script src="<?php echo e(asset('user/js/navbar.js')); ?>"></script>
  </body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/user/landing.blade.php ENDPATH**/ ?>