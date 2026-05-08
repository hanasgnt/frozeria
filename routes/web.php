<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StokTransaksiController;

Route::get('/', [ItemController::class, 'index'])->name('dashboard');

// item
Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
Route::post('/item', [ItemController::class, 'store'])->name('item.store');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');
Route::get('/item/{item}/edit', [ItemController::class, 'edit'])->name('item.edit');
Route::put('/item/{item}', [ItemController::class, 'update'])->name('item.update');
Route::delete('/item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');

// Stok Transaksi
Route::get('/stok', [StokTransaksiController::class, 'index'])->name('stok.index');
Route::get('/item/{item}/stok/tambah', [StokTransaksiController::class, 'create'])->name('stok.create');
Route::post('/item/{item}/stok', [StokTransaksiController::class, 'store'])->name('stok.store');
Route::get('/item/{item}/stok/riwayat', [StokTransaksiController::class, 'riwayat'])->name('stok.riwayat');

// Kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// Bantuan
Route::view('/bantuan', 'bantuan.index')->name('bantuan');
