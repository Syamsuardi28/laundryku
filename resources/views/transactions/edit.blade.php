@extends('layouts.laundry')

@section('content')

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between animate-fade-in">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Transaksi</h1>
        <p class="mt-1 text-sm font-mono font-semibold text-primary">{{ $transaction->invoice_number }}</p>
    </div>
    <div class="flex gap-2">
        @if ($transaction->status === 'Selesai')
        <a href="{{ route('transactions.print-pengambilan', $transaction) }}" target="_blank" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Nota Pengambilan
        </a>
        @else
        <a href="{{ route('transactions.print-masuk', $transaction) }}" target="_blank" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Nota Masuk
        </a>
        @endif
        <a href="{{ route('transactions.show', $transaction) }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>
</div>

<form method="POST" action="{{ route('transactions.update', $transaction) }}" data-loading>
@csrf @method('PUT')

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

    {{-- Left Column --}}
    <div class="space-y-5 lg:col-span-2">

        {{-- Pelanggan Info (tidak bisa diubah di edit, tampilkan saja) --}}
        <div class="card p-6">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-xs font-bold text-white shrink-0">1</div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Pelanggan</h2>
            </div>
            <input type="hidden" name="customer_id" value="{{ $transaction->customer_id }}">
            <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-600 dark:bg-slate-800">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 text-sm font-bold text-primary dark:bg-primary/20 dark:text-primary-100 shrink-0">
                    {{ strtoupper(substr($transaction->customer->nama, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-slate-900 dark:text-white">{{ $transaction->customer->nama }}</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $transaction->customer->telepon }}</p>
                </div>
                <a href="{{ route('customers.edit', $transaction->customer) }}"
                   class="ml-auto text-xs font-medium text-primary hover:underline">
                    Edit Pelanggan →
                </a>
            </div>
        </div>

        {{-- Layanan & Berat --}}
        <div class="card p-6">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-xs font-bold text-white shrink-0">2</div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Detail Laundry</h2>
            </div>

            <div class="space-y-4">
                {{-- Service Cards --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Jenis Layanan <span class="text-danger">*</span>
                    </label>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-{{ min(count($services), 3) }}">
                        @foreach($services as $service)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="service_id" value="{{ $service->id }}"
                                   data-harga="{{ $service->harga_per_kg }}"
                                   class="peer sr-only"
                                   @if(old('service_id', $transaction->service_id) == $service->id) checked @endif
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
                                <div class="absolute right-3 top-3 hidden peer-checked:block">
                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-primary">
                                        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Weight --}}
                <div class="space-y-1.5">
                    <label for="berat" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Berat (Kg) <span class="text-danger">*</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <input type="number" name="berat" id="berat"
                                   value="{{ old('berat', $transaction->berat) }}"
                                   step="0.1" min="0.1"
                                   oninput="calculateTotal()"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-12 text-sm placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100"
                                   required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-400">Kg</span>
                        </div>
                        <div class="flex gap-1.5">
                            @foreach([1, 2, 3, 5] as $w)
                            <button type="button" onclick="setWeight({{ $w }})"
                                    class="rounded-xl border border-slate-200 bg-white px-3 py-3 text-xs font-semibold text-slate-600 hover:border-primary hover:bg-primary-50 hover:text-primary transition-all dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                {{ $w }}kg
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status & Tanggal Update --}}
        <div class="card p-6">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-xs font-bold text-white shrink-0">3</div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Status & Tanggal</h2>
            </div>
            
            <div class="space-y-4">
                {{-- Status Laundry --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status Laundry</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['Diproses' => ['Diproses', 'warning'], 'Siap Diambil' => ['Siap Diambil', 'primary'], 'Selesai' => ['Selesai', 'success']] as $val => [$lbl, $clr])
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="{{ $val }}"
                                   class="peer sr-only"
                                   @if(old('status', $transaction->status) == $val) checked @endif>
                            <div class="rounded-xl border-2 border-slate-200 py-3 px-2 text-center text-xs font-semibold transition-all
                                        peer-checked:border-{{ $clr === 'warning' ? 'warning-500' : ($clr === 'primary' ? 'primary' : 'success') }}
                                        peer-checked:bg-{{ $clr === 'warning' ? 'warning-50' : ($clr === 'primary' ? 'primary-50' : 'success-50') }}
                                        peer-checked:text-{{ $clr === 'warning' ? 'warning-700' : ($clr === 'primary' ? 'primary' : 'success-700') }}
                                        hover:border-slate-300
                                        text-slate-500 dark:border-slate-600 dark:bg-slate-800">
                                {{ $lbl }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Status Pembayaran --}}
                <div class="space-y-1.5">
                    <label for="status_pembayaran" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <option value="Belum Lunas" @selected(old('status_pembayaran', $transaction->status_pembayaran) === 'Belum Lunas')>Belum Lunas</option>
                        <option value="Lunas" @selected(old('status_pembayaran', $transaction->status_pembayaran) === 'Lunas')>Lunas</option>
                    </select>
                </div>

                {{-- Tanggal Masuk --}}
                <div class="space-y-1.5">
                    <label for="tanggal_masuk" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Masuk</label>
                    <input type="datetime-local" name="tanggal_masuk" id="tanggal_masuk"
                           value="{{ old('tanggal_masuk', $transaction->tanggal_masuk->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100"
                           required>
                </div>

                {{-- Estimasi Selesai --}}
                <div class="space-y-1.5">
                    <label for="tanggal_estimasi" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Estimasi Selesai</label>
                    <input type="datetime-local" name="tanggal_estimasi" id="tanggal_estimasi"
                           value="{{ old('tanggal_estimasi', $transaction->tanggal_estimasi->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100"
                           required>
                </div>

                {{-- Tanggal Diambil --}}
                <div class="space-y-1.5">
                    <label for="tanggal_diambil" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Diambil (Kosongkan jika belum diambil)</label>
                    <input type="datetime-local" name="tanggal_diambil" id="tanggal_diambil"
                           value="{{ old('tanggal_diambil', $transaction->tanggal_diambil ? $transaction->tanggal_diambil->format('Y-m-d\TH:i') : '') }}"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Summary --}}
    <div class="space-y-4">
        <div class="card p-5">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700">
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="font-semibold text-slate-900 dark:text-white text-sm">Ringkasan</h3>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Invoice</span>
                    <span class="font-mono text-xs font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-lg">{{ $transaction->invoice_number }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Dibuat</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Petugas</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $transaction->user->name }}</span>
                </div>
                <div class="border-t border-slate-100 dark:border-slate-700 pt-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-slate-500">Layanan</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right text-xs" id="summary-service">{{ $transaction->service->nama_layanan }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-slate-500">Harga/Kg</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200" id="summary-price">Rp {{ number_format($transaction->service->harga_per_kg, 0, ',', '.') }}/kg</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Berat</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-200" id="summary-berat">{{ $transaction->berat }} Kg</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-2xl bg-gradient-to-br from-primary-50 to-blue-50 p-4 dark:from-primary/10 dark:to-blue-500/5 border border-primary-100 dark:border-primary/20">
                <p class="text-xs font-semibold uppercase tracking-wider text-primary dark:text-primary-100 mb-1">Total Harga</p>
                <p class="text-3xl font-bold text-primary dark:text-white" id="total-preview">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <button type="submit" class="btn-primary w-full py-3.5 text-base">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Perubahan
        </button>
        <a href="{{ route('transactions.show', $transaction) }}" class="btn-secondary w-full py-3 justify-center">Batal</a>
    </div>
</div>

</form>

@push('scripts')
<script>
let selectedHarga = {{ $transaction->service->harga_per_kg }};

function updateServiceCard(radio) {
    selectedHarga = parseFloat(radio.dataset.harga) || 0;
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

document.addEventListener('DOMContentLoaded', () => {
    const checkedService = document.querySelector('input[name="service_id"]:checked');
    if (checkedService) updateServiceCard(checkedService);
});
</script>
@endpush
@endsection
