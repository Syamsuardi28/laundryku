<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->get('q');
        $customers = collect();
        $services = collect();
        $transactions = collect();

        if ($query) {
            $customers = Customer::where('nama', 'like', "%{$query}%")
                ->orWhere('telepon', 'like', "%{$query}%")
                ->orWhere('alamat', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $services = Service::where('nama_layanan', 'like', "%{$query}%")
                ->orWhere('deskripsi', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            $transactions = Transaction::with(['customer', 'service'])
                ->where('invoice_number', 'like', "%{$query}%")
                ->orWhereHas('customer', fn ($c) => $c->where('nama', 'like', "%{$query}%"))
                ->limit(10)
                ->get();
        }

        return view('search.index', compact('query', 'customers', 'services', 'transactions'));
    }
}
