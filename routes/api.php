<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HistoryMutasi;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\Api\MutasiController;
use App\Http\Controllers\Api\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/all-produk', [ProdukController::class, 'getAllProduk']);
    Route::post('/tambah-produk', [ProdukController::class, 'tambahProduk']);
    Route::put('/update-produk/{id}', [ProdukController::class, 'editProduk']);
    Route::delete('/delete-produk/{id}', [ProdukController::class, 'hapusProduk']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/all-lokasi', [LokasiController::class, 'getAllLokasi']);
    Route::post('/tambah-lokasi', [LokasiController::class, 'tambahLokasi']);
    Route::put('/update-lokasi/{id}', [LokasiController::class, 'editLokasi']);
    Route::delete('/delete-lokasi/{id}', [LokasiController::class, 'hapusLokasi']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/all-mutasi', [MutasiController::class, 'getAllMutasi']);
    Route::post('/tambah-mutasi', [MutasiController::class, 'tambahMutasi']);
    Route::put('/update-mutasi/{mutasi}', [MutasiController::class, 'editMutasi']);
    Route::delete('/delete-mutasi/{mutasi}', [MutasiController::class, 'hapusMutasi']);
});

Route::prefix('v1')->group(function () {
    Route::get('/all-users', [AuthController::class, 'getAllUser'])->middleware('auth:sanctum');
    Route::post('/register-user', [AuthController::class, 'registerUser']);
    Route::post('/login-user', [AuthController::class, 'loginUser']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::put('/update-user/{id}', [AuthController::class, 'editUser'])->middleware('auth:sanctum');
    Route::delete('/delete-user/{user}', [AuthController::class, 'hapusUser'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/history-produk/{id}', [HistoryMutasi::class, 'historyProduk']);
    Route::get('/history-user/{id}', [HistoryMutasi::class, 'historyUser']);
});
