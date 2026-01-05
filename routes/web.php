<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllerWeb;
use App\Http\Controllers\LayoutsControllerWeb;
use App\Http\Controllers\UsersControllerWeb;
use App\Http\Controllers\DosenControllerWeb;
use App\Http\Controllers\MahasiswaControllerWeb;
use App\Http\Controllers\MatakuliahControllerWeb;

use App\Models\Mahasiswa;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthControllerWeb::class, 'showFormLogin'])->name('login');
Route::post('/login', [AuthControllerWeb::class, 'ceklogin'])->name('login.cek');
Route::get('/logout', [AuthControllerWeb::class, 'logout'])->name('logout');

Route::get('/register', [AuthControllerWeb::class, 'register'])->name('register');

Route::resource('/dashboard', LayoutsControllerWeb::class);
Route::resource('/users', UsersControllerWeb::class);
Route::resource('/dosens', DosenControllerWeb::class);
Route::resource('/mahasiswas', MahasiswaControllerWeb::class);
Route::resource('/matakuliahs', MatakuliahControllerWeb::class);





