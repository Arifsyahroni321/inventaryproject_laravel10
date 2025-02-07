<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StockoutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/home', function () {
    return view('layouts.index');
});
Route::get('/', [DashboardController::class, 'index'])->name('login');

// Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/data', [ProductsController::class, 'getData'])->name('products.data');

// Route::get('/categori', [CategoryController::class, 'index'])->name('categori.index');
// Route::post('/categories', [CategoryController::class, 'store'])->name('categori.store');

Route::resource('categori', CategoryController::class)->names('categori');
Route::resource('product', ProductsController::class)->names('product');
Route::resource('stockout', StockoutController::class)->names('stockout');
Route::resource('user', UserController::class)->names('user');
Route::resource('user', UserController::class)->names('user');
