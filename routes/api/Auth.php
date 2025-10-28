<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE AUTENTICAÇÃO ==============

Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::patch('/change-password', [AuthController::class, 'loggedInPasswordChange'])->middleware('auth:sanctum');