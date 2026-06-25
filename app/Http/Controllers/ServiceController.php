<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::latest()->paginate(10);

        return view('services.index', compact('services'));
    }

    public function create(): View
    {
        abort_if(! auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Admin yang dapat menambah layanan.');

        return view('services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(! auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Admin yang dapat menambah layanan.');

        // dd($request->all()); // Hapus komentar ini untuk mendebug data yang dikirim dari form

        $validated = $request->validate([
            'nama_layanan' => ['required', 'string', 'max:255'],
            'harga_per_kg' => ['required', 'integer', 'min:1000'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'harga_per_kg.min' => 'Harga layanan minimal Rp 1.000.',
        ]);

        try {
            $service = Service::create([
                'nama_layanan' => $validated['nama_layanan'],
                'harga_per_kg' => $validated['harga_per_kg'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            Log::info('Service Created successfully', [
                'id' => $service->id,
                'nama_layanan' => $service->nama_layanan,
                'harga_per_kg' => $service->harga_per_kg,
            ]);

            return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Service Creation Failed: ' . $e->getMessage(), [
                'input' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Gagal menyimpan data layanan ke database: ' . $e->getMessage());
        }
    }

    public function edit(Service $service): View
    {
        abort_if(! auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Admin yang dapat mengedit layanan.');

        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        abort_if(! auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Admin yang dapat mengedit layanan.');

        $validated = $request->validate([
            'nama_layanan' => ['required', 'string', 'max:255'],
            'harga_per_kg' => ['required', 'integer', 'min:1000'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'harga_per_kg.min' => 'Harga layanan minimal Rp 1.000.',
        ]);

        try {
            $service->update([
                'nama_layanan' => $validated['nama_layanan'],
                'harga_per_kg' => $validated['harga_per_kg'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            Log::info('Service Updated successfully', [
                'id' => $service->id,
                'nama_layanan' => $service->nama_layanan,
            ]);

            return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Service Update Failed: ' . $e->getMessage(), [
                'id' => $service->id,
                'input' => $request->all(),
            ]);

            return back()->withInput()->with('error', 'Gagal memperbarui data layanan: ' . $e->getMessage());
        }
    }

    public function destroy(Service $service): RedirectResponse
    {
        abort_if(! auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya Admin yang dapat menghapus layanan.');

        try {
            $service->delete();

            Log::info('Service Deleted successfully', [
                'id' => $service->id,
                'nama_layanan' => $service->nama_layanan,
            ]);

            return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Service Delete Failed: ' . $e->getMessage(), [
                'id' => $service->id,
            ]);

            return back()->with('error', 'Gagal menghapus layanan: ' . $e->getMessage());
        }
    }
}
