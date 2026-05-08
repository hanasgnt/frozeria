<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::get('/', [ItemController::class, 'index'])->name('dashboard');

// Item
Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
Route::post('/item', [ItemController::class, 'store'])->name('item.store');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');
Route::get('/item/{item}/edit', [ItemController::class, 'edit'])->name('item.edit');
Route::put('/item/{item}', [ItemController::class, 'update'])->name('item.update');
Route::delete('/item/{item}', [ItemController::class, 'destroy'])->name('item.destroy');

// Transaction
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::get('/item/{item}/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
Route::post('/item/{item}/transaction', [TransactionController::class, 'store'])->name('transaction.store');
Route::get('/item/{item}/transaction/history', [TransactionController::class, 'history'])->name('transaction.history');

// Category
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

// Help
Route::view('/help', 'help.index')->name('help');