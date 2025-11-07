<?php

use App\Http\Controllers\CollarsController;
use Illuminate\Support\Facades\Route;

Route::post('/', [CollarsController::class, 'store']);
Route::patch('/associate/{pet}/{collar}', [CollarsController::class, 'associatePetToCollar'])->middleware('auth:sanctum');