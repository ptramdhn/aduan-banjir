<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LurahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WargaController;
use App\Models\Review;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // Ambil 3 review terbaru yang memiliki rating tinggi (4 atau 5)
    // Eager load 'user' agar kita bisa tampilkan nama warga
    $reviews = Review::with('user')
        ->where('rating', '>=', 4)
        ->latest()
        ->take(3)
        ->get();

    return view('welcome', compact('reviews'));
});

// --- TRAFFIC COP (PENENTU ARAH) ---
// Saat user login, Breeze akan melempar ke '/dashboard'.
// Di sini kita cek role-nya, lalu lempar ke dashboard spesifik mereka.
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'lurah') {
        return redirect()->route('lurah.dashboard');
    }

    if ($role === 'warga') {
        return redirect()->route('warga.dashboard');
    }

    // Fallback jika role tidak dikenali
    return abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP PROFIL (BAWAAN BREEZE) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- DASHBOARD WARGA ---
Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/warga/dashboard', [WargaController::class, 'index'])->name('warga.dashboard');

    Route::get('/lapor/buat', [WargaController::class, 'create'])->name('lapor.create');
    Route::post('/lapor/store', [WargaController::class, 'store'])->name('lapor.store');

    Route::post('/laporan/{id}/review', [ReviewController::class, 'store'])->name('review.store');
});


// --- DASHBOARD ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Route Detail Laporan
    Route::get('/laporan/{id}', [AdminController::class, 'show'])->name('admin.laporan.show');

    // Route Update Status (POST/PATCH)
    Route::patch('/laporan/{id}/update', [AdminController::class, 'updateStatus'])->name('admin.laporan.update');
});


// --- DASHBOARD LURAH ---
Route::middleware(['auth', 'role:lurah'])->prefix('lurah')->group(function () {

    Route::get('/dashboard', [LurahController::class, 'dashboard'])->name('lurah.dashboard');

    Route::get('/rekap', [LurahController::class, 'rekap'])->name('lurah.rekap');

    Route::get('/staff', [LurahController::class, 'staff'])->name('lurah.staff.index');
    Route::post('/staff', [LurahController::class, 'storeStaff'])->name('lurah.staff.store');
    Route::delete('/staff/{id}', [LurahController::class, 'destroyStaff'])->name('lurah.staff.destroy');
});

require __DIR__ . '/auth.php';
