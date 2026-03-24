<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\SubArea;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    public function index() {

        $areas = Area::with(['subAreas' => function($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->get();

        return view('directorio.index', compact('areas'));

    }

    public function showSubArea(SubArea $subArea)
    {
        // Si la subárea está inactiva, lanzamos un error 404
        if (!$subArea->is_active) {
            abort(404);
        }

        // Cargamos los especialistas de esta área que sean visibles,
        // ordenados por su campo "orden" y luego alfabéticamente.
        $subArea->load(['especialistas' => function ($query) {
            $query->where('is_visible', true)
                  ->orderBy('orden', 'asc')
                  ->orderBy('nombre_completo', 'asc');
        }, 'area']);

        return view('directorio.subarea', compact('subArea'));
    }
}
