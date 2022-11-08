<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('user/info', [UserController::class, 'info']);
    Route::get('books', [BookController::class, 'index'])->name('api.getBooks');
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('books/delete', [BookController::class, 'destroy'])->name('api.deleteBook')->middleware('api.bookDelete');
    Route::post('books/create', [BookController::class, 'create'])->name('api.createBook')->middleware('api.bookCreate');
});

Route::post('register', [AuthController::class, 'regProccess']);
Route::post('login', [AuthController::class, 'loginProccess']);
