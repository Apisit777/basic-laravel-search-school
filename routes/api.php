<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductMasterController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\ArtisanController;
use App\Http\Controllers\ImportExcel\ImportController;
use App\Http\Controllers\LaravelControl\LaravelControlController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/apiLogin', [AuthController::class, 'apiLogin'])->name('apiLogin');
Route::get('/api_apps_login', [AuthController::class, 'apiAppsLogin'])->name('api_apps_login');
Route::get('/users', [AuthController::class, 'list_user']);

// Wherehouse
Route::get('/warehouse',  [AuthController::class, 'apiWhereHouse'])->name('api.warehouse');

// API ProductMaster
Route::get('/products', [ProductMasterController::class, 'listProducts']);
Route::get('/products/detail', [ProductMasterController::class, 'list_product_detail']);
Route::get('/series', [ProductMasterController::class, 'list_series']);
Route::get('/solutions', [ProductMasterController::class, 'list_solutions']);
Route::get('/categorys', [ProductMasterController::class, 'list_categorys']);
Route::get('/sub_categorys', [ProductMasterController::class, 'list_sub_categorys']);

// Command transfer
Route::get('/transfer/{task}', [CommonController::class, 'transfer']);
Route::get('/midnight_transfer/{task}', [CommonController::class, 'midnightTransfer']);

// Command production transfer
Route::get('/production_transfer/{task}', [CommonController::class, 'productionTransfer']);
Route::get('/production_transfer/{task}', [CommonController::class, 'productionMidnightTransfer']);

// Command Account Schedule
Route::get('/account_schedule/{task}', [CommonController::class, 'accountSchedule']);

// Command production transfer Data KM
Route::get('/production_transfer_data_km/{task}', [CommonController::class, 'KmSchedule']);

// Diary (remote DB 10.20.10.35)
Route::match(['get', 'post'], '/diary', [ImportController::class, 'getDiary']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Artisan API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('artisan')->group(function () {
    Route::post('/route-cache', [ArtisanController::class, 'routeCache']);
});

/*
|--------------------------------------------------------------------------
| Laravel Control Routes
|--------------------------------------------------------------------------
*/
Route::prefix('laravel-control')->middleware('web')->group(function () {
    Route::post('/command', [LaravelControlController::class, 'command']);
    Route::get('/status', [LaravelControlController::class, 'status']);
    Route::get('/branch', [LaravelControlController::class, 'branch']);
    Route::post('/checkout', [LaravelControlController::class, 'checkout']);
    Route::get('/config', [LaravelControlController::class, 'config']);
    Route::get('/history', [LaravelControlController::class, 'history']);
    Route::get('/branches', [LaravelControlController::class, 'branches']);
    Route::post('/show', [LaravelControlController::class, 'show']);
    Route::post('/show-all', [LaravelControlController::class, 'showAll']);
});