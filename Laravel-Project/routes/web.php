<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\AddController;
use App\Http\Controllers\AddAuthorsController;

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
    return view('main');
});*/

Route::get('/', [BooksController::class, 'main'])->name('index');
Route::post('/del', [BooksController::class, 'delete'])->name('delete_book');
Route::get('/search', [BooksController::class, 'search'])->name('search');
Route::get('/authors', [AuthorsController::class, 'main'])->name('authors');
Route::post('/authors/del', [AuthorsController::class, 'delete'])->name('delete_author');
Route::get('/authors_edit', [AuthorsController::class, 'edit'])->name('edit_author');
Route::post('/authors_update', [AuthorsController::class, 'update'])->name('update_authors');
Route::get('/search_authors', [AuthorsController::class, 'search'])->name('search_authors');
Route::get('/add', [AddController::class, 'main'])->name('add');
Route::post('/add', [AddController::class, 'add'])->name('add_book');
Route::get('/add_authors', [AddAuthorsController::class, 'main'])->name('add_authors');
Route::post('/add_authors', [AddAuthorsController::class, 'add'])->name('add_authors');
