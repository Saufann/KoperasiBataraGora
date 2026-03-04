<?php $__env->startSection('title','Data User'); ?>

<?php $__env->startSection('content'); ?>

<style>
.users-page .card{
    margin-top:15px;
}

.users-page .action-group{
    min-width:220px;
}

.users-page .modal-body-info p{
    margin:0 0 8px;
    font-size:14px;
}

.users-page .modal-table th,
.users-page .modal-table td{
    font-size:13px;
    padding:10px;
}

@media(max-width:680px){
    .users-page .section-header{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>

<div class="users-page">
    <div class="section-header">
        <div>
            <h3 class="section-title">Data User</h3>
            <p class="section-subtitle">Kelola user, lihat riwayat belanja, dan akses riwayat pinjaman.</p>
        </div>

        <button class="btn btn-add" type="button" onclick="openAddUser()">
            + Tambah User
        </button>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Unit Kerja</th>
                        <th>Gaji</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>USR<?php echo e(str_pad($u->id,3,'0',STR_PAD_LEFT)); ?></td>
                            <td><?php echo e($u->nama); ?></td>
                            <td><?php echo e($u->nip); ?></td>
                            <td><?php echo e($u->unit_kerja); ?></td>
                            <td>Rp <?php echo e(number_format($u->gaji,0,',','.')); ?></td>
                            <td>
                                <span class="badge <?php echo e(strtoupper($u->status ?? '')); ?>">
                                    <?php echo e($u->status); ?>

                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button class="btn btn-detail" type="button" onclick="viewUser(<?php echo e($u->id); ?>)">
                                        Detail
                                    </button>

                                    <button class="btn btn-order" type="button" onclick="viewOrders(<?php echo e($u->id); ?>)">
                                        Belanja
                                    </button>

                                    <a class="btn btn-loan" href="<?php echo e(route('admin.user.pinjaman',['id'=>$u->id])); ?>">
                                        Pinjaman
                                    </a>

                                    <?php if(session('admin_role') === 'Super Admin'): ?>
                                        <button
                                            class="btn btn-edit"
                                            type="button"
                                            onclick="editUser(
                                                <?php echo e($u->id); ?>,
                                                '<?php echo e(addslashes($u->nama)); ?>',
                                                '<?php echo e(addslashes($u->unit_kerja)); ?>',
                                                <?php echo e($u->gaji); ?>,
                                                '<?php echo e($u->status); ?>'
                                            )"
                                        >
                                            Edit
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="empty-state">Tidak ada data user</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle"></h4>
            <span class="close" onclick="closeModal()">×</span>
        </div>
        <div id="modalBody"></div>
    </div>
</div>

<script>
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');

function openModal(title, body) {
    modalTitle.innerText = title;
    modalBody.innerHTML = body;
    modal.style.display = 'flex';
}

function closeModal() {
    modal.style.display = 'none';
}

window.addEventListener('click', function (event) {
    if (event.target === modal) {
        closeModal();
    }
});

function openAddUser() {
    openModal("Tambah User", `
        <form method="POST" action="<?php echo e(route('admin.users.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label>Nama</label>
                <input name="nama" required>
            </div>

            <div class="form-group">
                <label>NIP</label>
                <input name="nip" required>
            </div>

            <div class="form-group">
                <label>Unit Kerja</label>
                <input name="unit_kerja" required>
            </div>

            <div class="form-group">
                <label>Gaji</label>
                <input type="number" name="gaji" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="action-group">
                <button class="btn btn-save">Simpan</button>
                <button type="button" class="btn btn-cancel" onclick="closeModal()">Batal</button>
            </div>
        </form>
    `);
}

function viewUser(id) {
    fetch('/admin/users/' + id)
        .then(r => r.json())
        .then(u => {
            const statusClass = (u.status || '').toUpperCase();
            openModal("Detail User", `
                <div class="modal-body-info">
                    <p><b>Nama:</b> ${u.nama || '-'}</p>
                    <p><b>NIP:</b> ${u.nip || '-'}</p>
                    <p><b>Unit:</b> ${u.unit_kerja || '-'}</p>
                    <p><b>Gaji:</b> Rp ${Number(u.gaji || 0).toLocaleString('id-ID')}</p>
                    <p><b>Status:</b> <span class="badge ${statusClass}">${u.status || '-'}</span></p>
                </div>
            `);
        });
}

function viewOrders(id) {
    fetch(`/admin/users/${id}/orders`)
        .then(r => r.json())
        .then(orders => {
            if (!orders.length) {
                openModal("Riwayat Belanja User", `<p class="empty-state">Belum ada riwayat belanja.</p>`);
                return;
            }

            let html = `
                <div class="table-wrap">
                    <table class="modal-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            orders.forEach(o => {
                html += `
                    <tr>
                        <td>ORD${o.id}</td>
                        <td>Rp ${Number(o.total || 0).toLocaleString('id-ID')}</td>
                        <td>${o.status || '-'}</td>
                    </tr>
                `;
            });

            html += `
                        </tbody>
                    </table>
                </div>
            `;

            openModal("Riwayat Belanja User", html);
        });
}

function editUser(id, nama, unit, gaji, status) {
    openModal("Edit User", `
        <form method="POST" action="/admin/users/update/${id}">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label>Nama</label>
                <input name="nama" value="${nama}" required>
            </div>

            <div class="form-group">
                <label>Unit</label>
                <input name="unit_kerja" value="${unit}" required>
            </div>

            <div class="form-group">
                <label>Gaji</label>
                <input type="number" name="gaji" value="${gaji}" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Aktif" ${status === 'Aktif' ? 'selected' : ''}>Aktif</option>
                    <option value="Nonaktif" ${status === 'Nonaktif' ? 'selected' : ''}>Nonaktif</option>
                </select>
            </div>

            <div class="action-group">
                <button class="btn btn-save">Simpan</button>
                <button type="button" class="btn btn-cancel" onclick="closeModal()">Batal</button>
            </div>
        </form>
    `);
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/users.blade.php ENDPATH**/ ?>