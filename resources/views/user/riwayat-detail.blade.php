<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Koperasi BTN</title>
    <link rel="stylesheet" href="{{ asset('user/css/landing.css') }}">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .detail-wrap {
            max-width: 980px;
            margin: 24px auto 60px;
            padding: 0 16px;
        }

        .detail-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.06);
            padding: 22px;
        }

        .detail-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .chip {
            background: #e8f0ff;
            color: #005bfd;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-link {
            display: inline-block;
            text-decoration: none;
            border-radius: 999px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-primary {
            background: #005bfd;
            color: #fff;
        }

        .btn-muted {
            background: #eef2f7;
            color: #1f2937;
            margin-right: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #eceff4;
            font-size: 14px;
        }

        th {
            color: #6b7280;
            font-weight: 700;
        }

        .total {
            margin-top: 16px;
            text-align: right;
            font-size: 18px;
            font-weight: 800;
        }

        @media (max-width: 768px) {
            .detail-card {
                padding: 14px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                margin-bottom: 10px;
                padding: 8px;
                background: #fafafa;
            }

            td {
                border: none;
                padding: 6px 4px;
            }

            td::before {
                content: attr(data-label);
                display: block;
                font-size: 12px;
                color: #6b7280;
                margin-bottom: 2px;
            }
        }
    </style>
</head>
<body>
    <div class="detail-wrap">
        <div class="detail-card">
            <div class="detail-top">
                <div>
                    <h2 style="margin-bottom: 6px;">Detail Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
                    <p style="font-size: 14px; color: #6b7280;">Tanggal: {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</p>
                </div>
                <span class="chip">{{ $order->status ?? 'MENUNGGU' }}</span>
            </div>

            <div style="margin-bottom: 16px;">
                <a href="{{ route('user.riwayat') }}" class="btn-link btn-muted">Kembali ke Riwayat</a>
                <a href="{{ route('user.belanja') }}" class="btn-link btn-primary">Belanja Lagi</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td data-label="Produk">{{ $item->name }}</td>
                            <td data-label="Kategori">{{ $item->category }}</td>
                            <td data-label="Qty">{{ $item->qty }}</td>
                            <td data-label="Harga">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td data-label="Subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Total: Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>
</body>
</html>
