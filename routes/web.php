<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\BarangController;
use \App\Http\Controllers\KategoriController;
use \App\Http\Controllers\BarangMasukController;
use \App\Http\Controllers\BarangKeluarController;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\RegisterController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('login');
});

//route resource for products
Route::resource('products', \App\Http\Controllers\ProductController::class)->middleware('auth');

Route::resource('dashboard', DashboardController::class)->middleware('auth');
Route::resource('barang', BarangController::class)->middleware('auth');
Route::resource('kategori', KategoriController::class)->middleware('auth');
Route::resource('barangmasuk', BarangMasukController::class)->middleware('auth');
Route::resource('barangkeluar', BarangKeluarController::class)->middleware('auth');

//route login
Route::get('login', [LoginController::class,'index'])->name('login')->middleware('auth');
Route::post('login', [LoginController::class,'authenticate']);

//route logout
Route::get('logout', [LoginController::class,'logout']);
Route::post('logout', [LoginController::class,'logout']);

//route register
Route::get('register', [RegisterController::class,'create']);
Route::post('register', [RegisterController::class,'store']);

//route category
Route::resource('category', CategoryController::class);


