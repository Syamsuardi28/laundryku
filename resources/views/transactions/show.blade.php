@extends('layouts.laundry')

@section('content')

{{-- Header --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between animate-fade-in">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <span class="font-mono text-xs font-semibold text-primary bg-primary-50 dark:bg-primary/20 px-2.5 py-1 rounded-lg">{{ $transaction->invoice_number }}</span>
            <x-ui.status-badge :status="$transaction->status" />
        </div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Detail Transaksi</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ $transaction->tanggal_masuk->translatedFormat('l, d F Y H:i') }}</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('transactions.print-masuk', $transaction) }}" target="_blank" class="btn-primary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Nota Masuk
        </a>
        @if($transaction->status === 'Selesai')
        <a href="{{ route('transactions.print-pengambilan', $transaction) }}" target="_blank" class="btn-success">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Nota Pengambilan
        </a>
        @endif
        <a href="{{ route('transactions.edit', $transaction) }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        <a href="{{ route('transactions.index') }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- LEFT: Transaction Details --}}
    <div class="space-y-6 lg:col-span-2">

        {{-- Customer Info --}}
        <div class="card p-6">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-4">Informasi Pelanggan</h3>
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-50 to-blue-100 text-xl font-bold text-primary dark:from-primary/20 dark:to-blue-500/20 dark:text-primary-100 shrink-0">
                    {{ strtoupper(substr($transaction->customer->nama, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-lg text-slate-900 dark:text-white">{{ $transaction->customer->nama }}</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $transaction->customer->telepon }}</p>
                    @if($transaction->customer->alamat)
                    <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $transaction->customer->alamat }}</p>
                    @endif
                </div>
                <a href="{{ route('customers.edit', $transaction->customer) }}"
                   class="text-xs font-medium text-primary hover:underline shrink-0">
                    Lihat Profil
                </a>
            </div>
        </div>

        {{-- Transaction Details --}}
        <div class="card p-6">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-4">Detail Laundry</h3>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                @foreach([
                    ['Layanan', $transaction->service->nama_layanan, 'bg-primary-50 text-primary dark:bg-primary/20 dark:text-primary-100'],
                    ['Berat', $transaction->berat . ' Kg', 'bg-slate-50 text-slate-700 dark:bg-slate-700 dark:text-slate-200'],
                    ['Harga/Kg', 'Rp ' . number_format($transaction->service->harga_per_kg, 0, ',', '.'), 'bg-slate-50 text-slate-700 dark:bg-slate-700 dark:text-slate-200'],
                    ['Petugas', $transaction->user->name, 'bg-slate-50 text-slate-700 dark:bg-slate-700 dark:text-slate-200'],
                    ['Tanggal Masuk', $transaction->tanggal_masuk->format('d/m/Y H:i'), 'bg-slate-50 text-slate-700 dark:bg-slate-700 dark:text-slate-200'],
                    ['Estimasi Selesai', $transaction->tanggal_estimasi->format('d/m/Y H:i'), 'bg-slate-50 text-slate-700 dark:bg-slate-700 dark:text-slate-200'],
                    ['Status Pembayaran', $transaction->status_pembayaran, $transaction->status_pembayaran === 'Lunas' ? 'bg-success-50 text-success-700 dark:bg-success-500/10' : 'bg-danger-50 text-danger dark:bg-danger-500/10'],
                    ['Tanggal Diambil', $transaction->tanggal_diambil ? $transaction->tanggal_diambil->format('d/m/Y H:i') : 'Belum Diambil', 'bg-slate-50 text-slate-700 dark:bg-slate-700 dark:text-slate-200'],
                ] as [$label, $value, $cls])
                <div class="rounded-xl p-4 {{ $cls }}">
                    <p class="text-xs font-semibold uppercase tracking-wider opacity-60 mb-1">{{ $label }}</p>
                    <p class="font-bold text-sm">{{ $value }}</p>
                </div>
                @endforeach
                {{-- Total --}}
                <div class="rounded-xl bg-success-50 p-4 dark:bg-success-500/10 col-span-2 sm:col-span-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-success-600 dark:text-success opacity-80 mb-1">Total Harga</p>
                    <p class="text-xl font-bold text-success">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Status Info --}}
        <div class="card p-6">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3">Status Pemrosesan</h3>
            <div class="flex items-center gap-4 rounded-xl border border-slate-200 p-4 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                <div class="h-3.5 w-3.5 rounded-full shrink-0 animate-pulse
                            @if($transaction->status === 'Diproses') bg-warning
                            @elseif($transaction->status === 'Siap Diambil') bg-primary
                            @else bg-success @endif"></div>
                <div>
                    <p class="font-semibold text-slate-900 dark:text-white text-sm">
                        @if($transaction->status === 'Diproses')
                            Laundry sedang diproses oleh petugas.
                        @elseif($transaction->status === 'Siap Diambil')
                            Laundry telah selesai diproses dan siap diambil oleh pelanggan.
                        @else
                            Laundry telah diambil oleh pelanggan dan transaksi selesai.
                        @endif
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5">Status saat ini: <strong class="text-slate-700 dark:text-slate-300">{{ $transaction->status }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: Quick Actions --}}
    <div class="space-y-4">

        {{-- Quick Status Update --}}
        <div class="card p-5">
            <h3 class="font-semibold text-slate-900 dark:text-white text-sm mb-4">Ubah Status Laundry</h3>
            
            @if($transaction->status === 'Diproses')
                <form method="POST" action="{{ route('transactions.mark-siap-diambil', $transaction) }}" data-loading class="space-y-3">
                    @csrf @method('PATCH')
                    <div class="rounded-xl border border-warning/20 bg-warning-50/50 p-3 dark:bg-warning-500/5">
                        <p class="text-xs text-warning-700 dark:text-warning-500">
                            Pekerjaan cuci/setrika telah selesai? Tandai sebagai Siap Diambil agar pelanggan mengetahui.
                        </p>
                    </div>
                    <button type="submit" class="btn-primary w-full py-3">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        Tandai Siap Diambil
                    </button>
                </form>
            @elseif($transaction->status === 'Siap Diambil')
                <form method="POST" action="{{ route('transactions.mark-selesai', $transaction) }}" data-loading class="space-y-3">
                    @csrf @method('PATCH')
                    <div class="rounded-xl border border-success/20 bg-success-50/50 p-3 dark:bg-success-500/5">
                        <p class="text-xs text-success-700 dark:text-success-500">
                            Pelanggan datang mengambil pakaian? Klik tombol di bawah untuk menyelesaikan transaksi.
                        </p>
                    </div>
                    <button type="submit" class="btn-success w-full py-3 text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Tandai Telah Diambil (Selesai)
                    </button>
                </form>
            @else
                <div class="rounded-xl bg-success-50 p-4 text-center dark:bg-success-500/10 border border-success-200/50">
                    <svg class="mx-auto h-8 w-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="mt-2 text-xs font-semibold text-success-800 dark:text-success-400">Laundry Telah Diambil</p>
                    <p class="text-[10px] text-slate-400 mt-1">Transaksi Selesai pada {{ $transaction->tanggal_diambil ? $transaction->tanggal_diambil->format('d/m/Y H:i') : '-' }}</p>
                </div>
            @endif
        </div>

        {{-- Quick Links --}}
        <div class="card p-5">
            <h3 class="font-semibold text-slate-900 dark:text-white text-sm mb-3">Aksi Cepat</h3>
            <div class="space-y-2">
                <a href="{{ route('transactions.print-masuk', $transaction) }}" target="_blank"
                   class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:border-primary hover:bg-primary-50 hover:text-primary transition-all dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Nota Masuk
                </a>
                @if($transaction->status === 'Selesai')
                <a href="{{ route('transactions.print-pengambilan', $transaction) }}" target="_blank"
                   class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:border-success hover:bg-success-50 hover:text-success transition-all dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Nota Pengambilan
                </a>
                @endif
                <a href="{{ route('transactions.edit', $transaction) }}"
                   class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:border-primary hover:bg-primary-50 hover:text-primary transition-all dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Transaksi
                </a>
                <a href="{{ route('transactions.create') }}"
                   class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:border-primary hover:bg-primary-50 hover:text-primary transition-all dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
