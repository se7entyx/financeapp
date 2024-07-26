<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BuktiKasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TandaTerimaController;
use App\Models\TandaTerima;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'authenticate']);
});

Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth');

Route::post('/profile', [AuthenticationController::class, 'updatePassword'])->middleware('auth');

// Redirect root to login
Route::get('/', function () {
    if (Auth::check()) {
        // User is authenticated
        return redirect('/dashboard');
    } else {
        // User is not authenticated
        return redirect('/login');
    }
});
// Tanda Terima Routes
Route::get('/dashboard/new/tanda-terima', [SupplierController::class, 'showForm'])->name('new.tanda-terima');
Route::post('/dashboard/new/tanda-terima2', [TandaTerimaController::class, 'store'])->name('newtanda');
Route::get('/dashboard/new/bukti-pengeluaran', [BuktiKasController::class, 'index'])->name('buktikas.index');
Route::post('/dashboard/new/bukti-pengeluaran', [BuktiKasController::class, 'store'])->name('buktikas.store');
Route::post('/post-bukti-info', [BuktiKasController::class, 'saveKeterangan'])->name('buktikas.saveKeterangan');
Route::get('/get-supplier-info', [BuktiKasController::class, 'getSupplierInfo']);

Route::get('/dashboard/all', function () {
    return redirect('/dashboard/all/tanda-terima');
});
// Dashboard routes
Route::middleware('auth')->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/all/tanda-terima', [TandaTerimaController::class, 'showAll'])->name('all.tanda-terima');
    Route::view('dashboard/my', 'mydoc', ['title' => 'My Docs']);
    Route::view('profile', 'profile', ['title' => 'Profile']);
    // Route::view('dashboard/new/tanda-terima', 'newtanda', ['title' => 'New Tanda Terima']);
    // Route::view('dashboard/new/bukti-pengeluaran', 'newbukti', ['title' => 'New Bukti Pengeluaran Kas / Bank']);
});

// Invoice Routes (uncomment if needed)
// Route::post('/dashboard/new/add-invoices', [InvoiceController::class, 'store'])->name('invoices.store');
