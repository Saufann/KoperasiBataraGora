<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', 'Admin Panel')</title>

<style>
:root{
    --admin-bg:#f5f7fb;
    --admin-card:#ffffff;
    --admin-text:#111827;
    --admin-muted:#6b7280;
    --admin-border:#e5e7eb;
    --admin-primary:#2563eb;
}

*{
    box-sizing: border-box;
    font-family: "Segoe UI", Arial, sans-serif;
}

body{
    margin:0;
    background:var(--admin-bg);
    color:var(--admin-text);
}

.layout{
    display:flex;
    min-height:100vh;
}

.sidebar{
    width:240px;
    background:#1f2937;
    color:#fff;
    padding:25px 20px;
}

.sidebar h2{
    font-size:20px;
    margin-bottom:35px;
}

.menu a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 15px;
    margin-bottom:8px;
    color:#d1d5db;
    text-decoration:none;
    border-radius:10px;
    font-size:14px;
}

.menu a.active,
.menu a:hover{
    background:#2563eb;
    color:white;
}

.main{
    flex:1;
    min-width:0;
}

.topbar{
    background:var(--admin-card);
    padding:15px 30px;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    box-shadow:0 1px 6px rgba(0,0,0,0.08);
    position:sticky;
    top:0;
    z-index:1000;
}

.user-menu{
    position:relative;
}

.user-menu span{
    font-size:14px;
    color:#374151;
}

.dropdown{
    display:none;
    position:absolute;
    right:0;
    top:30px;
    background:white;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    min-width:120px;
}

.dropdown form{
    margin:0;
}

.dropdown button{
    width:100%;
    padding:10px;
    border:none;
    background:none;
    cursor:pointer;
}

.dropdown button:hover{
    background:#f3f4f6;
}

.content{
    padding:30px;
    min-width:0;
}

.card{
    background:var(--admin-card);
    border-radius:14px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.section-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:15px;
}

.section-title{
    margin:0;
    font-size:20px;
}

.section-subtitle{
    margin:4px 0 0;
    color:var(--admin-muted);
    font-size:13px;
}

.btn{
    padding:8px 14px;
    border-radius:8px;
    font-size:13px;
    border:none;
    cursor:pointer;
    color:white;
    text-decoration:none;
    display:inline-block;
    line-height:1.2;
    white-space:nowrap;
}

.btn:disabled{
    opacity:.6;
    cursor:not-allowed;
}

.btn-add{background:#2563eb;}
.btn-detail{background:#3b82f6;}
.btn-order{background:#0ea5e9;}
.btn-loan{background:#f59e0b;}
.btn-edit{background:#2563eb;}
.btn-delete{background:#ef4444;}
.btn-save{background:#22c55e;}
.btn-cancel{background:#6b7280;}
.btn-approve{background:#22c55e;}
.btn-reject{background:#ef4444;}
.btn-export{background:#2563eb;}

.badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    color:white;
}

.badge.MENUNGGU{background:#f59e0b;}
.badge.DISETUJUI{background:#22c55e;}
.badge.LUNAS{background:#3b82f6;}
.badge.DITOLAK{background:#ef4444;}
.badge.AKTIF{background:#22c55e;}
.badge.NONAKTIF{background:#9ca3af;}

table{
    width:100%;
    border-collapse:collapse;
}

.table-wrap{
    width:100%;
    overflow:auto;
    border:1px solid var(--admin-border);
    border-radius:10px;
}

th{
    background:#1f2937;
    color:white;
    padding:12px;
    text-align:left;
    font-size:14px;
}

td{
    padding:12px;
    border-bottom:1px solid #e5e7eb;
    font-size:14px;
    vertical-align:middle;
}

.action-group{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:8px;
}

.empty-state{
    color:var(--admin-muted);
    text-align:center;
}

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    align-items:center;
    justify-content:center;
    z-index:1200;
}

.modal-content{
    background:white;
    border-radius:14px;
    width:min(640px,92vw);
    max-height:85vh;
    overflow:auto;
    box-shadow:0 20px 40px rgba(0,0,0,0.25);
    padding:20px;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:12px;
}

.close{
    cursor:pointer;
    font-size:22px;
    line-height:1;
    color:#6b7280;
}

.form-group{
    margin-bottom:12px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:13px;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    border:1px solid #d1d5db;
    border-radius:8px;
    padding:8px 10px;
    font-size:14px;
}

/* ===== DASHBOARD ===== */
.banner{
    background:linear-gradient(90deg,#2563eb,#3b82f6);
    color:white;
    padding:35px 40px;
    border-radius:14px;
    margin-bottom:30px;
}

.banner h1{
    margin:0 0 10px;
    font-size:28px;
}

.banner p{
    margin:0;
    opacity:0.9;
    font-size:15px;
}

.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.cards .card{
    text-align:center;
    cursor:pointer;
    transition:0.2s;
    text-decoration:none;
    padding:25px;
}

.cards .card:hover{
    transform:translateY(-5px);
}

.icon{
    font-size:40px;
    margin-bottom:15px;
}

.cards .card h3{
    margin:0;
    font-size:16px;
    color:#374151;
}

.blue{color:#2563eb;}
.green{color:#16a34a;}
.yellow{color:#f59e0b;}
.red{color:#ef4444;}

@media(max-width:1000px){
    .cards{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:900px){
    .layout{
        flex-direction:column;
    }

    .sidebar{
        width:100%;
        padding:16px 14px;
    }

    .menu{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:8px;
    }

    .menu a{
        margin-bottom:0;
        justify-content:center;
    }

    .topbar{
        padding:12px 16px;
    }

    .content{
        padding:16px;
    }
}

@media(max-width:560px){
    .menu{
        grid-template-columns:1fr;
    }
}
</style>

</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h2>Koperasi</h2>

        <div class="menu">

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.laporan') }}"
               class="{{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                Laporan Keuangan
            </a>

            <a href="{{ route('admin.katalog') }}"
               class="{{ request()->routeIs('admin.katalog*') ? 'active' : '' }}">
                Katalog
            </a>

            <a href="{{ route('admin.pinjaman') }}"
               class="{{ request()->routeIs('admin.pinjaman*') ? 'active' : '' }}">
                Status Peminjaman
            </a>

            <a href="{{ route('admin.data-admin') }}"
               class="{{ request()->routeIs('admin.data-admin*') ? 'active' : '' }}">
                Data Admin
            </a>

        </div>

    </div>


    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <div class="user-menu">

                <span onclick="toggleMenu()" style="cursor:pointer">
                    Welcome, {{ session('admin_name', $adminName ?? 'admin') }}
                    ⌄
                </span>

                <div class="dropdown" id="menu">

                    <form method="POST"
                          action="{{ route('admin.logout') }}">

                        @csrf

                        <button type="submit">
                            Logout
                        </button>

                    </form>

                </div>

            </div>

        </div>


        <!-- CONTENT -->
        <div class="content">

            @yield('content')

        </div>

    </div>

</div>


<script>
function toggleMenu(){

    const menu = document.getElementById('menu');

    if(menu.style.display === 'block'){
        menu.style.display = 'none';
    }else{
        menu.style.display = 'block';
    }

}
</script>

</body>
</html>
