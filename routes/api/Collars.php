<?php

use App\Http\Controllers\CollarsController;
use Illuminate\Support\Facades\Route;

Route::post('/', [CollarsController::class, 'store']);
Route::get('/{collar}', [CollarsController::class, 'findPetByCollarId']);
Route::patch('/associate/{pet}/{collar}', [CollarsController::class, 'associatePetToCollar'])->middleware('auth:sanctum');
Route::patch('/remove/{pet}/{collar}', [CollarsController::class, 'removeAssociationPetCollar'])->middleware('auth:sanctum');