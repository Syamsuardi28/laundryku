@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Layanan" subtitle="Daftar layanan laundry dan harga">
    <x-slot:actions>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('services.create') }}" class="btn-primary" id="btn-tambah-layanan">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Layanan
        </a>
        @endif
    </x-slot:actions>
</x-ui.page-header>

{{-- Info banner untuk Petugas --}}
@if(auth()->user()->isPetugas())
<div class="mb-6 flex items-center gap-3 rounded-2xl border border-primary-100 bg-primary-50 px-4 py-3 dark:border-primary/20 dark:bg-primary/10">
    <svg class="h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <p class="text-sm text-primary dark:text-primary-100">Anda hanya dapat melihat daftar layanan. Pengelolaan layanan hanya dapat dilakukan oleh Admin.</p>
</div>
@endif

{{-- Search Bar --}}
<div class="card mb-6 p-4">
    <form method="GET" class="flex flex-col gap-3 sm:flex-row items-center" id="form-search-layanan" x-data x-ref="form">
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-slate-500">Tampilkan</span>
            <select name="per_page" @change="$refs.form.submit()" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20">
                @foreach([10, 25, 50, 100] as $val)
                <option value="{{ $val }}" @selected(request('per_page', 10) == $val)>{{ $val }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="relative flex-1 w-full">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" id="search-layanan" value="{{ request('search') }}" placeholder="Cari nama layanan atau deskripsi..."
                   @input.debounce.500ms="$refs.form.submit()"
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-400">
        </div>
        <button type="submit" class="btn-secondary hidden sm:flex" id="btn-cari-layanan">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cari
        </button>
        @if(request('search'))
        <a href="{{ route('services.index') }}" class="btn-secondary" id="btn-reset-search">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Reset
        </a>
        @endif
    </form>
</div>

<div class="card overflow-hidden">
    @if($services->isNotEmpty())
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-3 dark:border-slate-700">
        <p class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $services->firstItem() }}-{{ $services->lastItem() }}</span>
            dari <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $services->total() }}</span> layanan
        </p>
    </div>
    @endif
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-left"><x-ui.sortable-header column="nama_layanan">Nama Layanan</x-ui.sortable-header></th>
                    <th class="px-6 py-4 text-left"><x-ui.sortable-header column="harga_per_kg">Harga/Kg</x-ui.sortable-header></th>
                    <th class="px-6 py-4 text-left">Deskripsi</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-6 py-4 text-right">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($services as $service)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-success-50 text-success dark:bg-success-500/20 shrink-0">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <span class="font-semibold text-slate-900 dark:text-white">@highlight($service->nama_layanan, request('search'))</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-lg bg-success-50 px-2.5 py-1 text-xs font-semibold text-success dark:bg-success-500/10">
                            Rp {{ number_format($service->harga_per_kg, 0, ',', '.') }}/kg
                        </span>
                    </td>
                    <td class="px-6 py-4">@highlight($service->deskripsi ?? '-', request('search'))</td>
                    @if(auth()->user()->isAdmin())
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('services.edit', $service) }}"
                               id="btn-edit-layanan-{{ $service->id }}"
                               class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary-50 dark:hover:bg-primary/10 transition-colors">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <x-ui.delete-button
                                :action="route('services.destroy', $service)"
                                id="btn-hapus-layanan-{{ $service->id }}" />
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-700">
                                <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <p class="font-medium text-slate-500 dark:text-slate-400">Belum ada data layanan</p>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('services.create') }}" class="btn-primary text-xs">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Layanan Pertama
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($services->hasPages())
    <div class="border-t border-slate-100 px-6 py-4 dark:border-slate-700">
        {{ $services->links() }}
    </div>
    @endif
</div>
@endsection
