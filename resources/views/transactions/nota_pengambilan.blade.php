<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Nota Pengambilan {{ $transaction->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 0; padding: 5px; color: #333; }
        .header { text-align: center; margin-bottom: 12px; border-bottom: 2px dashed #444; padding-bottom: 8px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
        .header p { margin: 2px 0; color: #666; font-size: 10px; }
        .title { font-size: 12px; font-weight: bold; text-align: center; margin: 8px 0; text-transform: uppercase; color: #111; }
        table { width: 100%; border-collapse: collapse; margin: 8px 0; }
        td { padding: 3px 0; vertical-align: top; }
        .label { color: #555; width: 42%; }
        .value { font-weight: 500; }
        .total-section { border-top: 2px dashed #444; border-bottom: 2px dashed #444; padding: 8px 0; margin: 8px 0; text-align: right; }
        .total-label { font-size: 11px; font-weight: bold; }
        .total-amount { font-size: 14px; font-weight: bold; color: #000; }
        .footer { text-align: center; margin-top: 15px; font-size: 9px; color: #666; border-top: 1px dashed #bbb; padding-top: 8px; line-height: 1.3; }
        .status-badge { display: inline-block; padding: 2px 6px; background-color: #d1fae5; color: #065f46; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LaundryKu</h1>
        <p>Jl. Clean & Fresh No. 100</p>
        <p>Telepon: 08123456789</p>
    </div>

    <div class="title">NOTA PENGAMBILAN LAUNDRY</div>

    <table>
        <tr>
            <td class="label">No. Invoice</td>
            <td class="value">: {{ $transaction->invoice_number }}</td>
        </tr>
        <tr>
            <td class="label">Nama Pelanggan</td>
            <td class="value">: {{ $transaction->customer->nama }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Masuk</td>
            <td class="value">: {{ $transaction->tanggal_masuk->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Tgl Pengambilan</td>
            <td class="value">: {{ $transaction->tanggal_diambil ? $transaction->tanggal_diambil->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <div style="border-top: 1px dashed #ccc; margin: 5px 0;"></div>

    <table>
        <tr>
            <td class="label">Jenis Layanan</td>
            <td class="value">: {{ $transaction->service->nama_layanan }}</td>
        </tr>
        <tr>
            <td class="label">Berat Cucian</td>
            <td class="value">: {{ $transaction->berat }} Kg</td>
        </tr>
        <tr>
            <td class="label">Status Laundry</td>
            <td class="value">: <span class="status-badge">{{ $transaction->status }}</span></td>
        </tr>
        <tr>
            <td class="label">Status Pembayaran</td>
            <td class="value">: {{ $transaction->status_pembayaran }}</td>
        </tr>
    </table>

    <div class="total-section">
        <span class="total-label">TOTAL PEMBAYARAN:</span><br>
        <span class="total-amount">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
    </div>

    <div class="footer">
        <strong>Laundry telah diterima oleh pelanggan.</strong><br>
        Terima kasih atas kunjungan Anda!
    </div>
</body>
</html>
