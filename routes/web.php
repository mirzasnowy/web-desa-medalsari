<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUmkmController;
use App\Http\Controllers\AdminWisataDesaController;
use App\Models\Umkm;
use App\Models\WisataDesa;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rute Front-End ---
Route::get('/', function () {
    $wisataDesas = WisataDesa::all();
    $umkms = Umkm::all();
    return view('welcome', compact('wisataDesas', 'umkms'));
});

// New routes for detail pages (using the Admin controllers' showPublic method)
Route::get('/wisata-desa/{wisataDesa}', [AdminWisataDesaController::class, 'showPublic'])->name('wisata_desas.show_public');
Route::get('/umkm/{umkm}', [AdminUmkmController::class, 'showPublic'])->name('umkms.show_public');


// --- Rute Admin ---
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::resource('umkms', AdminUmkmController::class)->names('admin.umkms');

        // Resource Routes for Wisata Desa
        Route::resource('wisata-desas', AdminWisataDesaController::class)->names('admin.wisata_desas');
    });
});