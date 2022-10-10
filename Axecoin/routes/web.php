<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [CustomAuthController::class, 'home']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::get('reg', [CustomAuthController::class, 'reg'])->name('reg');
Route::post('postlogin', [CustomAuthController::class, 'login'])->name('postlogin');
Route::post('postReg', [CustomAuthController::class, 'register'])->name('postreg');
