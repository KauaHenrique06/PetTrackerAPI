<?php

use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE TELEFONE ==============

Route::post('/user/{user}/phone', [PhoneController::class, 'store']);