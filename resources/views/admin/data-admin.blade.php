@extends('layouts.admin')

@section('title','Data Admin | Admin')

@section('content')

<style>
.data-admin-page .content-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

.data-admin-page h3{
  margin:0;
  font-size:20px;
}

.data-admin-page .btn{
  padding:8px 14px;
  border-radius:8px;
  font-size:13px;
  border:none;
  cursor:pointer;
  color:white;
}

.data-admin-page .btn-add{background:#2563eb;}
.data-admin-page .btn-edit{background:#2563eb; padding:6px 10px;}
.data-admin-page .btn-delete{background:#ef4444; padding:6px 10px;}
.data-admin-page .btn-reset{background:#9ca3af; padding:6px 10px;}

.data-admin-page .card{
  background:white;
  border-radius:14px;
  padding:20px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.data-admin-page table{
  width:100%;
  border-collapse:collapse;
}

.data-admin-page .table-wrap{
  width:100%;
  overflow:auto;
  border:1px solid #e5e7eb;
  border-radius:10px;
}

.data-admin-page th{
  background:#1f2937;
  color:white;
  padding:12px;
  text-align:left;
  font-size:14px;
}

.data-admin-page td{
  padding:12px;
  border-bottom:1px solid #e5e7eb;
  font-size:14px;
  vertical-align:middle;
}

.data-admin-page .badge{
  padding:6px 14px;
  border-radius:20px;
  font-size:12px;
  font-weight:600;
  color:white;
  display:inline-block;
}

.data-admin-page .AKTIF{background:#22c55e;}
.data-admin-page .NONAKTIF{background:#9ca3af;}

.data-admin-page .inline-form{
  display:inline;
}

.data-admin-page .form-add{
  display:none;
  gap:10px;
  flex-wrap:wrap;
  margin-top:15px;
}

.data-admin-page .form-add input,
.data-admin-page .form-add select{
  padding:8px 10px;
  border-radius:8px;
  border:1px solid #d1d5db;
  font-size:14px;
}

.data-admin-page .form-add input{
  min-width:160px;
}

/* Modal */
.data-admin-page #editModal{
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.5);
  align-items:center;
  justify-content:center;
  z-index:50;
}

.data-admin-page .modal-card{
  background:white;
  padding:20px;
  border-radius:12px;
  width:350px;
}

.data-admin-page .modal-card h4{
  margin-top:0;
}

.data-admin-page .modal-card label{
  display:block;
  font-size:13px;
  margin-top:12px;
  margin-bottom:5px;
}

.data-admin-page .modal-card input,
.data-admin-page .modal-card select{
  width:100%;
  padding:8px 10px;
  border-radius:8px;
  border:1px solid #d1d5db;
  font-size:14px;
}

.data-admin-page .modal-actions{
  margin-top:15px;
  display:flex;
  gap:10px;
}
</style>

@php
  $currentRole = strtolower((string) (auth()->user()->role ?? session('admin_role', '')));
  $canManageAdminData = in_array($currentRole, ['admin', 'super admin', 'super_admin', 'superadmin'], true);
@endphp

<div class="data-admin-page">
  <div class="content-header">
    <h3>Data Admin</h3>

    @if($canManageAdminData)
      <button class="btn btn-add" type="button" onclick="toggleAddForm()">+ Tambah Admin</button>
    @endif
  </div>

  @if(session('success'))
    <div style="margin-bottom:10px; padding:10px 12px; border-radius:8px; border:1px solid #86efac; background:#ecfdf5; color:#166534;">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="margin-bottom:10px; padding:10px 12px; border-radius:8px; border:1px solid #fca5a5; background:#fef2f2; color:#991b1b;">
      {{ session('error') }}
    </div>
  @endif

  @if($errors->any())
    <div style="margin-bottom:10px; padding:10px 12px; border-radius:8px; border:1px solid #fca5a5; background:#fef2f2; color:#991b1b;">
      {{ $errors->first() }}
    </div>
  @endif

  @if($canManageAdminData)
    <form method="POST"
          action="{{ route('admin.data-admin.store') }}"
          class="form-add"
          id="addAdminForm">
      @csrf

      <input name="name" placeholder="Nama Admin" required>
      <input name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>

      <select name="role">
        <option value="Admin">Admin</option>
        <option value="Super Admin">Super Admin</option>
      </select>

      <select name="status">
        <option value="AKTIF">AKTIF</option>
        <option value="NONAKTIF">NONAKTIF</option>
      </select>

      <button class="btn btn-add" type="submit">Simpan</button>
      <button class="btn btn-reset" type="button" onclick="toggleAddForm(false)">Batal</button>
    </form>
  @endif

  <div class="card">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Admin</th>
            <th>Username</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($admins as $i => $a)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $a->name }}</td>
              <td>{{ $a->username ?? $a->email ?? $a->nip ?? '-' }}</td>
              <td>{{ $a->role }}</td>
              <td>
                <span class="badge {{ $a->status }}">{{ $a->status }}</span>
              </td>
              <td>
                @if($canManageAdminData)
                  <button class="btn btn-edit"
                          type="button"
                          onclick="openEdit(
                            {{ $a->id }},
                            @json($a->name),
                            @json($a->role),
                            @json($a->status)
                          )">✏️</button>

                  <form method="POST"
                        action="{{ route('admin.data-admin.reset',$a->id) }}"
                        class="inline-form">
                    @csrf
                    <button class="btn btn-reset">🔑</button>
                  </form>

                  <form method="POST"
                        action="{{ route('admin.data-admin.delete',$a->id) }}"
                        class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete"
                            onclick="return confirm('Hapus admin ini?')">🗑</button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" align="center">Tidak ada data admin</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div id="editModal">
    <div class="modal-card">
      <h4>Edit Admin</h4>

      <form method="POST" id="editForm">
        @csrf

        <label>Nama</label>
        <input name="name" id="editName" required>

        <label>Role</label>
        <select name="role" id="editRole">
          <option value="Admin">Admin</option>
          <option value="Super Admin">Super Admin</option>
        </select>

        <label>Status</label>
        <select name="status" id="editStatus">
          <option value="AKTIF">AKTIF</option>
          <option value="NONAKTIF">NONAKTIF</option>
        </select>

        <div class="modal-actions">
          <button class="btn btn-edit" type="submit">Simpan</button>
          <button class="btn btn-reset" type="button" onclick="closeModal()">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function toggleAddForm(forceState){
  const form = document.getElementById('addAdminForm');
  if (!form) return;

  if (typeof forceState === 'boolean') {
    form.style.display = forceState ? 'flex' : 'none';
    return;
  }

  form.style.display = form.style.display === 'flex' ? 'none' : 'flex';
}

function openEdit(id, name, role, status){
  document.getElementById('editModal').style.display = 'flex';
  document.getElementById('editName').value = name || '';
  document.getElementById('editRole').value = role || 'Admin';
  document.getElementById('editStatus').value = status || 'AKTIF';
  document.getElementById('editForm').action = "{{ url('/admin/data-admin/update') }}/" + id;
}

function closeModal(){
  document.getElementById('editModal').style.display = 'none';
}
</script>

@endsection
