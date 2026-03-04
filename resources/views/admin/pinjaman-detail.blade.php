@extends('layouts.admin')

@section('title','Detail Pinjaman')

@section('content')

<style>
.loan-detail-page .card{
    margin-top:15px;
}

.loan-detail-page .detail-table{
    width:100%;
    border-collapse:collapse;
}

.loan-detail-page .detail-table td{
    border-bottom:1px solid #e5e7eb;
    padding:12px 10px;
}

.loan-detail-page .detail-table td:first-child{
    width:200px;
    color:#4b5563;
    font-weight:600;
}

.loan-detail-page .footer-actions{
    margin-top:15px;
}

@media(max-width:680px){
    .loan-detail-page .detail-table td:first-child{
        width:140px;
    }
}
</style>

<div class="loan-detail-page">
    <div class="section-header">
        <div>
            <h3 class="section-title">Detail Pinjaman</h3>
            <p class="section-subtitle">Informasi pengajuan pinjaman dan dokumen cetak.</p>
        </div>
    </div>

    <div class="card">
        <table class="detail-table">
            <tr>
                <td>Kode</td>
                <td>{{ $loan->kode ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $loan->nama_peminjam ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>Rp {{ number_format($loan->jumlah ?? 0,0,',','.') }}</td>
            </tr>
            <tr>
                <td>Tenor</td>
                <td>{{ $loan->tenor ?? '-' }} Bulan</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <span class="badge {{ $loan->status ?? '' }}">
                        {{ $loan->status ?? '-' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Catatan Admin</td>
                <td>{{ $loan->catatan_admin ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="footer-actions action-group">
        <form method="POST"
              action="{{ route('admin.pinjaman.cetak',$loan->id) }}"
              target="_blank"
              style="display:inline-block;">
            @csrf
            <button class="btn btn-detail">Cetak Surat Pinjaman</button>
        </form>

        <a href="{{ route('admin.pinjaman.print',$loan->id) }}"
           target="_blank"
           class="btn btn-detail">
            Print Langsung
        </a>

        <a href="{{ route('admin.pinjaman') }}" class="btn btn-cancel">
            ← Kembali
        </a>
    </div>
</div>

@endsection
