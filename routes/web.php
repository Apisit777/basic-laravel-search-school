<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductImageController;

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

Route::get('search_school', [HomeController::class, 'index']);
Route::post('search_school', [HomeController::class, 'search_school'])->name('search_school');

Route::get('images', [ProductImageController::class, 'index'])->name('images');
Route::post('images_upload', [ProductImageController::class, 'store'])->name('images_upload');

Route::get('/', function () {
    return view('welcome');
});
