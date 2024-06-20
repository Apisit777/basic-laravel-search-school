<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProductForm\ProductFormController;
use App\Http\Controllers\Managemenu\ManageMenuController;
use App\Http\Controllers\Tool\ToolController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\BrandController;

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
Route::get('/post', [AuthController::class, 'index'])->name('post');

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/checkLogin', [AuthController::class, 'checkLogin'])->name('checkLogin');

Route::get('/home', [HomeController::class, 'home']);
Route::get('/search_school', [HomeController::class, 'index'])->name('search_school');
Route::post('/search_school', [HomeController::class, 'search_school']);

Route::get('/images', [ProductImageController::class, 'index'])->name('images');
Route::post('/images_upload', [ProductImageController::class, 'store'])->name('images_upload');

Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product_form', [ProductFormController::class, 'index'])->name('product_form');
Route::get('/product_form_creat', [ProductFormController::class, 'create'])->name('product_form_creat');

Route::get('/get_users', [ProductController::class, 'get_users'])->name('get_users');
Route::post('/create_products', [ProductController::class, 'store'])->name('create_products');
Route::get('/product_create', [ProductController::class, 'create'])->name('product_create');
Route::get('/checknamebrand', [ProductController::class, 'checkname_brand'])->name('checknamebrand');
Route::post('/list_products', [ProductController::class, 'list_products'])->name('list_products');
Route::post('/list_approve_products', [ProductController::class, 'list_approve_products'])->name('list_approve_products');
Route::delete('/upate_product_status/{id}', [ProductController::class, 'upate_product_status'])->name('upate_product_status');

Route::get('/manage_menu', [ManageMenuController::class, 'index'])->name('manage_menu');
Route::get('/tool', [ToolController::class, 'index'])->name('tool');

Route::get('/test', [PusherController::class, 'index']);
Route::post('/broadcast', [PusherController::class, 'broadcast'])->name('broadcast');
Route::get('/get_receive', [PusherController::class, 'receive'])->name('get_receive');
Route::post('/receive', [PusherController::class, 'receive'])->name('receive');

Route::get('/getBrandIdListAjax', [BrandController::class, 'getBrandIdListAjax'])->name('ajax_brand_id');


Route::get('/', function () {
    return view('welcome');
    });
