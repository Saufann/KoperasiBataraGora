<?php $__env->startSection('title','Riwayat Pinjaman User'); ?>

<?php $__env->startSection('content'); ?>

<style>
.user-loan-page .card{
    margin-top:15px;
}

.user-loan-page .footer-actions{
    margin-top:14px;
}
</style>

<div class="user-loan-page">
    <div class="section-header">
        <div>
            <h3 class="section-title">Riwayat Pinjaman - <?php echo e($nama ?? '-'); ?></h3>
            <p class="section-subtitle">Daftar pinjaman user beserta status terakhir.</p>
        </div>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Jumlah</th>
                        <th>Tenor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($l->kode); ?></td>
                            <td>Rp <?php echo e(number_format($l->jumlah ?? 0,0,',','.')); ?></td>
                            <td><?php echo e($l->tenor ?? '-'); ?> Bulan</td>
                            <td>
                                <span class="badge <?php echo e($l->status ?? ''); ?>">
                                    <?php echo e($l->status ?? '-'); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.pinjaman.show',$l->id)); ?>" class="btn btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="empty-state">User ini belum memiliki pinjaman</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer-actions">
        <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-cancel">
            ← Kembali ke Data User
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/user-pinjaman.blade.php ENDPATH**/ ?>