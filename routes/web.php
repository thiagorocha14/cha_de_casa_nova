<?php

use App\Http\Controllers\CorController;
use App\Http\Controllers\PresenteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PresenteController::class, 'index']);
Route::get('/admin', [PresenteController::class, 'admin']);
Route::post('/admin/presente', [PresenteController::class, 'store']);
Route::delete('/admin/presente/{presente}', [PresenteController::class, 'destroy']);

Route::post('/presente/comprado', [PresenteController::class, 'comprado']);
Route::post('/presente/nao-comprado', [PresenteController::class, 'naoComprado']);


Route::post('/cor', [CorController::class, 'store']);
Route::delete('/cor/{cor}', [CorController::class, 'destroy']);
