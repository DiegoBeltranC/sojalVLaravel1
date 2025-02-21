<?php

namespace App\Http\Controllers;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RutasController extends Controller
{
    public function index()
    {
        return view('adminPages.trayectos');
    }

    public function getRutas()
    {
        // Obtener todas las rutas
        $rutas = Ruta::all();

        // Retornar como JSON
        return response()->json($rutas);
    }

    public function store(Request $request)
    {
        // Validar los datos
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
            'fechaCreacion' => Carbon::now(), // MongoDB usa formato ISODate()
        ]);

        return response()->json(['message' => 'Ruta creada con éxito', 'ruta' => $ruta], 201);
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
