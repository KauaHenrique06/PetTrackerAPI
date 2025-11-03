<?php

use App\Http\Controllers\PetMedicationsController;
use Illuminate\Support\Facades\Route;

Route::post('/', [PetMedicationsController::class, 'store'])->middleware('auth:sanctum');