<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
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

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authProccess'])->name('auth.proccess');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'regProccess'])->name('reg.proccess');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [BookController::class, 'index']);
    Route::resource('/authors', AuthorController::class)->middleware('role');
    Route::resource('/books', BookController::class);
    Route::post('/add_cart', [CartController::class, 'add'])->name('add.cart');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::post('/orders/create', [OrderController::class, 'create'])->name('order.create');
});
