<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->get('type', 'daily');
        $date = $request->get('date', now()->format('Y-m-d'));
        $month = $request->get('month', now()->format('Y-m'));

        if ($type === 'monthly') {
            [$year, $monthNum] = explode('-', $month);
            $transactions = Transaction::with(['customer', 'service'])
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNum)
                ->latest()
                ->get();

            $totalPendapatan = $transactions->sum('total_harga');
            $totalTransaksi = $transactions->count();
            $periodLabel = \Carbon\Carbon::createFromDate($year, $monthNum, 1)->translatedFormat('F Y');
        } else {
            $transactions = Transaction::with(['customer', 'service'])
                ->whereDate('created_at', $date)
                ->latest()
                ->get();

            $totalPendapatan = $transactions->sum('total_harga');
            $totalTransaksi = $transactions->count();
            $periodLabel = \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
        }

        return view('reports.index', compact(
            'type', 'date', 'month', 'transactions',
            'totalPendapatan', 'totalTransaksi', 'periodLabel'
        ));
    }
}
