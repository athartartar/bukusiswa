<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard; // Import Class Dashboard Baru
use Illuminate\Support\Facades\Auth;
use App\Livewire\Profile;
use App\Livewire\Siswa;
use App\Http\Controllers\SiswaController;
use App\Livewire\User;
use App\Http\Controllers\UserController;
use App\Livewire\Guru;
use App\Http\Controllers\GuruController;
use App\Livewire\Pelanggaran;
use App\Http\Controllers\PelanggaranController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    // Arahkan ke Class Dashboard, bukan view biasa
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/siswa', Siswa::class)->name('siswa');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/guru', Guru::class)->name('guru');
    Route::post('/guru/store', [GuruController::class, 'store'])->name('guru.store');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/user', User::class)->name('user');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/pelanggaran', Pelanggaran::class)->name('pelanggaran');
    Route::post('/pelanggaran/store', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
    Route::delete('/pelanggaran/{id_pelanggaran}', [PelanggaranController::class, 'destroy']);
    Route::get('/pelanggaran/riwayat/{id_siswa}', [PelanggaranController::class, 'riwayat'])->name('pelanggaran.riwayat');

    // Route Logout (Wajib ada biar tombol di sidebar jalan)
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
