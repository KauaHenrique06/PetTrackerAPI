<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::post('/', [PetController::class, 'store'])->middleware('auth:sanctum');

Route::put('/{petId}', [PetController::class, 'update'])->middleware('auth:sanctum');