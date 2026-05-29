<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MakananKhasController;
use App\Http\Controllers\WilayahController;

// Halaman Provinsi
Route::get('/', [WilayahController::class, 'provinces']);

// Halaman Kota (filter by provinsi)
Route::get('/kota', [WilayahController::class, 'regencies']);
Route::get('/kota/provinsi/{provinceId}', [WilayahController::class, 'regencies']);

// Halaman Kecamatan (filter by kota)
Route::get('/kecamatan', [WilayahController::class, 'districts']);
Route::get('/kecamatan/provinsi/{provinceId}/kota/{regencyId}', [WilayahController::class, 'districts']);

// Halaman Kelurahan (filter by kecamatan)
Route::get('/kelurahan', [WilayahController::class, 'subdistricts']);
Route::get('/kelurahan/provinsi/{provinceId}/kota/{regencyId}/kecamatan/{districtId}', [WilayahController::class, 'subdistricts']);

Route::resource('makanan-khas', MakananKhasController::class)
    ->parameters(['makanan-khas' => 'makanan_khas'])
    ->except(['show']);
