<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommonController;

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
Route::get('/series', [AuthController::class, 'list_series']);
Route::get('/solutions', [AuthController::class, 'list_solutions']);
Route::get('/categorys', [AuthController::class, 'list_categorys']);
Route::get('/sub_categorys', [AuthController::class, 'list_sub_categorys']);

// Command transfer
Route::get('/transfer/{task}', [CommonController::class, 'transfer']);

// Command production transfer
Route::get('/production_transfer/{task}', [CommonController::class, 'productionTransfer']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
