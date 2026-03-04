@extends('layouts.admin')

@section('title','Data User')

@section('content')

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
                    @forelse($users as $u)
                        <tr>
                            <td>USR{{ str_pad($u->id,3,'0',STR_PAD_LEFT) }}</td>
                            <td>{{ $u->nama }}</td>
                            <td>{{ $u->nip }}</td>
                            <td>{{ $u->unit_kerja }}</td>
                            <td>Rp {{ number_format($u->gaji,0,',','.') }}</td>
                            <td>
                                <span class="badge {{ strtoupper($u->status ?? '') }}">
                                    {{ $u->status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button class="btn btn-detail" type="button" onclick="viewUser({{ $u->id }})">
                                        Detail
                                    </button>

                                    <button class="btn btn-order" type="button" onclick="viewOrders({{ $u->id }})">
                                        Belanja
                                    </button>

                                    <a class="btn btn-loan" href="{{ route('admin.user.pinjaman',['id'=>$u->id]) }}">
                                        Pinjaman
                                    </a>

                                    @if(session('admin_role') === 'Super Admin')
                                        <button
                                            class="btn btn-edit"
                                            type="button"
                                            onclick="editUser(
                                                {{ $u->id }},
                                                '{{ addslashes($u->nama) }}',
                                                '{{ addslashes($u->unit_kerja) }}',
                                                {{ $u->gaji }},
                                                '{{ $u->status }}'
                                            )"
                                        >
                                            Edit
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">Tidak ada data user</td>
                        </tr>
                    @endforelse
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
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

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
            @csrf

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

@endsection
