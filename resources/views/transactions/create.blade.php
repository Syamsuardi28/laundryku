@extends('layouts.laundry')

@section('content')

{{-- Page Header --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between animate-fade-in">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Buat Transaksi Baru</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ikuti langkah-langkah untuk membuat transaksi laundry</p>
    </div>
    <a href="{{ route('transactions.index') }}" class="btn-secondary self-start">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

{{-- ============================================================
     MAIN FORM — 2 column POS Layout
============================================================ --}}
<form method="POST" action="{{ route('transactions.store') }}" id="transaction-form" data-loading>
@csrf

@if ($errors->any())
    <div class="mb-4 rounded-xl bg-danger-50 border border-danger/20 p-4 text-sm text-danger dark:bg-danger-500/10 dark:text-danger-400">
        <p class="font-semibold mb-1">Perbaiki kesalahan berikut:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- ============================================================
         LEFT COLUMN: Input Fields
    ============================================================ --}}
    <div class="space-y-5 lg:col-span-2">

        {{-- ===== STEP 1: Customer Selection ===== --}}
        <div class="card p-6" id="step-customer">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-xs font-bold text-white shrink-0">1</div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Pilih Pelanggan</h2>
            </div>

            {{-- Smart Customer Search --}}
            <div class="relative" x-data="customerSearch()" x-init="init()">

                {{-- Hidden input for form submission --}}
                <input type="hidden" name="customer_id" id="customer_id" x-model="selectedId" required>

                {{-- Selected Customer Display --}}
                <div x-show="selectedId" x-cloak
                     class="mb-3 flex items-center justify-between rounded-xl border border-success/30 bg-success-50 px-4 py-3 dark:border-success/20 dark:bg-success-500/10">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-success/20 text-sm font-bold text-success shrink-0" x-text="selectedName ? selectedName.charAt(0).toUpperCase() : ''"></div>
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white text-sm" x-text="selectedName"></p>
                            <p class="text-xs text-slate-500 dark:text-slate-400" x-text="selectedPhone"></p>
                        </div>
                    </div>
                    <button type="button" @click="clearSelection()"
                            class="text-xs font-medium text-slate-500 hover:text-danger transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Search Input --}}
                <div x-show="!selectedId">
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text"
                               x-model="query"
                               @input.debounce.300ms="search()"
                               @focus="showDropdown = true"
                               @keydown.escape="showDropdown = false"
                               @keydown.arrow-down.prevent="moveDown()"
                               @keydown.arrow-up.prevent="moveUp()"
                               @keydown.enter.prevent="selectHighlighted()"
                               id="customer-search-input"
                               placeholder="Ketik nama atau nomor telepon pelanggan..."
                               autocomplete="off"
                               class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500">
                        {{-- Loading spinner --}}
                        <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="h-4 w-4 animate-spin text-primary" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Dropdown Results --}}
                    <div x-show="showDropdown && (results.length > 0 || (query.length >= 2 && !loading))" x-cloak
                         @click.outside="showDropdown = false"
                         class="absolute z-30 mt-1.5 w-full rounded-2xl border border-slate-200 bg-white shadow-elevated dark:border-slate-700 dark:bg-slate-800 overflow-hidden">

                        {{-- Results list --}}
                        <template x-for="(customer, index) in results" :key="customer.id">
                            <button type="button"
                                    @click="selectCustomer(customer)"
                                    :class="index === highlightedIndex ? 'bg-primary-50 dark:bg-primary/10' : 'hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                                    class="flex w-full items-center gap-3 px-4 py-3 text-left transition-colors border-b border-slate-100 dark:border-slate-700 last:border-0">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-sm font-bold text-primary dark:bg-primary/20 dark:text-primary-100 shrink-0"
                                     x-text="customer.nama.charAt(0).toUpperCase()"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-slate-900 dark:text-white text-sm" x-text="customer.nama"></p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400" x-text="customer.telepon"></p>
                                </div>
                                <svg class="h-4 w-4 text-slate-300 dark:text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </template>

                        {{-- Not found state --}}
                        <div x-show="results.length === 0 && query.length >= 2 && !loading"
                             class="px-4 py-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    Pelanggan "<span class="font-semibold" x-text="query"></span>" tidak ditemukan
                                </p>
                            </div>
                            <button type="button" @click="openAddModal()"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl border-2 border-dashed border-primary/40 bg-primary-50/50 px-4 py-2.5 text-sm font-semibold text-primary hover:border-primary hover:bg-primary-50 transition-all dark:bg-primary/10 dark:hover:bg-primary/20">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                + Tambah Pelanggan Baru
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Shortcut: Add New Customer --}}
                <div x-show="!selectedId" class="mt-3 flex items-center gap-2">
                    <div class="flex-1 border-t border-slate-200 dark:border-slate-700"></div>
                    <span class="text-xs text-slate-400">atau</span>
                    <div class="flex-1 border-t border-slate-200 dark:border-slate-700"></div>
                </div>
                <button type="button" x-show="!selectedId" @click="openAddModal()"
                        class="mt-3 w-full flex items-center justify-center gap-2 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-600 hover:border-primary hover:bg-primary-50 hover:text-primary transition-all dark:border-slate-600 dark:bg-slate-800 dark:text-slate-400 dark:hover:border-primary dark:hover:bg-primary/10">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Tambah Pelanggan Baru
                </button>

                @error('customer_id')
                <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-danger">
                    <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>
        </div>

        {{-- ===== STEP 2: Service & Weight ===== --}}
        <div class="card p-6">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-xs font-bold text-white shrink-0">2</div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Detail Laundry</h2>
            </div>

            <div class="space-y-4">
                {{-- Service Selection --}}
                <div class="space-y-1.5">
                    <label for="service_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Jenis Layanan <span class="text-danger">*</span>
                    </label>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-{{ min(count($services), 3) }}">
                        @foreach($services as $service)
                        <label class="service-card relative cursor-pointer" data-harga="{{ $service->harga_per_kg }}">
                            <input type="radio" name="service_id" value="{{ $service->id }}"
                                   data-harga="{{ $service->harga_per_kg }}"
                                   class="peer sr-only"
                                   @if(old('service_id') == $service->id) checked @endif
                                   onchange="updateServiceCard(this)">
                            <div class="rounded-xl border-2 border-slate-200 bg-white p-4 transition-all peer-checked:border-primary peer-checked:bg-primary-50 hover:border-primary-300 dark:border-slate-600 dark:bg-slate-800 peer-checked:dark:border-primary peer-checked:dark:bg-primary/10">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $service->nama_layanan }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $service->deskripsi ?? 'Layanan laundry' }}</p>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <p class="text-sm font-bold text-primary">Rp {{ number_format($service->harga_per_kg, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-slate-400">/kg</p>
                                    </div>
                                </div>
                                {{-- Checkmark --}}
                                <div class="absolute right-3 top-3 hidden peer-checked:block">
                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-primary">
                                        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('service_id')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-danger">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Weight Input --}}
                <div class="space-y-1.5">
                    <label for="berat" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Berat Cucian (Kg) <span class="text-danger">*</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <input type="number" name="berat" id="berat"
                                   value="{{ old('berat') }}"
                                   placeholder="0.0"
                                   step="0.1" min="0.1"
                                   oninput="calculateTotal()"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-12 text-sm placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 @error('berat') border-danger focus:border-danger focus:ring-danger/20 @enderror"
                                   required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-400">Kg</span>
                        </div>
                        {{-- Quick weight buttons --}}
                        <div class="flex gap-1.5">
                            @foreach([1, 2, 3, 5] as $w)
                            <button type="button" onclick="setWeight({{ $w }})"
                                    class="rounded-xl border border-slate-200 bg-white px-3 py-3 text-xs font-semibold text-slate-600 hover:border-primary hover:bg-primary-50 hover:text-primary transition-all dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                {{ $w }}kg
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @error('berat')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-danger">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Estimasi Selesai --}}
                <div class="space-y-1.5">
                    <label for="tanggal_estimasi" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Estimasi Selesai <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" name="tanggal_estimasi" id="tanggal_estimasi"
                           value="{{ old('tanggal_estimasi', now()->addDays(2)->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100"
                           required>
                    @error('tanggal_estimasi')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-danger">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Status Pembayaran --}}
                <div class="space-y-1.5">
                    <label for="status_pembayaran" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Status Pembayaran <span class="text-danger">*</span>
                    </label>
                    <select name="status_pembayaran" id="status_pembayaran"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <option value="Belum Lunas" @selected(old('status_pembayaran') === 'Belum Lunas')>Belum Lunas</option>
                        <option value="Lunas" @selected(old('status_pembayaran') === 'Lunas')>Lunas</option>
                    </select>
                    @error('status_pembayaran')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-danger">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         RIGHT COLUMN: Order Summary
    ============================================================ --}}
    <div class="space-y-4">

        {{-- Invoice Preview --}}
        <div class="card p-5">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700">
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="font-semibold text-slate-900 dark:text-white text-sm">Ringkasan Transaksi</h3>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 dark:text-slate-400">Invoice</span>
                    <span class="font-mono text-xs font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-lg">AUTO</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 dark:text-slate-400">Petugas</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 dark:text-slate-400">Tanggal</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ now()->format('d/m/Y') }}</span>
                </div>
                <div class="border-t border-slate-100 dark:border-slate-700 pt-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-slate-500 dark:text-slate-400">Layanan</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right" id="summary-service">—</span>
                    </div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-slate-500 dark:text-slate-400">Harga/Kg</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200" id="summary-price">—</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 dark:text-slate-400">Berat</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200" id="summary-berat">— Kg</span>
                    </div>
                </div>
            </div>

            {{-- Total --}}
            <div class="mt-4 rounded-2xl bg-gradient-to-br from-primary-50 to-blue-50 p-4 dark:from-primary/10 dark:to-blue-500/5 border border-primary-100 dark:border-primary/20">
                <p class="text-xs font-semibold uppercase tracking-wider text-primary dark:text-primary-100 mb-1">Total Harga</p>
                <p class="text-3xl font-bold text-primary dark:text-white" id="total-preview">Rp 0</p>
            </div>

            {{-- Status default --}}
            <div class="mt-3 flex items-center gap-2 rounded-xl bg-warning-50 px-3 py-2 dark:bg-warning-500/10">
                <span class="h-2 w-2 rounded-full bg-warning shrink-0"></span>
                <span class="text-xs font-medium text-warning-600 dark:text-warning-500">Status awal: Diproses</span>
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" id="btn-submit-transaction"
                class="btn-primary w-full py-3.5 text-base shadow-card hover:shadow-elevated">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Transaksi
        </button>
        <a href="{{ route('transactions.index') }}" class="btn-secondary w-full py-3 justify-center">
            Batal
        </a>

        {{-- Business Flow Guide --}}
        <div class="card p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3">Alur Transaksi</p>
            <div class="space-y-2">
                @foreach([
                    ['Pilih pelanggan', 'Cari atau tambah baru', 'primary'],
                    ['Pilih layanan', 'Tentukan jenis cuci', 'primary'],
                    ['Input berat', 'Harga otomatis dihitung', 'primary'],
                    ['Simpan transaksi', 'Invoice otomatis dibuat', 'success'],
                    ['Cetak nota', 'Berikan ke pelanggan', 'success'],
                ] as $i => [$step, $desc, $color])
                <div class="flex items-start gap-2.5">
                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-{{ $color }}-50 dark:bg-{{ $color }}-500/20 text-{{ $color }} shrink-0 mt-0.5">
                        <span class="text-[9px] font-bold">{{ $i + 1 }}</span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $step }}</p>
                        <p class="text-[10px] text-slate-400">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

