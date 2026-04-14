<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController2;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/chi-tiet/{id}', [LaptopController2::class, 'chiTiet'])->middleware(['auth', 'verified'])->name('chitiet');
Route::post('/cart/add', [LaptopController2::class, 'cartAdd'])->name('cartadd');
Route::get('/order', [LaptopController2::class, 'order'])->name('order');
Route::post('/cart/delete', [LaptopController2::class, 'cartDelete'])->name('cartdelete');
Route::post('/order/create', [LaptopController2::class, 'orderCreate'])->middleware('auth')->name('ordercreate');

require __DIR__.'/auth.php';
