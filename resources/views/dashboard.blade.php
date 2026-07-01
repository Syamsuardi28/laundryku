@extends('layouts.laundry')

@section('content')

{{-- Page Header --}}
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between animate-fade-in">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Dashboard Overview</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Selamat datang kembali, <span class="font-semibold text-primary-600 dark:text-primary-400">{{ auth()->user()->name }}</span>
            · {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('transactions.create') }}" class="btn-primary group relative overflow-hidden rounded-[14px] shadow-soft hover:shadow-card hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 h-11 px-5" id="btn-transaksi-baru">
            <svg class="h-5 w-5 text-white/90 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="font-bold text-white tracking-wide">Transaksi Baru</span>
        </a>
    </div>
</div>

{{-- ============================================================
     PREMIUM STATS (6 CARDS)
     ============================================================ --}}
<div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-6 mb-8">
    {{-- Total Pelanggan --}}
    <div class="card p-5 animate-slide-up group" style="animation-delay: 0ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Total Pelanggan</p>
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight" x-data="{ count: 0 }" x-init="let target = {{ $stats['total_pelanggan'] }}; let step = Math.max(1, target / 30); let int = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(int); } }, 20)" x-text="Math.floor(count).toLocaleString('id-ID')">0</p>
                <p class="mt-2 flex items-center gap-1 text-[11px] font-medium text-slate-500">
                    <span class="text-success flex items-center gap-0.5 bg-success/10 px-1.5 py-0.5 rounded-md">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        {{ $stats['pelanggan_hari_ini'] }}
                    </span>
                    <span class="text-slate-400">hari ini</span>
                </p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-primary/10 text-primary dark:bg-primary/20 shrink-0 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Total Transaksi --}}
    <div class="card p-5 animate-slide-up group" style="animation-delay: 50ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Total Transaksi</p>
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight" x-data="{ count: 0 }" x-init="let target = {{ $stats['total_transaksi'] }}; let step = Math.max(1, target / 30); let int = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(int); } }, 20)" x-text="Math.floor(count).toLocaleString('id-ID')">0</p>
                <p class="mt-2 flex items-center gap-1 text-[11px] font-medium text-slate-500">
                    <span class="text-blue-500 flex items-center gap-0.5 bg-blue-500/10 px-1.5 py-0.5 rounded-md">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        {{ $stats['transaksi_hari_ini'] }}
                    </span>
                    <span class="text-slate-400">hari ini</span>
                </p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-blue-500/10 text-blue-500 dark:bg-blue-500/20 shrink-0 group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
    </div>

    {{-- Laundry Diproses --}}
    <div class="card p-5 animate-slide-up group" style="animation-delay: 100ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Diproses</p>
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight" x-data="{ count: 0 }" x-init="let target = {{ $stats['laundry_diproses'] }}; let step = Math.max(1, target / 30); let int = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(int); } }, 20)" x-text="Math.floor(count).toLocaleString('id-ID')">0</p>
                <p class="mt-2 text-[11px] font-medium text-slate-400 truncate">Sedang dikerjakan</p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-warning/10 text-warning dark:bg-warning/20 shrink-0 group-hover:scale-110 transition-all duration-300">
                <svg class="h-5 w-5 animate-spin-slow text-warning" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Laundry Siap Diambil --}}
    <div class="card p-5 animate-slide-up group" style="animation-delay: 150ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Siap Diambil</p>
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight" x-data="{ count: 0 }" x-init="let target = {{ $stats['laundry_siap_diambil'] }}; let step = Math.max(1, target / 30); let int = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(int); } }, 20)" x-text="Math.floor(count).toLocaleString('id-ID')">0</p>
                <p class="mt-2 text-[11px] font-medium text-slate-400 truncate">Menunggu pelanggan</p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-indigo-500/10 text-indigo-500 dark:bg-indigo-500/20 shrink-0 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Laundry Selesai --}}
    <div class="card p-5 animate-slide-up group" style="animation-delay: 200ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Selesai</p>
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight" x-data="{ count: 0 }" x-init="let target = {{ $stats['laundry_selesai'] }}; let step = Math.max(1, target / 30); let int = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(int); } }, 20)" x-text="Math.floor(count).toLocaleString('id-ID')">0</p>
                <p class="mt-2 text-[11px] font-medium text-slate-400 truncate">Telah diserahkan</p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-success/10 text-success dark:bg-success/20 shrink-0 group-hover:scale-110 group-hover:bg-success group-hover:text-white transition-all duration-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
    </div>

    {{-- Pendapatan Hari Ini --}}
    <div class="card p-5 animate-slide-up group relative overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-500/10 dark:to-emerald-500/5 border-emerald-200 dark:border-emerald-500/20" style="animation-delay: 250ms">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-600/70 dark:text-emerald-400/70 mb-1">Pendapatan (Hari Ini)</p>
                <p class="text-2xl font-black text-emerald-700 dark:text-emerald-400 tracking-tight truncate mt-1" x-data="{ count: 0 }" x-init="let target = {{ $stats['pendapatan_hari_ini'] }}; let step = Math.max(1, target / 30); let int = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(int); } }, 20)" x-text="'Rp ' + Math.floor(count).toLocaleString('id-ID')">Rp 0</p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 shrink-0 group-hover:scale-110 transition-all duration-300">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     CHARTS & QUEUE
     ============================================================ --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-8">
    {{-- Revenue Chart --}}
    <div class="card p-6 lg:col-span-2 flex flex-col relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent pointer-events-none opacity-50"></div>
        
        <div class="flex items-center justify-between mb-8 relative z-10">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Pendapatan Bulanan</h2>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">Total di tahun {{ now()->year }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Bulan Ini</p>
                    <p class="text-lg font-black text-success">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="flex-1 min-h-[280px] relative z-10">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Active Laundry Queue --}}
    <div class="card flex flex-col">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/60 px-6 py-5">
            <div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">Antrian Aktif</h2>
                <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $stats['laundry_aktif'] }} pesanan diproses</p>
            </div>
            <a href="{{ route('transactions.index') }}?status=Diproses" class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-primary/10 hover:text-primary transition-colors dark:bg-slate-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        <div class="flex-1 overflow-y-auto p-2 scrollbar-thin">
            @forelse($activeTransactions as $trx)
            <a href="{{ route('transactions.show', $trx) }}" class="group flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors mb-1">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-mono text-xs font-bold text-slate-900 dark:text-white">{{ $trx->invoice_number }}</span>
                        <x-ui.status-badge :status="$trx->status" />
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="truncate">{{ $trx->customer->nama }}</span>
                        <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                        <span class="text-primary-600 dark:text-primary-400 font-bold">{{ $trx->berat }}kg</span>
                    </div>
                </div>
                <div class="ml-3 shrink-0 flex items-center justify-center h-8 w-8 rounded-full border border-slate-200 dark:border-slate-700 text-slate-400 group-hover:border-primary group-hover:text-primary group-hover:bg-primary/5 transition-all">
                    <svg class="h-4 w-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
            </a>
            @empty
            <div class="flex flex-col items-center justify-center h-full py-12 px-4 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-1">Tidak ada antrian</h3>
                <p class="text-xs text-slate-500">Semua pesanan telah selesai dikerjakan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ============================================================
     RECENT TRANSACTIONS TABLE
     ============================================================ --}}
