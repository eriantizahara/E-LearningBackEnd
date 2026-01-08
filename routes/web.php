<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginControllerWeb;
use App\Http\Controllers\LayoutsControllerWeb;
use App\Http\Controllers\UsersControllerWeb;
use App\Http\Controllers\DosenControllerWeb;
use App\Http\Controllers\MahasiswaControllerWeb;
use App\Http\Controllers\MatakuliahControllerWeb;
use App\Http\Controllers\KelasControllerWeb;
use App\Http\Controllers\KrsControllerWeb;
use App\Http\Controllers\TugasControllerWeb;
use App\Http\Controllers\ModulControllerWeb;
use App\Http\Controllers\PengumpulanTugasControllerWeb;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginControllerWeb::class, 'showLogin'])->name('login');
Route::post('/login', [LoginControllerWeb::class, 'login'])->name('login.process');
Route::get('/logout', [LoginControllerWeb::class, 'logout'])->name('logout');

// Route::get('/login', [LoginControllerWeb::class, 'showFormLogin'])->name('login');
// Route::post('/login', [LoginControllerWeb::class, 'ceklogin'])->name('login.cek');
// Route::get('/logout', [LoginControllerWeb::class, 'logout'])->name('logout');

Route::get('/register', [LoginControllerWeb::class, 'register'])->name('register');

Route::resource('/dashboard', LayoutsControllerWeb::class);
Route::resource('/users', UsersControllerWeb::class);
Route::resource('/dosens', DosenControllerWeb::class);
Route::resource('/mahasiswas', MahasiswaControllerWeb::class);
Route::resource('/matakuliahs', MatakuliahControllerWeb::class);
Route::resource('/kelas', KelasControllerWeb::class);


Route::resource('krs', KrsControllerWeb::class);
Route::post('krs/{kode_krs}/approve', [KrsControllerWeb::class, 'approve'])
    ->name('krs.approve');


// =====================
// TUGAS (DOSEN)
// =====================
Route::middleware(['auth'])->group(function () {

    Route::get('/tugas', [TugasControllerWeb::class, 'index'])
        ->name('tugas.index');

    Route::post('/tugas', [TugasControllerWeb::class, 'store'])
        ->name('tugas.store');

    Route::put('/tugas/{kode_tugas}', [TugasControllerWeb::class, 'update'])
        ->name('tugas.update');

    Route::delete('/tugas/{kode_tugas}', [TugasControllerWeb::class, 'destroy'])
        ->name('tugas.destroy');
});



// =====================
// Modul Routes (CRUD)
// =====================
Route::middleware(['auth'])->group(function () {

    // Halaman index modul
    Route::get('/moduls', [ModulControllerWeb::class, 'index'])->name('moduls.index');

    // Simpan modul baru
    Route::post('/moduls', [ModulControllerWeb::class, 'store'])->name('moduls.store');

    // Update modul
    Route::put('/moduls/{modul}', [ModulControllerWeb::class, 'update'])->name('moduls.update');

    // Hapus modul
    Route::delete('/moduls/{modul}', [ModulControllerWeb::class, 'destroy'])->name('moduls.destroy');
});


// =====================
// Pengumpulan Tugas
// =====================
Route::prefix('pengumpulan-tugas')->middleware(['auth'])->group(function () {

    // Tampilkan daftar pengumpulan tugas (filter kelas & mahasiswa)
    Route::get('/', [PengumpulanTugasControllerWeb::class, 'index'])->name('pengumpulan_tugas.index');

    // Update nilai pengumpulan tugas
    Route::put('/{id}', [PengumpulanTugasControllerWeb::class, 'update'])->name('pengumpulan_tugas.update');

});
