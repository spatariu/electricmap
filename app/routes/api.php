<?php
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

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UserController;

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('stations', StationController::class);
    Route::get('/charging-stations', [StationController::class, 'getChargingStations']);
});