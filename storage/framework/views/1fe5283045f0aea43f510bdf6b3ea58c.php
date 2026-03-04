<?php $__env->startSection('title','Admin Katalog Produk'); ?>

<?php $__env->startSection('content'); ?>

<style>
.catalog-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
}

.catalog-grid .card {
    background: white;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    text-align: left;
    cursor: default;
    transition: none;
}

.catalog-grid .card:hover {
    transform: none;
}

.catalog-grid h3 {
    margin-top: 0;
}

.catalog-grid .catalog-tools {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.catalog-grid .catalog-filter-form {
    margin: 0;
    display: grid;
    grid-template-columns: 1.4fr 0.8fr 0.8fr auto auto;
    gap: 8px;
    align-items: center;
    width: min(100%, 760px);
}

.catalog-grid .catalog-meta {
    font-size: 12px;
    color: #64748b;
    margin: 0;
}

.catalog-grid table {
    width: 100%;
    border-collapse: collapse;
}

.catalog-grid .table-wrap{
    width:100%;
    overflow:auto;
    border:1px solid #e5e7eb;
    border-radius:10px;
}

.catalog-grid th {
    background: #1f2937;
    color: white;
    padding: 12px;
    text-align: left;
    font-size: 14px;
}

.catalog-grid td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
    vertical-align: middle;
}

.catalog-grid td img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
}

.catalog-grid .btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    border: none;
    cursor: pointer;
    color: white;
}

