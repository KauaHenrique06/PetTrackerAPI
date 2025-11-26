<?php

use App\Http\Controllers\VaccineController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/', [VaccineController::class, 'store'])->middleware('auth:sanctum');

Route::post('/{vaccineId}', [VaccineController::class, 'update'])->middleware('auth:sanctum');

Route::delete('/{vaccineId}', [VaccineController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/list/{specieId}', [VaccineController::class, 'index']);

Route::get('/{vaccineId}', [VaccineController::class, 'show'])->middleware('auth:sanctum');