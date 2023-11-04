<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AdminBooksController;

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

Route::get('/', [BooksController::class, 'showBooks'])->middleware('auth');

Route::prefix('admin')->group(function () {
    Route::controller(AdminBooksController::class)->group(function () {
       Route::get('/', 'showBooks' );
       Route::get('/addedit/{id}', 'addedit');
       Route::post('/addedit', 'addedit');
    });
})->middleware('auth');

Auth::routes();
