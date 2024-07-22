<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('register');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/search', [BookController::class, 'search']);

    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow']);
    Route::post('/books/{book}/return', [BorrowingController::class, 'returnBook']);
    Route::get('/books/borrowed', [BorrowingController::class, 'getBorrowedBooks']);
});
