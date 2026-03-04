<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','User')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS global --}}
    <link rel="stylesheet" href="{{ asset('user/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/belanja.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/pinjaman.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/riwayat.css') }}">

</head>
<body>

{{-- Navbar --}}
<div class="navbar">

    <div class="nav-left">
        <img src="{{ asset('user/assets/logo_1.png') }}" height="40">
        <span>Koperasi User</span>
    </div>

    <div class="nav-right">

        <a href="{{ route('user.landing') }}">Home</a>

        <a href="{{ route('user.belanja') }}">Belanja</a>

        <a href="{{ route('user.pinjaman') }}">Pinjaman</a>

        <a href="{{ route('user.riwayat') }}">Riwayat</a>

        <form method="POST" action="{{ route('user.logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>

    </div>

</div>


{{-- Content --}}
<div class="container">

    @yield('content')

</div>


</body>
</html>
