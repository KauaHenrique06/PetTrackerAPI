<?php

use Illuminate\Support\Facades\Route;

// Rotas de auth
Route::prefix('auth')->name('api.')->group(function () {
    require __DIR__ .  '/Auth.php';
});

// Rotas de Usuario
Route::prefix('users')->name('api.')->group(function () {
    require __DIR__ .  '/User.php';
});

// Rotas de endereço
Route::prefix('address')->name('api.')->group(function () {
    require __DIR__ .  '/Address.php';
});

// Rotas de telefone
Route::prefix('phone')->name('api.')->group(function () {
    require __DIR__ .  '/Phone.php';
});