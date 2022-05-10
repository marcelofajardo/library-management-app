<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCopyController;
use App\Http\Controllers\BookLoanController;
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
Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('users', UserController::class);
    Route::resource('books', BookController::class);

    Route::post('/book-copies/remove/{id}', [BookCopyController::class, 'removeBookCopy'])->name('book-copies.remove');

    Route::get('/book-loans/create-one', [BookLoanController::class, 'create_one'])->name('book-loans-create-step1');
    Route::get('/book-loans/create-two', [BookLoanController::class, 'create_two'])->name('book-loans-create-step2');
    Route::post('/book-loans/post-one', [BookLoanController::class, 'post_one'])->name('book-loans-post-step1');
    Route::post('/book-loans/post-two', [BookLoanController::class, 'post_two'])->name('book-loans-post-step2');
    Route::get('/book-loans/return', [BookLoanController::class, 'return'])->name('book-loans.return');
    Route::post('/book-loans/redirect', [BookLoanController::class, 'redirect'])->name('book-loans.redirect');
    Route::post('/book-loans/{bookLoan}/extend-deadline', [BookLoanController::class, 'extendDeadline'])->name('book-loans.extend-deadline');
    Route::put('/book-loans/{book_loan}', [BookLoanController::class, 'update'])->name('book-loans.update');
    Route::resource('/book-loans', BookLoanController::class)->except('update');

// I think this one is no longer used
    Route::put('/book-loans/{bookLoan}/return', [BookLoanController::class, 'returnBook'])->name('book-loans.return-book');

    Route::get('/qrcode/scan', [BookCopyController::class, 'scanQRCode'])->name('qr-code-scan');
    Route::get('/download-qr-code/{bookCopy}', [BookCopyController::class, 'downloadQRCode'])->name('qrcode.download');

    Route::post('/users/qrcode/read/{id}', [UserController::class, 'readUserQRCode'])->name('users.readQRCode');
    Route::post('/books/qrcode/read/{id}', [BookCopyController::class, 'readBookQRCode'])->name('books.readQRCode');

// route for viewing qrcodes
    Route::get('/download-qrcodes', [BookCopyController::class, 'downloadAll'])->name('download-qrcodes');
// setting options
    Route::get('/download-options', [BookCopyController::class, 'downloadOptions'])->name('download.options');
// download link
    Route::post('/books/pdf', [BookCopyController::class, 'booksPdf'])->name('books.pdf');
    Route::post('/users/pdf', [BookCopyController::class, 'usersPdf'])->name('users.pdf');

    Route::resource('book-copies', BookCopyController::class);
});
