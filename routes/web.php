<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AdminBooksController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Book Administration
Route::prefix('admin')->group(function () {
    Route::controller(AdminBooksController::class)->group(function () {
        Route::get('/', 'showBooks' )->middleware('administrator');
        Route::get('/addedit/{id}', 'addedit')->middleware('administrator');
        Route::post('/addedit', 'addedit')->middleware('administrator');
        Route::post('/delete', 'deleteBook')->middleware('administrator');
    });
});

//Books
Route::get('/', [BooksController::class, 'showBooks'])->middleware('auth');

Route::controller(BooksController::class)->group(function () {
    Route::get('/book/{id}', 'showBook');
    Route::post('/book/reserve', 'addBookReservation');
})->middleware('auth');

Route::controller(UserController::class)->group(function () {
    Route::get('/settings', 'showSettings');
    Route::post('/settings', 'showSettings');
})->middleware('auth');

Auth::routes();
