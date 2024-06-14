<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TrechoController;

Route::get('/trechos/create', [TrechoController::class, 'create']);
Route::post('/trechos', [TrechoController::class, 'store']);