<div class="card overflow-hidden">
    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/60 px-6 py-5">
        <div>
            <h2 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">Transaksi Terbaru</h2>
            <p class="text-xs font-medium text-slate-500 mt-0.5">Menampilkan 8 transaksi terakhir</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="text-sm font-bold text-primary hover:text-primary-600 transition-colors flex items-center gap-1 group">
            Lihat Semua 
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead class="bg-slate-50/50 dark:bg-slate-800/20 text-xs uppercase font-bold text-slate-500 tracking-wider">
                <tr>
                    <th class="px-6 py-4 rounded-tl-xl">Invoice</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4 hidden md:table-cell">Layanan</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-slate-700 dark:text-slate-300 font-medium">
                @forelse($recentTransactions as $idx => $transaction)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group animate-slide-up" style="animation-delay: {{ $idx * 50 }}ms; animation-fill-mode: both;">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('transactions.show', $transaction) }}" class="font-mono text-xs font-bold text-primary hover:text-primary-600 transition-colors">
                            {{ $transaction->invoice_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm shrink-0">
                                {{ strtoupper(substr($transaction->customer->nama, 0, 1)) }}
                            </div>
                            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $transaction->customer->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell whitespace-nowrap text-xs text-slate-500">
                        {{ $transaction->service->nama_layanan }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-black text-slate-900 dark:text-white">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-ui.status-badge :status="$transaction->status" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('transactions.print-masuk', $transaction) }}" target="_blank" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors tooltip" data-tip="Cetak Nota">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            </a>
                            <a href="{{ route('transactions.show', $transaction) }}" class="btn-secondary h-8 px-3 text-xs font-bold rounded-xl flex items-center gap-1">
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center">
                                <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Belum ada transaksi</p>
                            <p class="text-xs text-slate-500">Mulai buat transaksi pertama Anda.</p>
                            <a href="{{ route('transactions.create') }}" class="btn-primary h-9 px-4 mt-2">Buat Transaksi</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(148, 163, 184, 0.05)' : 'rgba(148, 163, 184, 0.1)';
    const textColor = isDark ? '#64748b' : '#94a3b8';

    // Chart.js gradient setup
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.5)'); // Primary color with opacity
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

    new Chart(document.getElementById('revenueChart'), {
        type: 'line', // Switched to line chart for a more premium look
        data: {
            labels: @json($monthLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($monthData),
                borderColor: '#2563EB', // Primary
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563EB',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4 // Smooth curves
            }]
        },
        options: {
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#ffffff',
                    titleColor: isDark ? '#f8fafc' : '#0f172a',
                    bodyColor: isDark ? '#cbd5e1' : '#475569',
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) { label += ': '; }
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: gridColor,
                        drawBorder: false,
                    },
                    border: { display: false },
                    ticks: {
                        color: textColor,
                        font: { family: "'Inter', sans-serif", size: 11, weight: 500 },
                        padding: 10,
                        callback: function(value) {
                            if (value >= 1000000) { return 'Rp ' + (value / 1000000).toFixed(1) + 'jt'; }
                            if (value >= 1000) { return 'Rp ' + (value / 1000) + 'k'; }
                            return 'Rp ' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    border: { display: false },
                    ticks: {
                        color: textColor,
                        font: { family: "'Inter', sans-serif", size: 11, weight: 500 },
                        padding: 10
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
