<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard; // Import Class Dashboard Baru
use App\Livewire\Siswa; 
use Illuminate\Support\Facades\Auth;

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

    // Route Logout (Wajib ada biar tombol di sidebar jalan)
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
