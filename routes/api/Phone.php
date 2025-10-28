<?php

use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE TELEFONE ==============

Route::post('/', [PhoneController::class, 'store'])->middleware('auth:sanctum');
Route::get('/', [PhoneController::class, 'index'])->middleware('auth:sanctum');
Route::put('/update-phones', [PhoneController::class, 'update'])->middleware('auth:sanctum');