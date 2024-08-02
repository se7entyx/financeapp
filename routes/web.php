<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BuktiKasController;
use App\Http\Controllers\CombinedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TandaTerimaController;
use App\Models\BuktiKas;
use App\Models\TandaTerima;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'authenticate']);
});

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
// Dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/new/tanda-terima', [SupplierController::class, 'showForm'])->name('new.tanda-terima');
    Route::post('/dashboard/new/tanda-terima2', [TandaTerimaController::class, 'store'])->name('newtanda');
    Route::get('/tanda-terima/{id}/invoices', [TandaTerimaController::class, 'getInvoices']);
    Route::get('/dashboard/new/bukti-pengeluaran', [BuktiKasController::class, 'index'])->name('buktikas.index');
    Route::post('/dashboard/new/bukti-pengeluaran', [BuktiKasController::class, 'store'])->name('buktikas.store');
    Route::get('/bukti-kas/{id}/details', [BuktiKasController::class, 'getDetails']);
    Route::get('/dashboard/edit/tanda-terima/{id}', [TandaTerimaController::class, 'showEditForm'])->name('tanda-terima.edit');
    Route::put('/dashboard/edit/tanda-terima/{id}', [TandaTerimaController::class, 'update'])->name('tanda-terima.update');
    Route::get('/dashboard/edit/bukti-kas/{id}', [BuktiKasController::class, 'showEditForm'])->name('bukti-kas.edit');
    Route::post('/post-bukti-info', [BuktiKasController::class, 'saveKeterangan'])->name('buktikas.saveKeterangan');
    Route::get('/get-supplier-info', [BuktiKasController::class, 'getSupplierInfo']);
    Route::get('/dashboard/print/tanda-terima/{id}', [ExportController::class, 'export']);
    Route::get('/dashboard/all', function () {
        return redirect('/dashboard/all/tanda-terima');
    });
    // Route::get(
    //     '/dashboard/all/tanda-terima/{tandaTerima:id}',
    //     function (TandaTerima $tandaTerima) {
    //         return view('alldocs',[CombinedController::class,'getDetailTandaTerima']);   
    //     }
    // )->middleware('auth');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth');
    Route::post('/profile', [AuthenticationController::class, 'updatePassword'])->middleware('auth');
    Route::get('/dashboard/all/tanda-terima', [CombinedController::class, 'getTandaTerima'])->name('all.tanda-terima');
    Route::delete('/tanda-terima/{id}/delete', [TandaTerimaController::class, 'deleteTt'])->name('delete.tanda-terima');
    Route::delete('/bukti-kas/{id}/delete', [BuktiKasController::class, 'deleteBk'])->name('delete.bukti-kas');
    Route::get('/dashboard/all/bukti-kas', [CombinedController::class, 'getBuktiKas'])->name('all.bukti-kas');
    Route::get('/dashboard/my/tanda-terima', [CombinedController::class, 'getMyTandaTerima'])->name('my.tanda-terima');
    Route::get('/dashboard/my/bukti-kas', [CombinedController::class, 'getMyBuktiKas'])->name('my.bukti-kas');
    // Route::view('dashboard/my', 'mydoc', ['title' => 'My Docs']);
    Route::view('profile', 'profile', ['title' => 'Profile']);
    // Route::view('dashboard/new/tanda-terima', 'newtanda', ['title' => 'New Tanda Terima']);
    // Route::view('dashboard/new/bukti-pengeluaran', 'newbukti', ['title' => 'New Bukti Pengeluaran Kas / Bank']);
});

// Invoice Routes (uncomment if needed)
// Route::post('/dashboard/new/add-invoices', [InvoiceController::class, 'store'])->name('invoices.store');
