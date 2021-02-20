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

Route::get('/',[App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/register',[App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/signup',[App\Http\Controllers\AuthController::class, 'signup'])->name('signup');
Route::post('/signin',[App\Http\Controllers\AuthController::class, 'signin'])->name('signin');
Route::get('/home',[App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/logout',[App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Product
Route::get('/product',[App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::post('/product/price',[App\Http\Controllers\ProductController::class, 'price'])->name('product.price');
Route::get('/product/all',[App\Http\Controllers\ProductController::class, 'getProduct'])->name('product.all');
Route::post('/product/store',[App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::get('/product/edit/{id}',[App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{id}',[App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::get('/product/delete/{id}',[App\Http\Controllers\ProductController::class, 'destroy'])->name('product.delete');

// purchasing
Route::get('/purchasing',[App\Http\Controllers\PurchasingController::class, 'index'])->name('purchasing.index');
Route::get('/purchasing/all',[App\Http\Controllers\PurchasingController::class, 'getPurchasing'])->name('purchasing.all');
Route::post('/purchasing/store',[App\Http\Controllers\PurchasingController::class, 'store'])->name('purchasing.store');
Route::get('/purchasing/delete/{id}',[App\Http\Controllers\PurchasingController::class, 'destroy'])->name('purchasing.delete');


//salesController
Route::get('/sales',[App\Http\Controllers\SalesController::class, 'index'])->name('sales.index');
Route::post('/sales/store',[App\Http\Controllers\SalesController::class, 'store'])->name('sales.store');
Route::get('/sales/all',[App\Http\Controllers\SalesController::class, 'getSales'])->name('sales.all');
Route::post('/sales/store',[App\Http\Controllers\SalesController::class, 'store'])->name('sales.store');
Route::get('/sales/delete/{id}',[App\Http\Controllers\SalesController::class, 'destroy'])->name('sales.delete');









