<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

// ============== ROTAS DE USUARIO ==============

Route::get('/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
