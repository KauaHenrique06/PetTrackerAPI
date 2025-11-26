<?php

use App\Http\Controllers\CollarLocationController;
use App\Http\Controllers\PetDiseasesController;
use Illuminate\Support\Facades\Route;

Route::post('/{collar_id}', [CollarLocationController::class, 'store']);
Route::get('/{pet_id}', [CollarLocationController::class, 'index']);