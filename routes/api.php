<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function() {

    Route::post('/', [AuthController::class, 'store']);

    Route::post('/login', [AuthController::class, 'login']);

});

Route::post('/user/{user}/phone', [PhoneController::class, 'store']);

Route::post('user/{id}/address', [AddressController::class, 'store']);