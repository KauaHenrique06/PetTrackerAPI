<?php

use App\Http\Controllers\PetObservationsController;
use Illuminate\Support\Facades\Route;

Route::post('/{petId}', [PetObservationsController::class, 'store'])->middleware('auth:sanctum');

Route::put('/{petObsId}', [PetObservationsController::class, 'update'])->middleware('auth:sanctum');

Route::delete('/{petObsId}', [PetObservationsController::class, 'destroy'])->middleware('auth:sanctum');

// Route::get('/', [PetObservationsController::class, 'index'])->middleware('auth:sanctum');

// Route::get('/{petId}', [PetObservationsController::class, 'show'])->middleware('auth:sanctum');