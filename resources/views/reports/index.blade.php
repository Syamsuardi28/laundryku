@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Laporan" subtitle="Laporan harian dan bulanan pendapatan" />

<div class="card mb-6 p-4">
    <form method="GET" class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Jenis Laporan</label>
            <select name="type" id="report-type" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800">
                <option value="daily" @selected($type === 'daily')>Harian</option>
                <option value="monthly" @selected($type === 'monthly')>Bulanan</option>
            </select>
        </div>
        <div id="daily-filter" class="{{ $type === 'monthly' ? 'hidden' : '' }}">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Tanggal</label>
            <input type="date" name="date" value="{{ $date }}" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800">
        </div>
        <div id="monthly-filter" class="{{ $type === 'daily' ? 'hidden' : '' }}">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Bulan</label>
            <input type="month" name="month" value="{{ $month }}" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800">
        </div>
        <button type="submit" class="btn-primary">Tampilkan</button>
    </form>
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-6">
    <x-ui.stat-card label="Total Transaksi — {{ $periodLabel }}" :value="number_format($totalTransaksi)" icon="clipboard" color="primary" />
    <x-ui.stat-card label="Total Pendapatan" :value="'Rp ' . number_format($totalPendapatan, 0, ',', '.')" icon="currency" color="success" />
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Layanan</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $transaction->invoice_number }}</td>
                    <td class="px-6 py-4">{{ $transaction->customer->nama }}</td>
                    <td class="px-6 py-4">{{ $transaction->service->nama_layanan }}</td>
                    <td class="px-6 py-4 font-medium text-success">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-16 text-center text-slate-400">Tidak ada transaksi pada periode ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('report-type').addEventListener('change', function() {
    document.getElementById('daily-filter').classList.toggle('hidden', this.value !== 'daily');
    document.getElementById('monthly-filter').classList.toggle('hidden', this.value !== 'monthly');
});
</script>
@endpush
@endsection
