<?php

use App\Http\Controllers\RegistroPesoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// API: Registro de peso bovino — emisor del evento PesoRegistrado (Patrón Observer)
Route::post('/api/registros-peso', [RegistroPesoController::class, 'store']);
