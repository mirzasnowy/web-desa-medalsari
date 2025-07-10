<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUmkmController;
use App\Http\Controllers\AdminWisataDesaController;
use App\Http\Controllers\AdminViewDesaController;
use App\Http\Controllers\AdminKegiatanDesaController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminAparaturDesaController;
use App\Http\Controllers\AdminKearifanLokalController; // NEW
use App\Http\Controllers\ContactController;

use App\Models\Umkm;
use App\Models\WisataDesa;
use App\Models\ViewDesa;
use App\Models\KegiatanDesa;
use App\Models\Berita;
use App\Models\AparaturDesa;
use App\Models\KearifanLokal; // NEW
use App\Models\Penduduk;

use Carbon\Carbon; // Untuk formatting tanggal

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute ini
| dimuat oleh RouteServiceProvider dalam grup yang berisi middleware "web".
| Sekarang buat sesuatu yang hebat!
|
*/

// --- Rute Front-End ---
Route::get('/', function () {
    $wisataDesas = WisataDesa::all();
    $umkms = Umkm::all();
    $viewDesas = ViewDesa::all();

    // Ambil data untuk bagian-bagian baru
    $kegiatanDesas = KegiatanDesa::latest()->take(6)->get(); // Ambil 6 kegiatan terbaru
    $beritas = Berita::latest()->take(6)->get();             // Ambil 6 berita terbaru
    $aparaturDesas = AparaturDesa::all();                    // Ambil semua aparatur desa
    $kearifanLokals = KearifanLokal::latest()->take(6)->get(); // NEW: Ambil 6 kearifan lokal terbaru

    // Data untuk Statistik Penduduk
    // Pastikan Model Penduduk ada dan memiliki data yang relevan.
    // Jika belum ada Model Penduduk, Anda bisa menginisialisasi ini dengan nilai default.
    $totalPenduduk = Penduduk::count();
    $jumlahLakiLaki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
    $jumlahPerempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();
    $jumlahKK = Penduduk::distinct('no_kk')->count(); // Asumsi ada kolom no_kk

    // Contoh cara mendapatkan mayoritas pekerjaan/pendidikan (perlu disesuaikan dengan struktur data Anda)
    $mayoritasPekerjaan = Penduduk::groupBy('pekerjaan')->orderByRaw('COUNT(*) DESC')->select('pekerjaan')->first();
    $mayoritasPekerjaan = $mayoritasPekerjaan ? $mayoritasPekerjaan->pekerjaan : 'Tidak Tersedia';

    $mayoritasPendidikan = Penduduk::groupBy('pendidikan')->orderByRaw('COUNT(*) DESC')->select('pendidikan')->first();
    $mayoritasPendidikan = $mayoritasPendidikan ? $mayoritasPendidikan->pendidikan : 'Tidak Tersedia';


    return view('welcome', compact(
        'wisataDesas',
        'umkms',
        'viewDesas',
        'kegiatanDesas',
        'beritas',
        'aparaturDesas',
        'kearifanLokals',       // NEW
        'totalPenduduk',
        'jumlahLakiLaki',
        'jumlahPerempuan',
        'jumlahKK',
        'mayoritasPekerjaan',
        'mayoritasPendidikan'
    ));
})->name('home');

// Rute untuk halaman detail Wisata Desa (Publik)
Route::get('/wisata-desa/{wisataDesa}', [AdminWisataDesaController::class, 'showPublic'])->name('wisata_desas.show_public');

// Rute untuk halaman detail UMKM (Publik)
Route::get('/umkm/{umkm}', [AdminUmkmController::class, 'showPublic'])->name('umkms.show_public');

// Rute untuk halaman detail Potret Desa (Publik)
Route::get('/potret-desa/{viewDesa}', [AdminViewDesaController::class, 'showPublic'])->name('view_desas.show_public');

// Rute untuk halaman detail Kegiatan Desa (Publik)
Route::get('/kegiatan-desa/{kegiatanDesa}', [AdminKegiatanDesaController::class, 'showPublic'])->name('kegiatan_desas.show_public');
Route::get('/kegiatan-desa', [AdminKegiatanDesaController::class, 'indexPublic'])->name('kegiatan_desas.index_public'); // Halaman daftar semua kegiatan

// Rute untuk halaman detail Berita (Publik)
Route::get('/berita/{berita}', [AdminBeritaController::class, 'showPublic'])->name('berita.show_public');
Route::get('/berita', [AdminBeritaController::class, 'indexPublic'])->name('berita.index_public'); // Halaman daftar semua berita

// NEW: Rute untuk halaman detail Kearifan Lokal (Publik)
Route::get('/kearifan-lokal/{kearifanLokal}', [AdminKearifanLokalController::class, 'showPublic'])->name('kearifan_lokal.show_public');
Route::get('/kearifan-lokal', [AdminKearifanLokalController::class, 'indexPublic'])->name('kearifan_lokal.index_public'); // Halaman daftar semua kearifan lokal

// Rute untuk submit formulir kontak
Route::post('/kontak', [ContactController::class, 'submit'])->name('kontak.submit');

// Route untuk formulir kontak publik
Route::post('/kontak/submit', [ContactController::class, 'submit'])->name('kontak.submit');

// --- Rute Admin ---
Route::prefix('admin')->group(function () {
    // Rute autentikasi admin
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);

    // Rute yang membutuhkan autentikasi admin
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Resource Routes untuk UMKM
        Route::resource('umkms', AdminUmkmController::class)->names('admin.umkms');

        // Resource Routes untuk Wisata Desa
        Route::resource('wisata-desas', AdminWisataDesaController::class)->names('admin.wisata_desas');

        // Resource Routes untuk Potret Desa
        Route::resource('view-desas', AdminViewDesaController::class)->names('admin.view_desas');

        // Resource Routes untuk Kegiatan Desa
        Route::resource('kegiatan-desas', AdminKegiatanDesaController::class)->names('admin.kegiatan_desas');

        // Resource Routes untuk Berita
        Route::resource('beritas', AdminBeritaController::class)->names('admin.beritas');

        // Resource Routes untuk Aparatur Desa
        Route::resource('aparatur-desas', AdminAparaturDesaController::class)->names('admin.aparatur_desas');

        // NEW: Resource Routes untuk Kearifan Lokal
        Route::resource('kearifan-lokals', AdminKearifanLokalController::class)->names('admin.kearifan_lokals');
        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::patch('/contacts/{contact}/read', [ContactController::class, 'markAsRead'])->name('contacts.mark_as_read');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        // Resource Routes untuk Penduduk (jika Anda ingin CRUD data penduduk)
        // Route::resource('penduduks', AdminPendudukController::class)->names('admin.penduduks');
    });
});
