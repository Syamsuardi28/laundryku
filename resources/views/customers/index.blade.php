@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Pelanggan" subtitle="Kelola data pelanggan laundry">
    <x-slot:actions>
        <a href="{{ route('customers.create') }}" class="btn-primary" id="btn-tambah-pelanggan">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pelanggan
        </a>
    </x-slot:actions>
</x-ui.page-header>

{{-- Search Bar --}}
<div class="card mb-6 p-4">
    <form method="GET" class="flex flex-col gap-3 sm:flex-row" id="form-search-pelanggan">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" id="search-pelanggan" value="{{ request('search') }}" placeholder="Cari nama, telepon, atau alamat..."
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-400">
        </div>
        <button type="submit" class="btn-secondary" id="btn-cari-pelanggan">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cari
        </button>
        @if(request('search'))
        <a href="{{ route('customers.index') }}" class="btn-secondary" id="btn-reset-search">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Reset
        </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    @if($customers->isNotEmpty())
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-3 dark:border-slate-700">
        <p class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $customers->firstItem() }}-{{ $customers->lastItem() }}</span>
            dari <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $customers->total() }}</span> pelanggan
        </p>
    </div>
    @endif
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Telepon</th>
                    <th class="px-6 py-4 text-left">Alamat</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($customers as $customer)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary-50 to-blue-100 text-sm font-bold text-primary dark:from-primary/20 dark:to-blue-500/20 dark:text-primary-100 shrink-0">
                                {{ strtoupper(substr($customer->nama, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $customer->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="tel:{{ $customer->telepon }}" class="hover:text-primary transition-colors">
                            {{ $customer->telepon }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="max-w-[200px] block truncate" title="{{ $customer->alamat ?? '-' }}">
                            {{ $customer->alamat ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('customers.edit', $customer) }}"
                               id="btn-edit-pelanggan-{{ $customer->id }}"
                               class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary-50 dark:hover:bg-primary/10 transition-colors">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            {{-- Tombol Hapus: hanya untuk Admin --}}
                            @if(auth()->user()->isAdmin())
                            <x-ui.delete-button
                                :action="route('customers.destroy', $customer)"
                                id="btn-hapus-pelanggan-{{ $customer->id }}" />
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-700">
                                <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="font-medium text-slate-500 dark:text-slate-400">
                                @if(request('search'))
                                    Tidak ada pelanggan dengan kata kunci "<span class="font-semibold">{{ request('search') }}</span>"
                                @else
                                    Belum ada data pelanggan
                                @endif
                            </p>
                            @if(!request('search'))
                            <a href="{{ route('customers.create') }}" class="btn-primary text-xs">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Pelanggan Pertama
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="border-t border-slate-100 px-6 py-4 dark:border-slate-700">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
