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
Auth::routes();

Route::post('/book-copies/remove/{id}', [BookCopyController::class, 'removeBookCopy'])->name('book-copies.remove');

Route::get('/book-lendings/create-one', [BookLendingController::class, 'create_one'])->name('book-lendings-create-step1');
Route::get('/book-lendings/create-two', [BookLendingController::class, 'create_two'])->name('book-lendings-create-step2');
Route::post('/book-lendings/post-one', [BookLendingController::class, 'post_one'])->name('book-lendings-post-step1');
Route::post('/book-lendings/post-two', [BookLendingController::class, 'post_two'])->name('book-lendings-post-step2');
Route::get('/book-lendings/return', [BookLendingController::class, 'return'])->name('book-lendings.return');
Route::post('/book-lendings/redirect', [BookLendingController::class, 'redirect'])->name('book-lendings.redirect');
Route::post('/book-lendings/{bookLending}/extend-deadline', [BookLendingController::class, 'extendDeadline'])->name('book-lendings.extend-deadline');

// I think this one is no longer used
Route::put('/book-lendings/{bookLending}/return', [BookLendingController::class, 'returnBook'])->name('book-lendings.return-book');

Route::get('/qrcode/scan', [BookCopyController::class, 'scanQRCode'])->name('qr-code-scan');
Route::get('/download-qr-code/{bookCopy}', [BookCopyController::class, 'downloadQRCode'])->name('qrcode.download');

Route::post('/users/qrcode/read/{id}', [UserController::class, 'readUserQRCode'])->name('users.readQRCode');
Route::post('/books/qrcode/read/{id}', [BookCopyController::class, 'readBookQRCode'])->name('books.readQRCode');

// route for downloading qrcodes 
Route::get('/download-qrcodes', [BookCopyController::class, 'download_all'])->name('download-qrcodes'); 

Route::resource('book-copies', BookCopyController::class);
Route::resource('/book-lendings', BookLendingController::class);
// Route::get('/home', [HomeController::class, 'index'])->name('home');
