<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\CustomerApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Nota and action routes (MUST be defined before resource route)
    Route::get('transactions/nota-masuk', [TransactionController::class, 'notaMasuk'])
        ->name('transactions.nota-masuk');
    Route::get('transactions/nota-pengambilan', [TransactionController::class, 'notaPengambilan'])
        ->name('transactions.nota-pengambilan');
    Route::get('transactions/{transaction}/print-masuk', [TransactionController::class, 'printMasuk'])
        ->name('transactions.print-masuk');
    Route::get('transactions/{transaction}/print-pengambilan', [TransactionController::class, 'printPengambilan'])
        ->name('transactions.print-pengambilan');
    Route::patch('transactions/{transaction}/mark-siap-diambil', [TransactionController::class, 'markSiapDiambil'])
        ->name('transactions.mark-siap-diambil');
    Route::patch('transactions/{transaction}/mark-selesai', [TransactionController::class, 'markSelesai'])
        ->name('transactions.mark-selesai');

    // Transaksi: Admin & Petugas (semua kecuali delete)
    Route::resource('transactions', TransactionController::class)->except(['destroy']);
    // Hapus transaksi: Admin only (double-guarded di controller juga)
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy')
        ->middleware('admin');

    // -------------------------------------------------------
    // API Internal — Customer Search & Quick Create (AJAX)
    // Digunakan oleh form transaksi (Smart Customer Selection)
    // -------------------------------------------------------
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('customers/search', [CustomerApiController::class, 'search'])->name('customers.search');
        Route::post('customers', [CustomerApiController::class, 'store'])->name('customers.store');
    });

    // -------------------------------------------------------
    // Pelanggan: Admin & Petugas bisa lihat / tambah / edit
    // Hanya Admin yang bisa hapus (guard di controller juga)
    // -------------------------------------------------------
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->name('customers.destroy')
        ->middleware('admin');

    // -------------------------------------------------------
    // Layanan: Admin & Petugas bisa lihat
    // Hanya Admin yang bisa tambah / edit / hapus
    // -------------------------------------------------------
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::middleware('admin')->group(function () {
        Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });

    // -------------------------------------------------------
    // Admin-only: Users & Laporan
    // -------------------------------------------------------
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });

    // -------------------------------------------------------
    // Search: Admin & Petugas
    // -------------------------------------------------------
    Route::get('search', [SearchController::class, 'index'])->name('search.index');
});

require __DIR__.'/auth.php';
