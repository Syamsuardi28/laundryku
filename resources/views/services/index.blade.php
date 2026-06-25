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

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-left">Nama Layanan</th>
                    <th class="px-6 py-4 text-left">Harga/Kg</th>
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
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $service->nama_layanan }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-lg bg-success-50 px-2.5 py-1 text-xs font-semibold text-success dark:bg-success-500/10">
                            Rp {{ number_format($service->harga_per_kg, 0, ',', '.') }}/kg
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $service->deskripsi ?? '-' }}</td>
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
