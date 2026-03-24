<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectorioController;

Route::get('/', [DirectorioController::class, 'index'])->name('directorio.index');
Route::get('/oficina/{subArea}', [DirectorioController::class, 'showSubArea'])->name('directorio.subarea');
