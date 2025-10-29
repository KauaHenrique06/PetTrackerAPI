<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE ENDEREÇO ==============

Route::post('/', [AddressController::class, 'store'])->middleware('auth:sanctum');
Route::get('/', [AddressController::class, 'addressByLoggedUser'])->middleware('auth:sanctum');
Route::put('/{address}', [AddressController::class, 'update'])->middleware('auth:sanctum');