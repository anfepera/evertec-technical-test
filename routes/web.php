<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/products', [\App\Http\Controllers\ProductController::class, "index"])->name('products.index');
Route::get('/orders', [\App\Http\Controllers\OrderController::class, "index"])->name('orders.index');
Route::get('/order/new/{product}', [\App\Http\Controllers\OrderController::class, "new"])->name('order.new');;
Route::post('/order/create', [\App\Http\Controllers\OrderController::class, "create"])->name('order.create');
Route::get('/order/detail/{reference}', [\App\Http\Controllers\OrderController::class, "detail"])->name('order.detail');
Route::post('/order/pay', [\App\Http\Controllers\OrderController::class, "pay"])->name('order.pay');
Route::get('/order/retry/{order}', [\App\Http\Controllers\OrderController::class, "retry"])->name('order.retry');

Route::get('/order/filterOrderBy/{field}/{filter}', [\App\Http\Controllers\OrderController::class, "filterOrderBy"])->name('order.filter');
