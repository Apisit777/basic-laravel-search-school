<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProductForm\ProductFormController;
use App\Http\Controllers\Managemenu\ManageMenuController;
use App\Http\Controllers\Warehouse\ComProductController;
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

Route::get('/', function () {
    return view('auth.login');
});

// Login
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/checkLogin', [AuthController::class, 'checkLogin'])->name('checkLogin');
Route::get('/post', [AuthController::class, 'index'])->name('post');

// Users login
// Route::get('/api_bypass_login_user', [AuthController::class, 'apiByPassLoginUser'])->name('api_bypass_login_user');
Route::post('/api_bypass_login_user', [AuthController::class, 'apiByPassLoginUser'])->name('api_bypass_login_user');
// By pass login for developer
Route::get('/api_bypass_login', [AuthController::class, 'apiByPassLogin'])->name('api_bypass_login');

Route::middleware('auth')->group(function() {

    Route::get('/check_token', [AuthController::class, 'tokenExpired'])->name('auth.tokenExpired');

    // npd
    Route::group(['prefix' => 'new_product_develop', 'as' => 'new_product_develop.'], function () {
        Route::get('', [ProductFormController::class, 'index'])->name('index');
        Route::post('/list_npd', [ProductFormController::class, 'list_npd'])->name('list_npd');
        Route::post('/', [ProductFormController::class, 'store'])->name('store');
        Route::get('/create', [ProductFormController::class, 'create'])->name('create');
        Route::post('/check_code', [ProductFormController::class, 'checkCode'])->name('check_code');
        Route::get('/show/{id_barcode}', [ProductFormController::class, 'show'])->name('show');
        Route::post('/duplicate_npd_request/{id_barcode}', [ProductFormController::class, 'duplicateNpdRequest'])->name('show_barcode');
        Route::get('/edit/{id_barcode}', [ProductFormController::class, 'edit'])->name('edit');
        Route::post('/update/{id_barcode}', [ProductFormController::class, 'update'])->name('update');
    });
    
    // Account
    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
        Route::get('', [ProductFormController::class, 'indexAccount'])->name('index');
        Route::post('/list_ajax_account', [ProductFormController::class, 'listAjaxAccount'])->name('list_ajax_account');
        Route::get('/create', [ProductFormController::class, 'createAccount'])->name('create');
        Route::get('/edit/{id}', [ProductFormController::class, 'createAccount'])->name('edit');
    });
    
    // product
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('/get_barcode', [ProductController::class, 'getBarcode'])->name('get_barcode');
        Route::get('/checkproduct', [ProductController::class, 'check_product'])->name('checkproduct');
        Route::get('/checkproduct_consumables', [ProductController::class, 'check_product_consumables'])->name('checkproduct_consumables');
        Route::post('/list_products', [ProductController::class, 'list_products'])->name('list_products');
        Route::get('/product_master_get_brand_list_ajax', [ProductController::class, 'productMasterGetBrandListAjax'])->name('product_master_get_brand_list_ajax');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::post('/store_consumables', [ProductController::class, 'storeConsumables'])->name('store_consumables');
        Route::post('/create_copy', [ProductController::class, 'createCopy'])->name('create_copy');
        Route::post('/create_copy_consumables', [ProductController::class, 'createCopyConsumables'])->name('create_copy_consumables');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/create_consumables', [ProductController::class, 'createConsumables'])->name('create_consumables');
        Route::get('/edit/{PRODUCT}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{PRODUCT}', [ProductController::class, 'update'])->name('update');
        Route::delete('/update_product_status/{id}', [ProductController::class, 'upate_product_status'])->name('update_product_status');
    });

    // Km
    Route::group(['prefix' => 'warehouse', 'as' => 'warehouse.'], function () {
        Route::get('/dimension', [ComProductController::class, 'index'])->name('index');
        Route::post('/list_warehouse', [ComProductController::class, 'listWarehouse'])->name('list_warehouse');
        Route::get('/dimension/create', [ComProductController::class, 'create'])->name('create');
        Route::post('/', [ComProductController::class, 'store'])->name('store');
        Route::get('/dimension/edit/{product_id}', [ComProductController::class, 'edit'])->name('edit');
        Route::post('/update/{product_id}', [ComProductController::class, 'update'])->name('update');
    });

    // Manage general information
    Route::group(['prefix' => 'manage_general_information', 'as' => 'manage_general_information.'], function () {
        Route::get('/tool', [ToolController::class, 'index'])->name('index');
        Route::get('/images', [ProductImageController::class, 'index'])->name('indexImage');
        Route::get('/camera', [ProductImageController::class, 'show'])->name('camera');
    });

    // Logout
    Route::get('/logout', [AuthController::class, 'apiByPassLogout'])->name('logout');
});

// search_school
Route::get('/home', [HomeController::class, 'home']);
Route::get('/search_school', [HomeController::class, 'index'])->name('search_school');
Route::post('/search_school', [HomeController::class, 'search_school']);

Route::get('/get_users', [ProductController::class, 'get_users'])->name('get_users');

Route::get('/product_detail_create', [ProductController::class, 'productDetailCreate'])->name('product_detail_create');
Route::post('/checknamebrand', [ProductController::class, 'checkname_brand'])->name('checknamebrand');
// Route::post('/checkproduct', [ProductController::class, 'check_product'])->name('checkproduct');

Route::get('/get_brand_list_ajax', [ProductFormController::class, 'getBrandListAjax'])->name('get_brand_list_ajax');

Route::post('/list_approve_products', [ProductController::class, 'list_approve_products'])->name('list_approve_products');

// manage_menu
Route::get('/manage_menu', [ManageMenuController::class, 'index'])->name('manage_menu');
Route::post('/list_menu', [ManageMenuController::class, 'listMenu'])->name('list_menu');

// Route::get('/create_menu', [ManageMenuController::class, 'createMenu'])->name('create_menu');
Route::post('/create_menu', [ManageMenuController::class, 'store'])->name('create_menu');

Route::get('/menu_access', [ManageMenuController::class, 'menuAccess'])->name('menu_access');
Route::post('/create_access', [ManageMenuController::class, 'createAccess'])->name('create_access');
Route::post('/delete_access', [ManageMenuController::class, 'deleteAccess'])->name('delete_access');

// Route::get('/tool', [ToolController::class, 'index'])->name('tool');

// Notify
Route::get('/test', [PusherController::class, 'index']);
Route::post('/broadcast', [PusherController::class, 'broadcast'])->name('broadcast');
Route::get('/get_receive', [PusherController::class, 'receive'])->name('get_receive');
Route::post('/receive', [PusherController::class, 'receive'])->name('receive');

Route::post('/broadcast_npd', [PusherController::class, 'broadcastNPD'])->name('broadcast_npd');
Route::get('/get_receive_pm', [PusherController::class, 'receivePM'])->name('get_receive_pm');

Route::get('/getBrandIdListAjax', [BrandController::class, 'getBrandIdListAjax'])->name('ajax_brand_id');

// images
Route::group(['prefix' => 'images', 'as' => 'images.'], function () {
    Route::get('', [ProductImageController::class, 'index'])->name('index');
    Route::post('/images_upload', [ProductImageController::class, 'store'])->name('store');
});

// Language
Route::get('/greeting/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'th'])) {
        return response()->json([
            'status' => 400
        ]);
    }
    session()->put('locale', $locale);

    return response()->json([
        'status' => 200
    ]);
})->name('setLocale');