<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #111827;
            line-height: 1.4;
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
            text-transform: uppercase;
        }

        .meta {
            width: 100%;
            margin-bottom: 12px;
        }

        .meta td {
            padding: 2px 0;
            vertical-align: top;
        }

        .meta .label {
            width: 140px;
        }

        .box {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 15px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 7px 8px;
        }

        .report-table th {
            background: #f3f4f6;
            text-align: center;
        }

        .report-table td:nth-child(1) {
            width: 42px;
            text-align: center;
        }

        .report-table td:nth-child(3) {
            width: 180px;
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            background: #f9fafb;
        }

        .empty-state {
            text-align: center;
            font-style: italic;
            color: #374151;
        }

        .signature {
            width: 100%;
            margin-top: 28px;
        }

        .signature td {
            vertical-align: top;
        }

        .sign-name {
            margin-top: 48px;
            font-weight: bold;
            text-decoration: underline;
        }

        .small {
            margin-top: 10px;
            font-size: 10px;
        }
    </style>
</head>
<body>

<?php
    $printedAt = now();
    $reportTypeLabel = match ($type ?? 'bulan') {
        'hari' => 'Harian',
        'tahun' => 'Tahunan',
        default => 'Bulanan',
    };
    $grand = collect($rows ?? [])->sum(function ($row) {
        return (float) ($row->total ?? 0);
    });
?>

<div class="header">
    <strong>KOPERASI KARYAWAN "BATARA GORA"</strong><br>
    Jalan Pejanggik No. 99-101 Mataram
</div>

<hr>

<div class="title"><?php echo e($judul); ?></div>

<table class="meta">
    <tr>
        <td class="label">Jenis Laporan</td>
        <td>: <?php echo e($reportTypeLabel); ?></td>
    </tr>
    <tr>
        <td class="label">Dicetak Oleh</td>
        <td>: <?php echo e($admin); ?></td>
    </tr>
    <tr>
        <td class="label">Tanggal Cetak</td>
        <td>: <?php echo e($printedAt->format('d-m-Y H:i')); ?></td>
    </tr>
</table>

<div class="box">
    <table class="report-table">
        <tr>
            <th>No</th>
            <th>Periode</th>
            <th>Total (Rp)</th>
        </tr>

        <?php
            $no = 1;
        ?>

        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $periodLabel = (string) ($r->label ?? '-');
                if (($type ?? 'bulan') === 'hari') {
                    try {
                        $periodLabel = \Carbon\Carbon::parse($periodLabel)->format('d-m-Y');
                    } catch (\Throwable $e) {
                        $periodLabel = (string) ($r->label ?? '-');
                    }
                }
            ?>
            <tr>
                <td><?php echo e($no++); ?></td>
                <td><?php echo e($periodLabel); ?></td>
                <td>Rp <?php echo e(number_format((float) ($r->total ?? 0), 0, ',', '.')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="3" class="empty-state">Tidak ada data laporan pada periode ini.</td>
            </tr>
        <?php endif; ?>

        <tr class="total-row">
            <td colspan="2">TOTAL</td>
            <td>Rp <?php echo e(number_format($grand, 0, ',', '.')); ?></td>
        </tr>
    </table>
</div>

<table class="signature">
    <tr>
        <td width="60%"></td>
        <td width="40%" align="center">
            Mataram, <?php echo e($printedAt->format('d F Y')); ?><br>
            Petugas Koperasi,
            <div class="sign-name"><?php echo e($admin); ?></div>
        </td>
    </tr>
</table>

<div class="small">
    Catatan: Dokumen ini dihasilkan otomatis dari sistem Koperasi Batara Gora.
</div>

</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KOPERASIINTERNAL/resources/views/admin/laporan-pdf.blade.php ENDPATH**/ ?>