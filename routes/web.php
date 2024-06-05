<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Managemenu\ManageMenuController;

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

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');

Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/login', function () {
//     return "Check login";
// });

Route::post('/checkLogin', [AuthController::class, 'checkLogin'])->name('checkLogin');

Route::get('/home', [HomeController::class, 'home']);
Route::get('/search_school', [HomeController::class, 'index'])->name('search_school');
Route::post('/search_school', [HomeController::class, 'search_school']);

Route::get('/images', [ProductImageController::class, 'index'])->name('images');
Route::post('/images_upload', [ProductImageController::class, 'store'])->name('images_upload');

Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product_create', [ProductController::class, 'create'])->name('product_create');
Route::post('', [ProductController::class, 'store'])->name('');

Route::get('/manage_menu', [ManageMenuController::class, 'index'])->name('manage_menu');

Route::get('/', function () {
    return view('welcome');
});
