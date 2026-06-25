<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Transaction::with(['customer', 'service', 'user']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn ($c) => $c->where('nama', 'like', "%{$search}%"))
                    ->orWhereHas('service', fn ($s) => $s->where('nama_layanan', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        $customers = Customer::orderBy('nama')->get();
        $services = Service::orderBy('nama_layanan')->get();

        return view('transactions.create', compact('customers', 'services'));
    }

    public function store(Request $request): RedirectResponse
    {
        // dd($request->all()); // Hapus komentar ini untuk mendebug data yang dikirim dari form

        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'berat' => ['required', 'numeric', 'min:0.1'],
            'tanggal_estimasi' => ['required', 'date'],
            'status_pembayaran' => ['required', 'in:Belum Lunas,Lunas'],
        ], [
            'berat.min' => 'Berat cucian minimal 0.1 Kg.',
        ]);

        try {
            $service = Service::findOrFail($validated['service_id']);
            $totalHarga = (int) round($validated['berat'] * $service->harga_per_kg);

            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'user_id' => auth()->id(),
                'customer_id' => $validated['customer_id'],
                'service_id' => $validated['service_id'],
                'berat' => $validated['berat'],
                'total_harga' => $totalHarga,
                'status' => 'Diproses',
                'tanggal_masuk' => now(),
                'tanggal_estimasi' => $validated['tanggal_estimasi'],
                'status_pembayaran' => $validated['status_pembayaran'],
            ]);

            Log::info('Transaction Created successfully', [
                'id' => $transaction->id,
                'invoice_number' => $transaction->invoice_number,
                'customer_id' => $transaction->customer_id,
                'total_harga' => $transaction->total_harga,
            ]);

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil disimpan. Nota Penerimaan sedang dibuka...')
                ->with('print_auto', route('transactions.print-masuk', $transaction));
        } catch (\Exception $e) {
            Log::error('Transaction Creation Failed: ' . $e->getMessage(), [
                'input' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Gagal menyimpan data transaksi ke database: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['customer', 'service', 'user']);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction): View
    {
        $customers = Customer::orderBy('nama')->get();
        $services = Service::orderBy('nama_layanan')->get();

        return view('transactions.edit', compact('transaction', 'customers', 'services'));
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'berat' => ['required', 'numeric', 'min:0.1'],
            'status' => ['required', 'in:Diproses,Siap Diambil,Selesai'],
            'tanggal_masuk' => ['required', 'date'],
            'tanggal_estimasi' => ['required', 'date'],
            'tanggal_diambil' => ['nullable', 'date'],
            'status_pembayaran' => ['required', 'in:Belum Lunas,Lunas'],
        ], [
            'berat.min' => 'Berat cucian minimal 0.1 Kg.',
        ]);

        try {
            $service = Service::findOrFail($validated['service_id']);
            $totalHarga = (int) round($validated['berat'] * $service->harga_per_kg);

            $tanggalDiambil = $validated['tanggal_diambil'];
            if ($validated['status'] === 'Selesai' && !$tanggalDiambil) {
                $tanggalDiambil = now();
            }

            $transaction->update([
                'customer_id' => $validated['customer_id'],
                'service_id' => $validated['service_id'],
                'berat' => $validated['berat'],
                'total_harga' => $totalHarga,
                'status' => $validated['status'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'tanggal_estimasi' => $validated['tanggal_estimasi'],
                'tanggal_diambil' => $tanggalDiambil,
                'status_pembayaran' => $validated['status_pembayaran'],
            ]);

            Log::info('Transaction Updated successfully', [
                'id' => $transaction->id,
                'invoice_number' => $transaction->invoice_number,
                'status' => $transaction->status,
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Transaction Update Failed: ' . $e->getMessage(), [
                'id' => $transaction->id,
                'input' => $request->all(),
            ]);

            return back()->withInput()->with('error', 'Gagal memperbarui data transaksi: ' . $e->getMessage());
        }
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        abort_if(! auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Admin yang dapat menghapus transaksi.');

        try {
            $transaction->delete();

            Log::info('Transaction Deleted successfully', [
                'id' => $transaction->id,
                'invoice_number' => $transaction->invoice_number,
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Transaction Delete Failed: ' . $e->getMessage(), [
                'id' => $transaction->id,
            ]);

            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function printMasuk(Transaction $transaction)
    {
        $transaction->load(['customer', 'service', 'user']);

        $pdf = Pdf::loadView('transactions.nota_masuk', compact('transaction'))
            ->setPaper([0, 0, 226.77, 841.89]);

        return $pdf->stream('nota-masuk-'.$transaction->invoice_number.'.pdf');
    }

    public function printPengambilan(Transaction $transaction)
    {
        $transaction->load(['customer', 'service', 'user']);

        abort_if($transaction->status !== 'Selesai', 400, 'Nota pengambilan hanya dapat dicetak jika status transaksi sudah Selesai.');

        $pdf = Pdf::loadView('transactions.nota_pengambilan', compact('transaction'))
            ->setPaper([0, 0, 226.77, 841.89]);

        return $pdf->stream('nota-pengambilan-'.$transaction->invoice_number.'.pdf');
    }

    public function markSiapDiambil(Transaction $transaction): RedirectResponse
    {
        try {
            $transaction->update(['status' => 'Siap Diambil']);

            Log::info('Transaction marked as Siap Diambil', ['id' => $transaction->id]);

            return back()->with('success', 'Status transaksi berhasil diubah menjadi Siap Diambil.');
        } catch (\Exception $e) {
            Log::error('Failed marking transaction as Siap Diambil: ' . $e->getMessage(), ['id' => $transaction->id]);
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function markSelesai(Transaction $transaction): RedirectResponse
    {
        try {
            $transaction->update([
                'status' => 'Selesai',
                'tanggal_diambil' => now(),
            ]);

            Log::info('Transaction marked as Selesai', ['id' => $transaction->id]);

            return back()->with('success', 'Transaksi ditandai selesai (Telah Diambil). Nota pengambilan sedang dibuka...')
                ->with('print_auto', route('transactions.print-pengambilan', $transaction));
        } catch (\Exception $e) {
            Log::error('Failed marking transaction as Selesai: ' . $e->getMessage(), ['id' => $transaction->id]);
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function notaMasuk(Request $request): View
    {
        $query = Transaction::with(['customer', 'service', 'user'])
            ->whereIn('status', ['Diproses', 'Siap Diambil']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn ($c) => $c->where('nama', 'like', "%{$search}%"));
            });
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        return view('transactions.nota_masuk_list', compact('transactions'));
    }

    public function notaPengambilan(Request $request): View
    {
        $query = Transaction::with(['customer', 'service', 'user'])
            ->where('status', 'Selesai');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn ($c) => $c->where('nama', 'like', "%{$search}%"));
            });
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        return view('transactions.nota_pengambilan_list', compact('transactions'));
    }
}
