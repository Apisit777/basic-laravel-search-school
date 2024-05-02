<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});
