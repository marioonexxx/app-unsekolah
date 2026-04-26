<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ManajemenKelasController;
use App\Http\Controllers\ManajemenMonitoringSklController;
use App\Http\Controllers\ManajemenProfilAdminController;
use App\Http\Controllers\ManajemenProfilWalikelasController;
use App\Http\Controllers\ManajemenSiswabyWalkesController;
use App\Http\Controllers\ManajemenSiswaController;
use App\Http\Controllers\ManajemenSklAdminController;
use App\Http\Controllers\ManajemenSklController;
use App\Http\Controllers\ManajemenSklSiswaController;
use App\Http\Controllers\ManajemenWalikelasController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserSiswaController;
use App\Http\Controllers\UserWaliKelasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada agar Auth::user() terbaca

// 1. Publik
Route::get('/', [HomepageController::class, 'index'])->name('homepage');

// 2. Logic Redirect /dashboard (HAPUS yang versi return view('dashboard') di bawah)
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    return match ($role) {
        '1' => redirect()->route('admin.dashboard'),
        '2' => redirect()->route('wali.dashboard'),
        '3' => redirect()->route('siswa.dashboard'),
        default => redirect('/'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');



// 3. Khusus Admin UN (Role 1)
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/dashboard', [UserAdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('periode', PeriodeController::class);
    Route::resource('manajemen-siswa', ManajemenSiswaController::class);
    Route::resource('manajemen-walkes', ManajemenWalikelasController::class);
    Route::resource('manajemen-kelas', ManajemenKelasController::class);
    // Menampilkan halaman profil
    Route::get('/manajemen-profil', [ManajemenProfilAdminController::class, 'index'])->name('manajemen-profil.index');

    // Memproses update (Gunakan PUT agar sesuai dengan @method('PUT') di Blade Anda)
    Route::put('/manajemen-profil', [ManajemenProfilAdminController::class, 'update'])->name('manajemen-profil.update');
    Route::resource('admin-manajemen-skl', ManajemenSklAdminController::class);
    Route::get('/monitoring-skl', [ManajemenMonitoringSklController::class, 'index'])->name('monitoring-skl.index');
});

// 4. Wali Kelas (Role  2)
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/walkes/dashboard', [UserWaliKelasController::class, 'index'])->name('wali.dashboard');
    Route::resource('manajemen-skl', ManajemenSklController::class);
    Route::get('/walikelas/profil', [ManajemenProfilWalikelasController::class, 'index'])->name('walikelas.profile.index');
    Route::put('/walikelas/profil', [ManajemenProfilWalikelasController::class, 'update'])->name('walikelas.profile.update');
    Route::resource('walikes-manajemen-siswa', ManajemenSiswabyWalkesController::class);
});

// 5. Khusus Siswa (Role 3)
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/siswa/dashboard', [UserSiswaController::class, 'index'])->name('siswa.dashboard');
    Route::resource('hasil-ujian', ManajemenSklSiswaController::class);
});

// 6. Profile & Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
