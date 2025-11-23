<?php

use App\Http\Controllers\PetMedProceduresController;
use Illuminate\Support\Facades\Route;

Route::post('/{petId}', [PetMedProceduresController::class, 'store'])->middleware('auth:sanctum');

Route::put('/{petMedId}', [PetMedProceduresController::class, 'update'])->middleware('auth:sanctum');

Route::delete('/{petMedId}', [PetMedProceduresController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/{pet}', [PetMedProceduresController::class, 'index']);

Route::get('/{petMedId}', [PetMedProceduresController::class, 'show']);