</form>

{{-- ============================================================
     MODAL: Tambah Pelanggan Baru (Flowbite + AlpineJS)
============================================================ --}}
<div id="modal-add-customer"
     tabindex="-1"
     aria-hidden="true"
     class="fixed left-0 right-0 top-0 z-[99] hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden p-4 md:inset-0">
    <div class="relative max-h-full w-full max-w-md">
        {{-- Modal content --}}
        <div class="relative rounded-2xl bg-white shadow-xl dark:bg-slate-800">
            {{-- Modal header --}}
            <div class="flex items-center justify-between rounded-t-2xl border-b border-slate-100 p-5 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white">Tambah Pelanggan Baru</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Pelanggan akan langsung terpilih</p>
                    </div>
                </div>
                <button type="button" data-modal-hide="modal-add-customer"
                        class="rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="p-6">
                {{-- Alert area --}}
                <div id="modal-alert" class="mb-4 hidden rounded-xl px-4 py-3 text-sm font-medium"></div>

                <form id="form-add-customer" class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="modal-nama" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Nama Pelanggan <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="modal-nama" name="nama"
                               placeholder="Nama lengkap pelanggan"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100"
                               required>
                        <p class="hidden text-xs text-danger" id="error-nama"></p>
                    </div>

                    <div class="space-y-1.5">
                        <label for="modal-telepon" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Nomor Telepon <span class="text-danger">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="text" id="modal-telepon" name="telepon"
                                   placeholder="08xxxxxxxxxx"
                                   class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100"
                                   required>
                        </div>
                        <p class="hidden text-xs text-danger" id="error-telepon"></p>
                    </div>

                    <div class="space-y-1.5">
                        <label for="modal-alamat" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Alamat</label>
                        <textarea id="modal-alamat" name="alamat" rows="2"
                                  placeholder="Alamat pelanggan (opsional)"
                                  class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 resize-none"></textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" id="btn-save-customer"
                                class="btn-primary flex-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span id="btn-save-text">Simpan & Pilih</span>
                        </button>
                        <button type="button" data-modal-hide="modal-add-customer" class="btn-secondary">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ============================================================
