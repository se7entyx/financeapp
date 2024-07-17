<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthenticationController::class, function () {
    return view('login');
}])->name('login')->middleware('guest');
Route::post('/login', [AuthenticationController::class, 'authenticate']);
Route::post('/logout', [AuthenticationController::class, 'logout']);

Route::get('/', function(){
    return redirect()->route('login');
});

Route::get('dashboard/new', function () {
    return view('new', ['title' => 'New Docs']);
})->middleware('auth');

Route::get('dashboard/all', function () {
    return view('alldoc', ['title' => 'All Docs']);
})->middleware('auth');

Route::get('dashboard/my', function () {
    return view('mydoc', ['title' => 'My Docs']);
})->middleware('auth');

Route::get('/profile', function () {
    return view('profile', ['title' => 'Profile']);
})->middleware('auth');
