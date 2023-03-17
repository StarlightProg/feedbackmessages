<?php

use App\Http\Controllers\GetMessagesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StoreController;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home']);

Route::get('/pagination', [App\Http\Controllers\HomeController::class, 'fetch_data']);
Route::get('/paginationAmount', [App\Http\Controllers\HomeController::class, 'pagination_amount']);
Route::get('/paginationSort', [App\Http\Controllers\HomeController::class, 'pagination_sort']);
Route::get('/downloadFile', [App\Http\Controllers\HomeController::class, 'download_file']);

Route::post('/store',StoreController::class)->name('store.message');