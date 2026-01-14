<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginControllerMobile;
use App\Http\Controllers\HomeScreenController;
use App\Http\Controllers\UsersControllerMobile;
use App\Http\Controllers\ModulControllerMobile;
use App\Http\Controllers\TugasControllerMobile;

Route::post('login', [LoginControllerMobile::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function(Request $request) {return $request->user();});
Route::post('logout', [LoginControllerMobile::class, 'logout'])->middleware('auth:sanctum');
Route::get('data-pengguna', [LoginControllerMobile::class, 'dataPengguna'])->middleware('auth:sanctum');

Route::get('matakuliah-saya', [HomeScreenController::class, 'matakuliahSaya'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->post('/update-photo', [UsersControllerMobile::class, 'updateUserPhoto']);
Route::put('update-user', [UsersControllerMobile::class, 'updateUser'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/moduls/data', [ModulControllerMobile::class, 'getDataModul']);
Route::middleware('auth:sanctum')->get('/tugas/data', [TugasControllerMobile::class, 'getDataTugas']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tugas/detail', [TugasControllerMobile::class, 'detailTugas']);
    Route::post('/tugas/upload', [TugasControllerMobile::class, 'uploadJawaban']);
});
