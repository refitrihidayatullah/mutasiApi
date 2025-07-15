<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\Api\MutasiController;
use App\Http\Controllers\Api\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/all-produk', [ProdukController::class, 'getAllProduk']);
    Route::post('/tambah-produk', [ProdukController::class, 'tambahProduk']);
    Route::put('/update-produk/{id}', [ProdukController::class, 'editProduk']);
    Route::delete('/delete-produk/{id}', [ProdukController::class, 'hapusProduk']);
});

Route::prefix('v1')->group(function () {
    Route::get('/all-lokasi', [LokasiController::class, 'getAllLokasi']);
    Route::post('/tambah-lokasi', [LokasiController::class, 'tambahLokasi']);
    Route::put('/update-lokasi/{id}', [LokasiController::class, 'editLokasi']);
    Route::delete('/delete-lokasi/{id}', [LokasiController::class, 'hapusLokasi']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/tambah-mutasi', [MutasiController::class, 'tambahMutasi']);
});

Route::prefix('v1')->group(function () {
    Route::post('/register-user', [AuthController::class, 'registerUser']);
});
