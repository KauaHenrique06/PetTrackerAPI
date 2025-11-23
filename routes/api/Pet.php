<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\PetVaccineController;
use Illuminate\Support\Facades\Route;

Route::post('/apply-vaccine', [PetVaccineController::class, 'store'])->middleware('auth:sanctum');

Route::delete('/remove-vaccine/{petId}/{pivotId}', [PetVaccineController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/', [PetController::class, 'store'])->middleware('auth:sanctum');

Route::post('/{petId}', [PetController::class, 'update'])->middleware('auth:sanctum');

Route::delete('/{petId}', [PetController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/', [PetController::class, 'index'])->middleware('auth:sanctum');

Route::get('/{petId}', [PetController::class, 'show']);


