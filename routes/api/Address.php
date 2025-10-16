<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE ENDEREÇO ==============

Route::post('user/{id}/address', [AddressController::class, 'store']);