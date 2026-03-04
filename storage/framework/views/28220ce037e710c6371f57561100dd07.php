<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title','User'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <link rel="stylesheet" href="<?php echo e(asset('user/css/landing.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('user/css/belanja.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('user/css/pinjaman.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('user/css/riwayat.css')); ?>">

</head>
<body>


<div class="navbar">

    <div class="nav-left">
        <img src="<?php echo e(asset('user/assets/logo_1.png')); ?>" height="40">
        <span>Koperasi User</span>
    </div>

    <div class="nav-right">

        <a href="<?php echo e(route('user.landing')); ?>">Home</a>

        <a href="<?php echo e(route('user.belanja')); ?>">Belanja</a>

        <a href="<?php echo e(route('user.pinjaman')); ?>">Pinjaman</a>

        <a href="<?php echo e(route('user.riwayat')); ?>">Riwayat</a>

        <form method="POST" action="<?php echo e(route('user.logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit">Logout</button>
        </form>

    </div>

</div>



<div class="container">

    <?php echo $__env->yieldContent('content'); ?>

</div>


</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/user/user.blade.php ENDPATH**/ ?>