<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaginationController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'home']);

Route::controller(PaginationController::class)->group(function(){
    Route::get('/pagination', [PaginationController::class, 'fetchData']);
    Route::get('/paginationAmount', [PaginationController::class, 'paginationAmount']);
    Route::get('/paginationSort', [PaginationController::class, 'paginationSort']);
});

Route::get('/downloadFile', [DownloadController::class, 'downloadFile']);

Route::post('/store',[StoreController::class, 'store'])->name('store.message');