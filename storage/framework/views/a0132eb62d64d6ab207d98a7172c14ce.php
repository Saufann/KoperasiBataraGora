<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin: 15px 0;
            font-size: 14px;
        }

        .line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            width: 300px;
        }

        table {
            width: 100%;
        }

        .box {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 15px;
        }

        .signature {
            margin-top: 30px;
        }

        .small {
            font-size: 10px;
        }

        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

<?php
    $displayName = $user->name ?? ($profile['nama'] ?? ($loan->nama_peminjam ?? '-'));
    $displayNip = $user->nip ?? ($profile['nip'] ?? '-');
    $displayUnit = $user->unit_kerja ?? ($profile['unit_kerja'] ?? '-');
    $displayGaji = (int) ($user->gaji ?? ($profile['gaji'] ?? 0));
    $displayKeperluan = $loan->keperluan ?? $loan->catatan_admin ?? '-';
?>

<div class="header">
    <strong>KOPERASI KARYAWAN "BATARA GORA"</strong><br>
    Jalan Pejanggik No. 99-101 Mataram<br>
</div>

<hr>

<div class="title">
    FORMULIR PERMOHONAN PINJAMAN
</div>

<table>
<tr>
<td width="150">Nama</td>
<td>: <?php echo e($displayName); ?></td>
</tr>

<tr>
<td>NIP</td>
<td>: <?php echo e($displayNip); ?></td>
</tr>

<tr>
<td>Unit Kerja</td>
<td>: <?php echo e($displayUnit); ?></td>
</tr>

<tr>
<td>Penghasilan / Gaji</td>
<td>: Rp <?php echo e(number_format($displayGaji,0,',','.')); ?></td>
</tr>

<tr>
<td>Jumlah Permohonan</td>
<td>: Rp <?php echo e(number_format($loan->jumlah,0,',','.')); ?></td>
</tr>

<tr>
<td>Keperluan</td>
<td>: <?php echo e($displayKeperluan); ?></td>
</tr>

<tr>
<td>Terhitung Mulai</td>
<td>: <?php echo e(date('F Y')); ?></td>
</tr>

<tr>
<td>Jangka Waktu</td>
<td>: <?php echo e($loan->tenor); ?> Bulan</td>
</tr>
</table>

<br><br>

Mataram, <?php echo e(date('d F Y')); ?><br>
Pemohon,

<br><br><br>

( <?php echo e($displayName); ?> )

<div class="box">

    <strong>Diisi Petugas Koperasi</strong>

    <br><br>

    Sisa Pinjaman : Rp ____________<br><br>
    Angsuran Pokok : Rp ____________

</div>

<div class="box">

    Disetujui Permohonan Pinjaman sebesar Rp <?php echo e(number_format($loan->jumlah,0,',','.')); ?>


    <br><br>

    Jangka Waktu : <?php echo e($loan->tenor); ?> Bulan

    <br><br>

    Ketua : ____________________ <br><br>
    Sekretaris : ________________ <br><br>
    Bendahara : _________________ <br><br>
    Pengawas : __________________

</div>

<div class="small">
    Catatan: Permohonan dianggap sah apabila ditandatangani minimal 2 orang pengurus
</div>

<div style="margin-top:40px;" class="no-break">

<table width="100%">
<tr>
<td width="70%">
    <strong>Diterima Pemohon :</strong><br><br>

    Tanggal : ..............................................
</td>

<td width="30%" align="center">

    Paraf

    <br><br>

    <div style="
        border:1px solid #000;
        width:120px;
        height:80px;
        margin:auto;
    ">
    </div>

</td>
</tr>
</table>

<br><br>

<div style="font-size:10px;">
    Lembar warna putih &nbsp;&nbsp;: untuk arsip <br>
    Lembar warna kuning : untuk pemohon
</div>

</div>

</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/pinjaman-pdf.blade.php ENDPATH**/ ?>