<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectorioController;

Route::get('/', [DirectorioController::class, 'index'])->name('directorio.index');
Route::get('/oficina/{subArea}', [DirectorioController::class, 'showSubArea'])->name('directorio.subarea');
Route::get('/v/{slug}', [DirectorioController::class, 'showEspecialista'])->name('directorio.perfil');
Route::get('/admin/qr-general', function () {
    return view('admin.qr-general');
})->middleware('auth'); // Solo si estás logueado en el panel
Route::get('/evaluar/{especialista:slug}', [DirectorioController::class, 'vistaEvaluar'])->name('directorio.evaluar');
Route::post('/evaluar/{especialista}', [DirectorioController::class, 'guardarEvaluacion'])->name('directorio.votar');
Route::get('/admin/subarea/{subArea}/qr', [DirectorioController::class, 'qrSubArea'])
    ->name('directorio.subarea.qr')
    ->middleware('auth');
// Mostrar el formulario (GET)
Route::get('/evaluar/{especialista:slug}', [DirectorioController::class, 'vistaEvaluar'])->name('directorio.evaluar');

// Procesar el voto (POST)
Route::post('/evaluar/{especialista}', [DirectorioController::class, 'guardarEvaluacion'])->name('directorio.votar');
