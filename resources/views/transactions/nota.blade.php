<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Nota {{ $transaction->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 0; padding: 10px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px dashed #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        td { padding: 4px 0; vertical-align: top; }
        .label { color: #666; width: 40%; }
        .total { font-size: 16px; font-weight: bold; border-top: 2px dashed #333; padding-top: 10px; margin-top: 10px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #888; border-top: 1px dashed #ccc; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LaundryKu</h1>
        <p>Nota Transaksi Laundry</p>
        <p>{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <tr><td class="label">No. Invoice</td><td>: {{ $transaction->invoice_number }}</td></tr>
        <tr><td class="label">Pelanggan</td><td>: {{ $transaction->customer->nama }}</td></tr>
        <tr><td class="label">Telepon</td><td>: {{ $transaction->customer->telepon }}</td></tr>
        <tr><td class="label">Alamat</td><td>: {{ $transaction->customer->alamat ?? '-' }}</td></tr>
    </table>

    <table>
        <tr><td class="label">Layanan</td><td>: {{ $transaction->service->nama_layanan }}</td></tr>
        <tr><td class="label">Harga/Kg</td><td>: Rp {{ number_format($transaction->service->harga_per_kg, 0, ',', '.') }}</td></tr>
        <tr><td class="label">Berat</td><td>: {{ $transaction->berat }} Kg</td></tr>
        <tr><td class="label">Status</td><td>: {{ \App\Models\Transaction::statusLabel($transaction->status) }}</td></tr>
        <tr><td class="label">Petugas</td><td>: {{ $transaction->user->name }}</td></tr>
    </table>

    <div class="total">
        TOTAL: Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
    </div>

    <div class="footer">
        Terima kasih telah menggunakan layanan LaundryKu<br>
        Simpan nota ini sebagai bukti transaksi
    </div>
</body>
</html>
