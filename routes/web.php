<?php

use App\Http\Controllers\BookController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserBookController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// Protect all book-related routes with the auth middleware
Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);

    Route::post('/books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    Route::post('/books/{bookId}/return', [BookController::class, 'returnBook'])->name('books.return');

    Route::get('/userbooks', [UserBookController::class, 'index'])->name('userbooks.index');

    Route::post('/userbooks/{book}/rate', [UserBookController::class, 'rate'])->name('userbooks.rate');

    Route::post('/userbooks/{book}/review', [UserBookController::class, 'review'])->name('userbooks.review');

});

Route::get('/dashboard', [BookController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