// Smart Customer Search — AlpineJS Component
// ============================================================
function customerSearch() {
    return {
        query: '',
        results: [],
        loading: false,
        showDropdown: false,
        selectedId: '{{ old('customer_id', '') }}',
        selectedName: '',
        selectedPhone: '',
        highlightedIndex: -1,
        searchTimeout: null,

        init() {
            // Restore selection dari old() jika ada (form validation error)
            @if(old('customer_id'))
                this.restoreOldCustomer({{ old('customer_id') }});
            @endif

            // Expose openAddModal ke window
            window.openCustomerModal = () => this.openAddModal();
        },

        async restoreOldCustomer(id) {
            // Ambil data customer dari results jika sudah ada,
            // atau bisa juga dari hidden input
            this.selectedId = id;
        },

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                this.showDropdown = false;
                return;
            }

            this.loading = true;
            this.showDropdown = true;
            this.highlightedIndex = -1;

            try {
                const res = await fetch(`/api/customers/search?q=${encodeURIComponent(this.query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });
                this.results = await res.json();
            } catch (e) {
                this.results = [];
            } finally {
                this.loading = false;
            }
        },

        selectCustomer(customer) {
            this.selectedId    = customer.id;
            this.selectedName  = customer.nama;
            this.selectedPhone = customer.telepon;
            this.query         = '';
            this.showDropdown  = false;
            this.results       = [];
        },

        clearSelection() {
            this.selectedId    = '';
            this.selectedName  = '';
            this.selectedPhone = '';
        },

        moveDown() {
            if (this.highlightedIndex < this.results.length - 1) this.highlightedIndex++;
        },

        moveUp() {
            if (this.highlightedIndex > 0) this.highlightedIndex--;
        },

        selectHighlighted() {
            if (this.highlightedIndex >= 0 && this.results[this.highlightedIndex]) {
                this.selectCustomer(this.results[this.highlightedIndex]);
            }
        },

        openAddModal() {
            this.showDropdown = false;
            // Set nama dari query ke modal input
            document.getElementById('modal-nama').value = this.query;
            // Open Flowbite modal
            const modal = FlowbiteInstances.getInstance('Modal', 'modal-add-customer');
            if (modal) modal.show();
            else {
                // Fallback: initialize and show
                const el = document.getElementById('modal-add-customer');
                const m = new Modal(el, { closable: true });
                m.show();
            }
        },

        // Dipanggil setelah modal berhasil simpan customer
        onCustomerCreated(customer) {
            this.selectCustomer(customer);
        }
    };
}

// ============================================================
// Service Card Selection — Total Auto-Calculate
// ============================================================
let selectedHarga = 0;

function updateServiceCard(radio) {
    selectedHarga = parseFloat(radio.dataset.harga) || 0;

    // Update summary
    const label = radio.closest('label').querySelector('.font-semibold.text-slate-900').textContent;
    document.getElementById('summary-service').textContent = label;
    document.getElementById('summary-price').textContent = 'Rp ' + selectedHarga.toLocaleString('id-ID') + '/kg';

    calculateTotal();
}

function calculateTotal() {
    const berat = parseFloat(document.getElementById('berat').value) || 0;
    const total = Math.round(berat * selectedHarga);

    document.getElementById('total-preview').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('summary-berat').textContent = berat > 0 ? berat + ' Kg' : '— Kg';
}

function setWeight(w) {
    document.getElementById('berat').value = w;
    calculateTotal();
}

// Init if old value exists
document.addEventListener('DOMContentLoaded', () => {
    const checkedService = document.querySelector('input[name="service_id"]:checked');
    if (checkedService) updateServiceCard(checkedService);
});

// ============================================================
// AJAX: Modal Tambah Pelanggan Baru
// ============================================================
document.getElementById('form-add-customer').addEventListener('submit', async function(e) {
    e.preventDefault();

    const btn    = document.getElementById('btn-save-customer');
    const btnTxt = document.getElementById('btn-save-text');
    const alert  = document.getElementById('modal-alert');

    // Reset errors
    ['nama', 'telepon'].forEach(f => {
        const el = document.getElementById('error-' + f);
        el.textContent = '';
        el.classList.add('hidden');
    });

    // Loading state
    btn.disabled = true;
    btnTxt.textContent = 'Menyimpan...';

    try {
        const res = await fetch('/api/customers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                nama:    document.getElementById('modal-nama').value,
                telepon: document.getElementById('modal-telepon').value,
                alamat:  document.getElementById('modal-alamat').value,
            })
        });

        const data = await res.json();

        if (res.ok && data.success) {
            // Show success alert
            alert.textContent = '✓ Pelanggan berhasil ditambahkan!';
            alert.className = 'mb-4 flex items-center gap-2 rounded-xl border border-success/20 bg-success-50 px-4 py-3 text-sm font-medium text-success dark:bg-success-500/10';
            alert.classList.remove('hidden');

            // Select customer di form utama via Alpine
            const alpineEl = document.querySelector('[x-data]');
            if (alpineEl && alpineEl._x_dataStack) {
                const component = Alpine.$data(alpineEl);
                if (component.onCustomerCreated) {
                    component.onCustomerCreated(data.customer);
                }
            }

            // Reset form & close modal setelah 800ms
            setTimeout(() => {
                document.getElementById('form-add-customer').reset();
                alert.classList.add('hidden');
                const modal = FlowbiteInstances.getInstance('Modal', 'modal-add-customer');
                if (modal) modal.hide();
                else {
                    document.getElementById('modal-add-customer').classList.add('hidden');
                    document.getElementById('modal-add-customer').setAttribute('aria-hidden', 'true');
                }
            }, 800);

        } else if (res.status === 422 && data.errors) {
            // Validation errors
            Object.entries(data.errors).forEach(([field, messages]) => {
                const el = document.getElementById('error-' + field);
                if (el) {
                    el.textContent = messages[0];
                    el.classList.remove('hidden');
                }
            });
        } else {
            alert.textContent = 'Terjadi kesalahan. Coba lagi.';
            alert.className = 'mb-4 rounded-xl border border-danger/20 bg-danger-50 px-4 py-3 text-sm font-medium text-danger dark:bg-danger-500/10';
            alert.classList.remove('hidden');
        }
    } catch (err) {
        alert.textContent = 'Koneksi bermasalah. Coba lagi.';
        alert.className = 'mb-4 rounded-xl border border-danger/20 bg-danger-50 px-4 py-3 text-sm font-medium text-danger dark:bg-danger-500/10';
        alert.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        btnTxt.textContent = 'Simpan & Pilih';
    }
});
</script>
@endpush
@endsection
