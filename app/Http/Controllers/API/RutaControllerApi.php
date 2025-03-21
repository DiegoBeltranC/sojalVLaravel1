<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Ruta;
use Carbon\Carbon;

use Illuminate\Http\Request;

class RutaControllerApi extends Controller
{
    public function index()
    {
        $rutas = Ruta::all();
        return response()->json($rutas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'color' => 'required|string',
            'puntos' => 'required|array|min:2', // La ruta debe tener al menos 2 puntos
            'puntos.*' => 'array|min:2', // Cada punto debe ser un array con latitud y longitud
        ]);

        // Guardar la ruta en MongoDB
        $ruta = Ruta::create([
            'nombre' => $request->nombre,
            'color' => $request->color,
            'puntos' => $request->puntos, // No es necesario json_encode()
        ]);

        return response()->json($ruta, 201);

        
    }

    public function destroy($id){
        $ruta = Ruta::find($id);
        if (!$ruta) {
            return response()->json(['success' => false, 'message' => 'Ruta no encontrada'], 404);
        }
        $ruta->delete();

        return response()->json(['success' => true, 'message' => 'Ruta eliminada correctamente']);
    }
}
