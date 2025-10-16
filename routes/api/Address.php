<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE ENDEREÇO ==============

Route::post('/user/{user}', [AddressController::class, 'store']);