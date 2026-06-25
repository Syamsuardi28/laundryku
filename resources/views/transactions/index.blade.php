@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Transaksi" subtitle="Kelola seluruh transaksi laundry">
    <x-slot:actions>
        <a href="{{ route('transactions.create') }}" class="btn-primary" id="btn-buat-transaksi">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Transaksi
        </a>
    </x-slot:actions>
</x-ui.page-header>

{{-- Filters --}}
<div class="card mb-6 p-4">
    <form method="GET" id="form-filter-transaksi" class="flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" id="search-transaksi" value="{{ request('search') }}"
                   placeholder="Cari invoice, nama pelanggan, atau layanan..."
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200">
        </div>
        <select name="status" id="filter-status" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20">
            <option value="">Semua Status</option>
            @foreach(['Diproses' => 'Diproses', 'Siap Diambil' => 'Siap Diambil', 'Selesai' => 'Selesai'] as $value => $label)
            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
        @if(request('search') || request('status'))
        <a href="{{ route('transactions.index') }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Reset
        </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    @if($transactions->isNotEmpty())
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-3 dark:border-slate-700">
        <p class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $transactions->firstItem() }}-{{ $transactions->lastItem() }}</span>
            dari <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $transactions->total() }}</span> transaksi
        </p>
    </div>
    @endif
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-left">Invoice</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left hidden md:table-cell">Layanan</th>
                    <th class="px-6 py-4 text-left hidden lg:table-cell">Berat</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4">
                        <div>
                            <a href="{{ route('transactions.show', $transaction) }}"
                               class="font-mono text-xs font-semibold text-primary hover:underline">
                                {{ $transaction->invoice_number }}
                            </a>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-primary-50 text-xs font-bold text-primary dark:bg-primary/20 dark:text-primary-100 shrink-0">
                                {{ strtoupper(substr($transaction->customer->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white text-xs">{{ $transaction->customer->nama }}</p>
                                <p class="text-[10px] text-slate-400">{{ $transaction->customer->telepon }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-xs">{{ $transaction->service->nama_layanan }}</td>
                    <td class="px-6 py-4 hidden lg:table-cell text-xs">{{ $transaction->berat }} Kg</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-success text-xs">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <x-ui.status-badge :status="$transaction->status" />
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1 flex-wrap">
                            <a href="{{ route('transactions.show', $transaction) }}"
                               id="btn-detail-{{ $transaction->id }}"
                               class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                Detail
                            </a>
                            <a href="{{ route('transactions.edit', $transaction) }}"
                               id="btn-edit-{{ $transaction->id }}"
                               class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-semibold text-primary hover:bg-primary-50 dark:hover:bg-primary/10 transition-colors">
                                Edit
                            </a>
                            <a href="{{ route('transactions.print-masuk', $transaction) }}" target="_blank"
                               id="btn-nota-masuk-{{ $transaction->id }}"
                               class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors">
                                Nota Masuk
                            </a>

                            @if($transaction->status === 'Diproses')
                                <form method="POST" action="{{ route('transactions.mark-siap-diambil', $transaction) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" id="btn-siap-{{ $transaction->id }}"
                                            class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-semibold text-warning hover:bg-warning-50 dark:hover:bg-warning-500/10 transition-colors">
                                        Siap Diambil
                                    </button>
                                </form>
                            @endif

                            @if($transaction->status === 'Siap Diambil')
                                <form method="POST" action="{{ route('transactions.mark-selesai', $transaction) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" id="btn-selesai-{{ $transaction->id }}"
                                            class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-semibold text-success hover:bg-success-50 dark:hover:bg-success-500/10 transition-colors">
                                        Selesai
                                    </button>
                                </form>
                            @endif

                            @if($transaction->status === 'Selesai')
                                <a href="{{ route('transactions.print-pengambilan', $transaction) }}" target="_blank"
                                   id="btn-nota-pengambilan-{{ $transaction->id }}"
                                   class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-semibold text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors">
                                    Nota Pengambilan
                                </a>
                            @endif

                            {{-- Hapus: hanya Admin --}}
                            @if(auth()->user()->isAdmin())
                            <x-ui.delete-button :action="route('transactions.destroy', $transaction)"
                                                id="btn-hapus-{{ $transaction->id }}" />
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-700">
                                <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="font-medium text-slate-500 dark:text-slate-400">
                                @if(request('search') || request('status'))
                                    Tidak ada transaksi yang cocok dengan filter
                                @else
                                    Belum ada transaksi
                                @endif
                            </p>
                            @if(!request('search') && !request('status'))
                            <a href="{{ route('transactions.create') }}" class="btn-primary text-xs">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Buat Transaksi Pertama
                            </a>
                            @endif
                        </div>
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
