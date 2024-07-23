<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthenticationController::class, 'authenticate']);
Route::post('/logout', [AuthenticationController::class, 'logout']);

Route::get('/', function () {
    if (Auth::check()) {
        // User is authenticated
        return redirect('/dashboard');
    } else {
        // User is not authenticated
        return redirect('/login');
    }
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Dashboard routes
Route::middleware('auth')->group(function() {
    // Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::view('dashboard/new', 'new', ['title' => 'New Docs']);
    Route::view('dashboard/all', 'alldoc', ['title' => 'All Docs']);
    Route::view('dashboard/my', 'mydoc', ['title' => 'My Docs']);
    Route::view('profile', 'profile', ['title' => 'Profile']);
    Route::view('dashboard/new/tanda-terima', 'newtanda', ['title' => 'New Tanda Terima']);
    Route::view('dashboard/new/bukti-pengeluaran', 'newbukti', ['title' => 'New Bukti Pengeluaran Kas / Bank']);
});
