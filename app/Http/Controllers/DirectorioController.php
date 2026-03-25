<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Especialista;
use App\Models\SubArea;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    public function index()
    {

        $areas = Area::with(['subAreas' => function ($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->get();

        return view('directorio.index', compact('areas'));
    }

    public function showSubArea(SubArea $subArea)
    {

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
    public function showEspecialista($slug)
    {
        $especialista = \App\Models\Especialista::where('slug', $slug)
            ->where('is_visible', true)
            ->with('subArea.area')
            ->firstOrFail();

        return view('directorio.perfil', compact('especialista'));
    }

    public function guardarEvaluacion(Request $request, Especialista $especialista)
    {
        $voto = (int) $request->estrellas; // 1 a 5

        if ($voto < 1 || $voto > 5) return back();

        $especialista->total_estrellas += $voto;
        $especialista->numero_votos += 1;
        $especialista->promedio_rating = $especialista->total_estrellas / $especialista->numero_votos;
        $especialista->save();

        return back()->with('success', '¡Gracias por evaluar nuestra atención!');
    }

    public function qrSubArea(SubArea $subArea)
    {
        // Generamos la URL que el ciudadano escaneará (la vista de la oficina)
        $url = route('directorio.subarea', $subArea->id);

        return view('admin.qr-subarea', [
            'subArea' => $subArea,
            'url' => $url
        ]);
    }

    public function vistaEvaluar($slug)
    {
        // Buscamos al especialista por su slug
        $especialista = Especialista::where('slug', $slug)->firstOrFail();

        // Retornamos la vista de la encuesta
        return view('directorio.evaluar', compact('especialista'));
    }
}
