@extends('layouts.laundry')

@section('content')

{{-- Page Header --}}
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between animate-fade-in">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl">Dashboard</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Selamat datang, <span class="font-semibold text-slate-700 dark:text-slate-300">{{ auth()->user()->name }}</span>
            · {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('transactions.create') }}" class="btn-primary" id="btn-transaksi-baru">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Transaksi Baru
        </a>
    </div>
</div>

{{-- ============================================================
     STATS UTAMA (6 STATISTIK BARU)
     ============================================================ --}}
<div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-6 mb-6">
    {{-- Total Pelanggan --}}
    <div class="card-hover p-4 animate-slide-up" style="animation-delay: 0ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Pelanggan</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stats['total_pelanggan']) }}</p>
                <p class="mt-1 text-[10px] text-slate-400">
                    +<span class="font-semibold text-success">{{ $stats['pelanggan_hari_ini'] }}</span> hari ini
                </p>
            </div>
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary/20 dark:text-primary-100 shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Total Transaksi --}}
    <div class="card-hover p-4 animate-slide-up" style="animation-delay: 50ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Transaksi</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stats['total_transaksi']) }}</p>
                <p class="mt-1 text-[10px] text-slate-400">
                    +<span class="font-semibold text-slate-600 dark:text-slate-300">{{ $stats['transaksi_hari_ini'] }}</span> hari ini
                </p>
            </div>
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary/20 dark:text-primary-100 shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
    </div>

    {{-- Laundry Diproses --}}
    <div class="card-hover p-4 animate-slide-up" style="animation-delay: 100ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Laundry Diproses</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stats['laundry_diproses']) }}</p>
                <p class="mt-1 text-[10px] text-slate-400">Sedang dikerjakan</p>
            </div>
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-warning-50 text-warning dark:bg-warning-500/20 shrink-0">
                <svg class="h-4 w-4 animate-spin text-warning" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Laundry Siap Diambil --}}
    <div class="card-hover p-4 animate-slide-up" style="animation-delay: 150ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Siap Diambil</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stats['laundry_siap_diambil']) }}</p>
                <p class="mt-1 text-[10px] text-slate-400">Menunggu pelanggan</p>
            </div>
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400 shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Laundry Selesai --}}
    <div class="card-hover p-4 animate-slide-up" style="animation-delay: 200ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Laundry Selesai</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stats['laundry_selesai']) }}</p>
                <p class="mt-1 text-[10px] text-slate-400">Telah diserahkan</p>
            </div>
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-success-50 text-success dark:bg-success-500/20 shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
    </div>

    {{-- Pendapatan Hari Ini --}}
    <div class="card-hover p-4 animate-slide-up" style="animation-delay: 250ms">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pendapatan Hari Ini</p>
                <p class="mt-2 text-sm font-bold text-slate-900 dark:text-white truncate">Rp {{ number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</p>
                <p class="mt-1 text-[10px] text-slate-400">Hari ini</p>
            </div>
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     CHARTS + ACTIVE TRANSACTIONS
     ============================================================ --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
    {{-- Revenue Chart --}}
    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Pendapatan Bulanan</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ now()->year }}</p>
            </div>
            <span class="badge-success">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</span>
        </div>
        <div class="h-60">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Active Laundry Queue --}}
    <div class="card overflow-hidden">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 px-5 py-4">
            <div>
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Antrian Aktif</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $stats['laundry_aktif'] }} laundry perlu diproses</p>
            </div>
            <a href="{{ route('transactions.index') }}?status=Diproses" class="text-xs font-medium text-primary hover:underline">Lihat →</a>
        </div>
        <div class="divide-y divide-slate-100 dark:divide-slate-700">
            @forelse($activeTransactions as $trx)
            <div class="flex items-center justify-between px-5 py-3">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('transactions.show', $trx) }}" class="font-mono text-xs font-semibold text-slate-700 dark:text-slate-200 truncate hover:underline">{{ $trx->invoice_number }}</a>
                        <x-ui.status-badge :status="$trx->status" />
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 truncate">{{ $trx->customer->nama }} · {{ $trx->berat }}kg</p>
                </div>
                <a href="{{ route('transactions.show', $trx) }}" class="ml-3 shrink-0 text-xs text-primary hover:text-primary-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @empty
            <div class="px-5 py-8 text-center">
                <svg class="mx-auto h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="mt-2 text-xs text-slate-400">Semua laundry selesai 🎉</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ============================================================
     RECENT TRANSACTIONS TABLE
     ============================================================ --}}
<div class="card overflow-hidden">
    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900 dark:text-white">Transaksi Terbaru</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">8 transaksi terakhir</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-primary hover:text-primary-600 transition-colors">
            Lihat Semua →
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left">Invoice</th>
                    <th class="px-6 py-3 text-left">Pelanggan</th>
                    <th class="px-6 py-3 text-left hidden md:table-cell">Layanan</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($recentTransactions as $transaction)
                <tr>
                    <td class="px-6 py-4">
                        <a href="{{ route('transactions.show', $transaction) }}"
                           class="font-mono text-xs font-semibold text-primary hover:underline">
                            {{ $transaction->invoice_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-primary-50 text-xs font-bold text-primary dark:bg-primary/20 shrink-0">
                                {{ strtoupper(substr($transaction->customer->nama, 0, 1)) }}
                            </div>
                            <span class="text-xs font-medium text-slate-900 dark:text-white">{{ $transaction->customer->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-xs">{{ $transaction->service->nama_layanan }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold text-success">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4"><x-ui.status-badge :status="$transaction->status" /></td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('transactions.show', $transaction) }}"
                               class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                Detail
                            </a>
                            <a href="{{ route('transactions.print-masuk', $transaction) }}" target="_blank"
                               class="rounded-lg px-2.5 py-1.5 text-xs font-medium text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-colors">
                                Nota Masuk
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="h-10 w-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p class="text-sm text-slate-400">Belum ada transaksi</p>
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
    const gridColor = isDark ? 'rgba(148, 163, 184, 0.1)' : 'rgba(148, 163, 184, 0.2)';
    const textColor = isDark ? '#94a3b8' : '#64748b';

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: @json($monthLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($monthData),
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const { ctx, chartArea } = chart;
                    if (!chartArea) return 'rgba(37, 99, 235, 0.7)';
                    const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.9)');
                    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.3)');
                    return gradient;
                },
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#fff',
                    titleColor: isDark ? '#f1f5f9' : '#0f172a',
                    bodyColor: textColor,
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: { label: ctx => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID') }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: textColor, callback: v => v >= 1000000 ? 'Rp ' + (v/1000000).toFixed(1) + 'jt' : 'Rp ' + (v/1000) + 'K' }
                },
                x: { grid: { display: false }, ticks: { color: textColor } }
            }
        }
    });
});
</script>
@endpush
@endsection
