<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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
Route::get('/api_bypass_login', [AuthController::class, 'apiByPassLogin'])->name('api_bypass_login');
Route::get('user', [AuthController::class, 'list_user']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
