<?php $__env->startSection('title','Status Peminjaman | Admin'); ?>

<?php $__env->startSection('content'); ?>

<style>
.pinjaman-page h3{
  margin:0;
}

.pinjaman-page .toolbar{
  display:flex;
  justify-content:space-between;
  align-items:flex-end;
  gap:10px;
  flex-wrap:wrap;
  margin-bottom:14px;
}

.pinjaman-page .filter-form{
  margin:0;
  min-width:220px;
}

.pinjaman-page .field-control{
  width:100%;
  border:1px solid #cbd5e1;
  border-radius:10px;
  padding:10px 12px;
  font-size:14px;
  color:#0f172a;
  background:#ffffff;
  transition:border-color .2s ease, box-shadow .2s ease;
}

.pinjaman-page .field-control:focus{
  outline:none;
  border-color:#2563eb;
  box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}

.pinjaman-page .field-select{
  appearance:none;
  -webkit-appearance:none;
  -moz-appearance:none;
  padding-right:38px;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M5.5 7.5L10 12L14.5 7.5' stroke='%2364748B' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
  background-repeat:no-repeat;
  background-position:right 12px center;
  background-size:16px 16px;
}

.pinjaman-page .card{
  background:white;
  border-radius:14px;
  padding:20px;
  box-shadow:0 10px 25px rgba(0,0,0,0.08);
  text-align:left;
  cursor:default;
}

.pinjaman-page .card:hover{
  transform:none;
}

.pinjaman-page .table-wrap{
  width:100%;
  overflow:auto;
  border:1px solid #e5e7eb;
  border-radius:10px;
}

.pinjaman-page table{
  width:100%;
  border-collapse:collapse;
}

.pinjaman-page th{
  background:#1f2937;
  color:white;
  padding:12px;
  text-align:left;
  font-size:14px;
}

.pinjaman-page td{
  padding:12px;
  border-bottom:1px solid #e5e7eb;
  font-size:14px;
}

.pinjaman-page .badge{
  padding:6px 14px;
  border-radius:20px;
  font-size:12px;
  font-weight:bold;
  color:white;
  display:inline-block;
}

.pinjaman-page .MENUNGGU{background:#f59e0b;}
.pinjaman-page .DISETUJUI{background:#22c55e;}
.pinjaman-page .LUNAS{background:#3b82f6;}
.pinjaman-page .DITOLAK{background:#ef4444;}

.pinjaman-page .btn{
  padding:6px 12px;
  border-radius:6px;
  font-size:12px;
  border:none;
  cursor:pointer;
  color:white;
}

.pinjaman-page .btn-approve{background:#22c55e;}
.pinjaman-page .btn-reject{background:#ef4444;}
.pinjaman-page .btn-detail{background:#3b82f6;}

.pinjaman-page .btn + .btn{
  margin-left:6px;
}
</style>

<div class="pinjaman-page">
  <div class="toolbar">
    <h3>Status Peminjaman (Admin)</h3>

    <form class="filter-form" method="GET" action="<?php echo e(route('admin.pinjaman')); ?>">
      <select class="field-control field-select" name="status" onchange="this.form.submit()">
        <option value="ALL" <?php echo e($status=='ALL'?'selected':''); ?>>Semua Status</option>
        <option value="MENUNGGU" <?php echo e($status=='MENUNGGU'?'selected':''); ?>>Menunggu</option>
        <option value="DISETUJUI" <?php echo e($status=='DISETUJUI'?'selected':''); ?>>Disetujui</option>
        <option value="LUNAS" <?php echo e($status=='LUNAS'?'selected':''); ?>>Lunas</option>
        <option value="DITOLAK" <?php echo e($status=='DITOLAK'?'selected':''); ?>>Ditolak</option>
      </select>
    </form>
  </div>

  <div class="card">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Peminjam</th>
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
              <td><?php echo e($l->nama_peminjam); ?></td>
              <td>Rp <?php echo e(number_format($l->jumlah,0,',','.')); ?></td>
              <td><?php echo e($l->tenor); ?> Bulan</td>
              <td><span class="badge <?php echo e($l->status); ?>"><?php echo e($l->status); ?></span></td>
              <td>
                <?php if($l->status === 'MENUNGGU'): ?>
                  <form method="POST"
                        action="<?php echo e(route('admin.pinjaman.approve',$l->id)); ?>"
                        style="display:inline">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-approve"
                            onclick="return confirm('Setujui pinjaman ini?')">
                      Setujui
                    </button>
                  </form>

                  <form method="POST"
                        action="<?php echo e(route('admin.pinjaman.reject',$l->id)); ?>"
                        style="display:inline">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-reject"
                            onclick="return confirm('Tolak pinjaman ini?')">
                      Tolak
                    </button>
                  </form>
                <?php else: ?>
                  <a href="<?php echo e(route('admin.pinjaman.show',$l->id)); ?>"
                     class="btn btn-detail">
                    Detail
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" align="center">Tidak ada data pinjaman</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/pinjaman.blade.php ENDPATH**/ ?>