<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController2;
use App\Http\Controllers\LaptopController1;
use Illuminate\Support\Facades\Route;

// Câu 2+5
Route::get('/', [LaptopController1::class, 'index'])->name('laptop.index');
Route::get('/laptop/theloai/{id}', [LaptopController1::class, 'category'])->name('laptop.category');
Route::post('/timkiem', [LaptopController1::class, 'search'])->name('laptop.search');

//Câu 7
Route::get('/quanlysanpham', [LaptopController1::class, 'manage'])->middleware(['auth', 'verified'])->name('laptop.manage');
Route::delete('/quanlysanpham/{id}', [LaptopController1::class, 'destroy'])->middleware(['auth', 'verified'])->name('laptop.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/chi-tiet/{id}', [LaptopController2::class, 'chiTiet'])->middleware(['auth', 'verified'])->name('chitiet');
Route::post('/cart/add', [LaptopController2::class, 'cartAdd'])->name('cartadd');
Route::get('/order', [LaptopController2::class, 'order'])->name('order');
Route::post('/cart/delete', [LaptopController2::class, 'cartDelete'])->name('cartdelete');
Route::post('/order/create', [LaptopController2::class, 'orderCreate'])->middleware('auth')->name('ordercreate');

require __DIR__.'/auth.php';
