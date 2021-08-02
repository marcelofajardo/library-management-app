<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCopyController;
use App\Http\Controllers\BookLendingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('authors', AuthorController::class);
Route::resource('publishers', PublisherController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('genres', GenreController::class);
Route::resource('users', UserController::class);
Route::resource('books', BookController::class);
Route::resource('book-copies', BookCopyController::class);
Route::resource('/book-lendings', BookLendingController::class);
Auth::routes();

Route::get('/qrcode/scan', [BookCopyController::class, 'scanQRCode'])->name('qr-code-scan');
Route::get('/download-qr-code/{id}', [BookCopyController::class, 'downloadQRCode'])->name('qrcode.download');

Route::post('/users/qrcode/read/{user}', [UserController::class, 'readUserQRCode'])->name('users.readQRCode');
Route::post('/books/qrcode/read/{bookCopy}', [BookCopyController::class, 'readBookQRCode'])->name('books.readQRCode');

// Route::get('/home', [HomeController::class, 'index'])->name('home');
