<?php

use Illuminate\Support\Facades\Route;
use Whilesmart\UserDevices\Http\Controllers\DeviceController;

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

// User Devices routes

Route::apiResource('devices', DeviceController::class);

// Alternative route to update device by identifier (UUID)
Route::put('devices/by-identifier/{identifier}', [DeviceController::class, 'updateByIdentifier']);
