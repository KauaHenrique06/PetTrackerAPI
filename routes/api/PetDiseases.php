<?php

use App\Http\Controllers\PetDiseasesController;
use Illuminate\Support\Facades\Route;

Route::post('/', [PetDiseasesController::class, 'store'])->middleware('auth:sanctum');
Route::get('/chronic/{pet}', [PetDiseasesController::class, 'indexChronicDiseases']);
Route::get('/normal/{pet}', [PetDiseasesController::class, 'indexNormalDiseases']);