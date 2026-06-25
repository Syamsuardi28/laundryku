<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * CustomerApiController
 *
 * Menangani AJAX requests dari form transaksi:
 * - Live search pelanggan saat mengetik
 * - Quick create pelanggan via modal tanpa page reload
 */
class CustomerApiController extends Controller
{
    /**
     * Search pelanggan by nama atau telepon.
     * Digunakan oleh Smart Customer Search di form transaksi.
     *
     * GET /api/customers/search?q=budi
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->string('q')->trim();

        if ($query->isEmpty() || $query->length() < 2) {
            return response()->json([]);
        }

        $customers = Customer::query()
            ->where('nama', 'like', "%{$query}%")
            ->orWhere('telepon', 'like', "%{$query}%")
            ->orderBy('nama')
            ->limit(10)
            ->get(['id', 'nama', 'telepon', 'alamat']);

        return response()->json($customers);
    }

    /**
     * Quick create pelanggan baru via AJAX (dari modal form transaksi).
     * Mengembalikan data customer yang baru dibuat.
     *
     * POST /api/customers
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama'    => ['required', 'string', 'min:3', 'max:255'],
            'telepon' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:20'],
            'alamat'  => ['nullable', 'string', 'max:500'],
        ], [
            'nama.min'       => 'Nama pelanggan minimal 3 karakter.',
            'telepon.regex'  => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'success'  => true,
            'message'  => 'Pelanggan berhasil ditambahkan.',
            'customer' => [
                'id'      => $customer->id,
                'nama'    => $customer->nama,
                'telepon' => $customer->telepon,
                'alamat'  => $customer->alamat,
            ],
        ], 201);
    }
}
