<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // dd($request->all()); // Hapus komentar ini untuk mendebug data yang dikirim dari form

        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:3', 'max:255'],
            'telepon' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nama.min' => 'Nama pelanggan minimal 3 karakter.',
            'telepon.regex' => 'Telepon hanya boleh berisi angka.',
        ]);

        try {
            $customer = Customer::create([
                'nama' => $validated['nama'],
                'telepon' => $validated['telepon'],
                'alamat' => $validated['alamat'] ?? null,
            ]);

            Log::info('Customer Created successfully', [
                'id' => $customer->id,
                'nama' => $customer->nama,
                'telepon' => $customer->telepon,
            ]);

            return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Customer Creation Failed: ' . $e->getMessage(), [
                'input' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Gagal menyimpan data pelanggan ke database: ' . $e->getMessage());
        }
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:3', 'max:255'],
            'telepon' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nama.min' => 'Nama pelanggan minimal 3 karakter.',
            'telepon.regex' => 'Telepon hanya boleh berisi angka.',
        ]);

        try {
            $customer->update([
                'nama' => $validated['nama'],
                'telepon' => $validated['telepon'],
                'alamat' => $validated['alamat'] ?? null,
            ]);

            Log::info('Customer Updated successfully', [
                'id' => $customer->id,
                'nama' => $customer->nama,
            ]);

            return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Customer Update Failed: ' . $e->getMessage(), [
                'id' => $customer->id,
                'input' => $request->all(),
            ]);

            return back()->withInput()->with('error', 'Gagal memperbarui data pelanggan: ' . $e->getMessage());
        }
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        abort_if(! auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Admin yang dapat menghapus pelanggan.');

        try {
            $customer->delete();

            Log::info('Customer Deleted successfully', [
                'id' => $customer->id,
                'nama' => $customer->nama,
            ]);

            return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Customer Delete Failed: ' . $e->getMessage(), [
                'id' => $customer->id,
            ]);

            return back()->with('error', 'Gagal menghapus pelanggan: ' . $e->getMessage());
        }
    }
}
