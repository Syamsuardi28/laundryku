@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Cari Data" subtitle="Pencarian pelanggan, layanan, dan transaksi" />

<div class="card mb-6 p-4">
    <form method="GET">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="q" value="{{ $query }}" placeholder="Ketik kata kunci pencarian..." autofocus
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800">
        </div>
    </form>
</div>

@if($query)
<div class="space-y-6 animate-fade-in">
    @foreach([
        ['title' => 'Pelanggan', 'items' => $customers, 'cols' => ['nama' => 'Nama', 'telepon' => 'Telepon', 'alamat' => 'Alamat']],
        ['title' => 'Layanan', 'items' => $services, 'cols' => ['nama_layanan' => 'Nama', 'harga_per_kg' => 'Harga/Kg', 'deskripsi' => 'Deskripsi']],
    ] as $section)
    <div class="card overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-700">
            <h2 class="font-semibold text-slate-900 dark:text-white">{{ $section['title'] }} <span class="text-sm font-normal text-slate-500">({{ $section['items']->count() }})</span></h2>
        </div>
        <div class="overflow-x-auto">
            <table class="table-modern w-full text-sm">
                <thead><tr>@foreach($section['cols'] as $label)<th class="px-6 py-3">{{ $label }}</th>@endforeach</tr></thead>
                <tbody class="text-slate-600 dark:text-slate-300">
                    @forelse($section['items'] as $item)
                    <tr>@foreach(array_keys($section['cols']) as $field)<td class="px-6 py-4">{{ $field === 'harga_per_kg' ? 'Rp ' . number_format($item->$field, 0, ',', '.') : ($item->$field ?? '-') }}</td>@endforeach</tr>
                    @empty
                    <tr><td colspan="{{ count($section['cols']) }}" class="px-6 py-8 text-center text-slate-400">Tidak ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    <div class="card overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-700">
            <h2 class="font-semibold text-slate-900 dark:text-white">Transaksi <span class="text-sm font-normal text-slate-500">({{ $transactions->count() }})</span></h2>
        </div>
        <div class="overflow-x-auto">
            <table class="table-modern w-full text-sm">
                <thead><tr><th class="px-6 py-3">Invoice</th><th class="px-6 py-3">Pelanggan</th><th class="px-6 py-3">Total</th><th class="px-6 py-3">Status</th></tr></thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4"><a href="{{ route('transactions.show', $transaction) }}" class="font-semibold text-primary hover:underline">{{ $transaction->invoice_number }}</a></td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $transaction->customer->nama }}</td>
                        <td class="px-6 py-4 font-medium text-success">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4"><x-ui.status-badge :status="$transaction->status" /></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-slate-400">Tidak ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="card p-16 text-center">
    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    <p class="mt-4 text-slate-400">Masukkan kata kunci untuk mulai mencari</p>
</div>
@endif
@endsection
