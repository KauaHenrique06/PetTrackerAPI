<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE USUARIO ==============

Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');