.catalog-grid .btn-edit { background: #2563eb; }
.catalog-grid .btn-delete { background: #ef4444; }

.catalog-grid label {
    display: block;
    font-size: 13px;
    margin-top: 12px;
    margin-bottom: 5px;
}

.catalog-grid .field-control {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    color: #0f172a;
    background: #ffffff;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.catalog-grid .field-control::placeholder {
    color: #9ca3af;
}

.catalog-grid .field-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.catalog-grid .field-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 38px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M5.5 7.5L10 12L14.5 7.5' stroke='%2364748B' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 16px;
}

.catalog-grid textarea {
    resize: vertical;
    min-height: 80px;
}

.catalog-grid .field-file::file-selector-button {
    margin-right: 10px;
    border: none;
    background: #e5e7eb;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
}

.catalog-grid .field-file::file-selector-button:hover {
    background: #d1d5db;
}

.catalog-grid .form-actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.catalog-grid .btn-save { background: #22c55e; }
.catalog-grid .btn-reset { background: #9ca3af; }

@media (max-width: 1000px) {
    .catalog-grid {
        grid-template-columns: 1fr;
    }

    .catalog-grid .catalog-filter-form {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    $filters = $filters ?? [
        'q' => '',
        'category' => 'ALL',
        'status' => 'ALL',
    ];
?>

<div class="catalog-grid">

    <div class="card">
        <div class="catalog-tools">
            <div>
                <h3>Admin Katalog Produk</h3>
                <p class="catalog-meta">Menampilkan <?php echo e(($products ?? collect())->count()); ?> produk.</p>
            </div>

            <form method="GET" action="<?php echo e(route('admin.katalog')); ?>" class="catalog-filter-form">
                <input class="field-control"
                       type="text"
                       name="q"
                       placeholder="Cari nama/kategori/deskripsi produk"
                       value="<?php echo e((string) ($filters['q'] ?? '')); ?>">

                <select class="field-control field-select" name="category">
                    <option value="ALL" <?php echo e(($filters['category'] ?? 'ALL') === 'ALL' ? 'selected' : ''); ?>>Semua Kategori</option>
                    <option value="ATK" <?php echo e(($filters['category'] ?? 'ALL') === 'ATK' ? 'selected' : ''); ?>>ATK</option>
                    <option value="Snack" <?php echo e(($filters['category'] ?? 'ALL') === 'Snack' ? 'selected' : ''); ?>>Snack</option>
                    <option value="Drink" <?php echo e(($filters['category'] ?? 'ALL') === 'Drink' ? 'selected' : ''); ?>>Drink</option>
                </select>

                <select class="field-control field-select" name="status">
                    <option value="ALL" <?php echo e(($filters['status'] ?? 'ALL') === 'ALL' ? 'selected' : ''); ?>>Semua Status</option>
                    <option value="Aktif" <?php echo e(($filters['status'] ?? 'ALL') === 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="Nonaktif" <?php echo e(($filters['status'] ?? 'ALL') === 'Nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>

                <button class="btn btn-edit" type="submit">Cari</button>
                <a class="btn btn-reset" href="<?php echo e(route('admin.katalog')); ?>">Reset</a>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php
                                    $rawImage = trim((string) ($p->image ?? ''));
                                    $imageUrl = null;

                                    if ($rawImage !== '') {
                                        $normalizedImage = preg_replace('/^public\//i', '', $rawImage);
                                        $isAbsolute = preg_match('/^https?:\/\//i', $rawImage) === 1;
                                        $imageUrl = $isAbsolute
                                            ? $rawImage
                                            : asset('storage/' . ltrim($normalizedImage, '/'));
                                    }
                                ?>

                                <?php if(!empty($imageUrl)): ?>
                                    <img
                                        src="<?php echo e($imageUrl); ?>"
                                        alt="<?php echo e($p->name); ?>"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                                    >
                                    <span style="display:none;">-</span>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($p->name); ?></td>
                            <td><?php echo e($p->category); ?></td>
                            <td>Rp <?php echo e(number_format($p->price ?? 0,0,',','.')); ?></td>
                            <td><?php echo e($p->stock ?? 0); ?></td>
                            <td>
                                <button
                                    class="btn btn-edit"
                                    type="button"
                                    data-id="<?php echo e($p->id); ?>"
                                    data-name="<?php echo e(e($p->name ?? '')); ?>"
                                    data-category="<?php echo e(e($p->category ?? 'ATK')); ?>"
                                    data-price="<?php echo e((int) ($p->price ?? 0)); ?>"
                                    data-stock="<?php echo e((int) ($p->stock ?? 0)); ?>"
                                    data-status="<?php echo e(e($p->status ?? 'Aktif')); ?>"
                                    data-description="<?php echo e(e($p->description ?? '')); ?>"
                                    onclick="openEditFromButton(this)"
                                >
                                    Edit
                                </button>

                                <form method="POST"
                                      action="<?php echo e(route('admin.katalog.delete',$p->id)); ?>"
                                      style="display:inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-delete"
                                            onclick="return confirm('Hapus produk ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" align="center">Belum ada produk</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h3 id="formTitle">Tambah Produk</h3>

        <form method="POST"
              id="productForm"
              action="<?php echo e(route('admin.katalog.store')); ?>"
              enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <label>Nama Produk</label>
            <input class="field-control" name="name" id="formName" required>

            <label>Kategori</label>
            <select class="field-control field-select" name="category" id="formCategory">
                <option value="ATK">ATK</option>
                <option value="Snack">Snack</option>
                <option value="Drink">Drink</option>
            </select>

            <label>Harga</label>
            <input class="field-control" type="number" name="price" id="formPrice" required>

            <label>Stok</label>
            <input class="field-control" type="number" name="stock" id="formStock" required>

            <label>Status</label>
            <select class="field-control field-select" name="status" id="formStatus">
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>

            <label>Deskripsi</label>
            <textarea class="field-control" name="description" id="formDescription"></textarea>

            <label>Foto Produk</label>
            <input class="field-control field-file" type="file" name="image" accept="image/*" id="formImage">

            <div class="form-actions">
                <button class="btn btn-save" type="submit" id="formSubmit">Simpan</button>
                <button class="btn btn-reset" type="button" onclick="resetForm()">Reset</button>
            </div>
        </form>
    </div>

</div>

<script>
const form = document.getElementById('productForm');
const formTitle = document.getElementById('formTitle');
const formSubmit = document.getElementById('formSubmit');
const formName = document.getElementById('formName');
const formCategory = document.getElementById('formCategory');
const formPrice = document.getElementById('formPrice');
const formStock = document.getElementById('formStock');
const formStatus = document.getElementById('formStatus');
const formDescription = document.getElementById('formDescription');

const storeAction = "<?php echo e(route('admin.katalog.store')); ?>";
const updateBaseAction = "<?php echo e(url('/admin/katalog/update')); ?>";

function openEditFromButton(button) {
    openEdit(
        Number(button.dataset.id || 0),
        button.dataset.name || '',
        button.dataset.category || 'ATK',
        Number(button.dataset.price || 0),
        Number(button.dataset.stock || 0),
        button.dataset.status || 'Aktif',
        button.dataset.description || ''
    );
}

function openEdit(id, name, category, price, stock, status, description) {
    form.action = updateBaseAction + '/' + id;
    formTitle.textContent = 'Edit Produk';
    formSubmit.textContent = 'Update';

    formName.value = name || '';
    formCategory.value = category || 'ATK';
    formPrice.value = price || 0;
    formStock.value = stock || 0;
    formStatus.value = status || 'Aktif';
    formDescription.value = description || '';
}

function resetForm() {
    form.action = storeAction;
    form.reset();
    formTitle.textContent = 'Tambah Produk';
    formSubmit.textContent = 'Simpan';
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/katalog.blade.php ENDPATH**/ ?>