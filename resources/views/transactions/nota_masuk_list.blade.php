@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Nota Masuk Laundry" subtitle="Cetak Nota Penerimaan untuk transaksi aktif" />

{{-- Filter --}}
<div class="card mb-6 p-4">
    <form method="GET" class="flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari invoice atau nama pelanggan..."
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200">
        </div>
        <button type="submit" class="btn-secondary">Cari</button>
        @if(request('search'))
        <a href="{{ route('transactions.nota-masuk') }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Reset
        </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-left">Invoice</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Tanggal Masuk</th>
                    <th class="px-6 py-4 text-left">Layanan</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4">
                        <a href="{{ route('transactions.show', $transaction) }}" class="font-mono text-xs font-semibold text-primary hover:underline">
                            {{ $transaction->invoice_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white text-xs">{{ $transaction->customer->nama }}</p>
                            <p class="text-[10px] text-slate-400">{{ $transaction->customer->telepon }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs">{{ $transaction->tanggal_masuk->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-xs">{{ $transaction->service->nama_layanan }}</td>
                    <td class="px-6 py-4 font-semibold text-xs text-success">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4"><x-ui.status-badge :status="$transaction->status" /></td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('transactions.print-masuk', $transaction) }}" target="_blank"
                           class="inline-flex items-center rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-100 transition-colors">
                            <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak Nota Masuk
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                        Tidak ada transaksi aktif yang siap dicetak Nota Masuknya.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="border-t border-slate-100 px-6 py-4 dark:border-slate-700">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
