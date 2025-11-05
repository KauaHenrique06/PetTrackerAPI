<?php

use App\Http\Controllers\PetMedicationsController;
use Illuminate\Support\Facades\Route;

Route::post('/', [PetMedicationsController::class, 'store'])->middleware('auth:sanctum');
Route::get('/continuous/{pet}', [PetMedicationsController::class, 'indexContinuousTreatments']);
Route::get('/periodic/{pet}', [PetMedicationsController::class, 'indexPeriodicTreatments']);
Route::get('/unique/{pet}', [PetMedicationsController::class, 'indexUniqueDoseTreatments']);
Route::patch('/{petMedications}', [PetMedicationsController::class, 'updatePetMedications'])->middleware('auth:sanctum');