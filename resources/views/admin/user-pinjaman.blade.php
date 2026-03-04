@extends('layouts.admin')

@section('title','Riwayat Pinjaman User')

@section('content')

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
            <h3 class="section-title">Riwayat Pinjaman - {{ $nama ?? '-' }}</h3>
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
                    @forelse($loans as $l)
                        <tr>
                            <td>{{ $l->kode }}</td>
                            <td>Rp {{ number_format($l->jumlah ?? 0,0,',','.') }}</td>
                            <td>{{ $l->tenor ?? '-' }} Bulan</td>
                            <td>
                                <span class="badge {{ $l->status ?? '' }}">
                                    {{ $l->status ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.pinjaman.show',$l->id) }}" class="btn btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">User ini belum memiliki pinjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer-actions">
        <a href="{{ route('admin.users') }}" class="btn btn-cancel">
            ← Kembali ke Data User
        </a>
    </div>
</div>

@endsection
