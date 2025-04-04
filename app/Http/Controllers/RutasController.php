<?php

namespace App\Http\Controllers;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Carbon\Carbon;
use MongoDB\BSON\ObjectId;
use App\Models\Asignacion;

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

    public function destroy($id)
    {
        $ruta = Ruta::find($id);

        if (!$ruta) {
            return response()->json(['success' => false, 'message' => 'Ruta no encontrada'], 404);
        }

        $rutaIdObject = new ObjectId($ruta->getKey());

        // Comprobar si la ruta tiene asignaciones activas
        if (Asignacion::where('idRuta', $rutaIdObject)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la ruta porque tiene asignaciones activas.'
            ], 400);
        }

        $ruta->delete();

        return response()->json(['success' => true, 'message' => 'Ruta eliminada correctamente']);
    }

    public function show($id)
    {
        // Buscar la ruta en la base de datos
        $ruta = Ruta::find($id);

        // Si no existe, devolver error 404
        if (!$ruta) {
            return response()->json(['message' => 'Ruta no encontrada'], 404);
        }

        return response()->json($ruta);
    }


}
