<?php

use App\Http\Controllers\ParkingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ZoneController;
use App\Models\Parking;
use App\Http\Controllers\Api\{
    LoginController,
    LogoutController,
    PasswordUpdateController,
    ProfileController,
    RegisterController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [LoginController::class, 'login']);
Route::post('auth/register', [RegisterController::class, 'register']);
Route::get('zones', [ZoneController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('password', [PasswordUpdateController::class, 'change_password']);

    Route::apiResource('vehicles', VehicleController::class);

    Route::get('parkings', [ParkingController::class, 'index']);
    Route::get('parkings/history', [ParkingController::class, 'history']);
    Route::post('parkings/start', [ParkingController::class, 'start']);
    Route::get('parkings/{parking}', [ParkingController::class, 'show']);

    Route::bind('activeParking', function ($id) {
        return Parking::where('id', $id)->active()->firstOrFail();
    });
    Route::put('parkings/{activeParking}', [ParkingController::class, 'stop']);

    Route::post('auth/logout', [LogoutController::class, 'logout']);
});
