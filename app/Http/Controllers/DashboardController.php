<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_pelanggan'      => Customer::count(),
            'total_transaksi'      => Transaction::count(),
            'laundry_diproses'     => Transaction::where('status', 'Diproses')->count(),
            'laundry_siap_diambil' => Transaction::where('status', 'Siap Diambil')->count(),
            'laundry_selesai'      => Transaction::where('status', 'Selesai')->count(),
            'pendapatan_hari_ini'  => Transaction::whereDate('created_at', today())->sum('total_harga'),
            
            // Tambahan untuk detail UI
            'pelanggan_hari_ini'   => Customer::whereDate('created_at', today())->count(),
            'transaksi_hari_ini'   => Transaction::whereDate('created_at', today())->count(),
            'pendapatan_bulan_ini' => Transaction::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_harga'),
            'laundry_aktif'        => Transaction::whereIn('status', ['Diproses', 'Siap Diambil'])->count(),
        ];

        // Data grafik pendapatan bulanan
        $monthLabels = [];
        $monthData   = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthLabels[] = \Carbon\Carbon::create(null, $i, 1)->translatedFormat('M');
            $monthData[]   = (int) Transaction::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $i)
                ->sum('total_harga');
        }

        $statusChart = [
            'labels' => ['Diproses', 'Siap Diambil', 'Selesai'],
            'data'   => [$stats['laundry_diproses'], $stats['laundry_siap_diambil'], $stats['laundry_selesai']],
        ];

        $recentTransactions = Transaction::with(['customer', 'service', 'user'])
            ->latest()
            ->take(8)
            ->get();

        // Transaksi aktif terbaru (Diproses & Siap Diambil)
        $activeTransactions = Transaction::with(['customer', 'service'])
            ->whereIn('status', ['Diproses', 'Siap Diambil'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentTransactions',
            'activeTransactions',
            'monthLabels',
            'monthData',
            'statusChart'
        ));
    }
}
