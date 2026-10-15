
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\DiamondController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ProfileController;

// Halaman awal: logout, lalu tampilkan halaman welcome
Route::get('/', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('welcome');
});

// Halaman welcome
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Semua fitur berikut wajib login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Input nilai rapor
    Route::get('/report-cards', [ReportCardController::class, 'index'])
        ->name('report-cards.index');

    Route::post('/report-cards', [ReportCardController::class, 'store'])
        ->name('report-cards.store');

    // Analisis Diamond SNBT
    Route::get('/diamond', [DiamondController::class, 'index'])
        ->name('diamond.index');

    Route::post('/diamond/analyze', [DiamondController::class, 'analyze'])
        ->name('diamond.analyze');

    // Eksplorasi jurusan
    Route::get('/majors', [MajorController::class, 'index'])
        ->name('majors.index');

    // Hasil rekomendasi jurusan
    // Diletakkan sebelum route detail berbasis slug
    Route::get('/majors/recommendations', [MajorController::class, 'recommendations'])
        ->name('majors.recommendations');

    // Detail jurusan berdasarkan slug
    Route::get('/majors/{slug}', [MajorController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')
        ->name('majors.show');

    // Simpan jurusan pilihan siswa
    Route::post('/majors/{major}/select', [MajorController::class, 'select'])
        ->whereNumber('major')
        ->name('majors.select');

    // Rencana karier
    Route::get('/career-plans', [CareerController::class, 'index'])
        ->name('career.index');

    Route::post('/career-plans', [CareerController::class, 'store'])
        ->name('career.store');

    // Profil
    Route::get('/profil', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');
});
