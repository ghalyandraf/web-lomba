<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\DiamondController;
use App\Http\Controllers\MajorController;

// Halaman awal: selalu logout dulu, lalu tampilkan halaman login
Route::get('/', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
});

// Autentikasi Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang Memerlukan Login (Akses Dashboard, Rapor, & Diamond)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Input Rapor
    Route::get('/report-cards', [ReportCardController::class, 'index'])->name('report-cards.index');
    Route::post('/report-cards', [ReportCardController::class, 'store'])->name('report-cards.store');

    // Analisis Diamond SNBT
    Route::get('/diamond', [DiamondController::class, 'index'])->name('diamond.index');
    Route::post('/diamond/analyze', [DiamondController::class, 'analyze'])->name('diamond.analyze');

    // Eksplorasi Jurusan
    Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
});