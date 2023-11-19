<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AdminBooksController;
use App\Http\Controllers\LocationController;
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
        Route::get('/book', 'showBooks' )->middleware('administrator');
        Route::match(array('GET', 'POST'), '/book/addedit/{id}', 'addedit')->middleware('administrator');
        Route::match(array('GET', 'POST'), '/book/addedit', 'addedit')->middleware('administrator');
        Route::post('/book/delete', 'deleteBook')->middleware('administrator');
    });

    Route::controller(LocationController::class)->group(function () {
        Route::get('/location', 'showLocations')->middleware('administrator');
        Route::get('/location/addedit/{id}', 'editlocation')->middleware('administrator');
        Route::post('/location/delete', 'deleteLocation')->middleware('administrator');
        Route::match(array('GET', 'POST'), '/location/addedit', 'editlocation')->middleware('administrator');
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

Route::controller(ReservationsController::class)->group(function () {
    Route::get('/reservations', 'showReservations');;
})->middleware('auth');

Auth::routes();
