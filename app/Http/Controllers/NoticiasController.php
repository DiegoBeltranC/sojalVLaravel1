<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Noticia;

class NoticiasController extends Controller
{
    public function index()
    {
        // Obtiene todas las noticias junto con el usuario relacionado
        $noticias = Noticia::with('usuario')->get();
        return view('adminPages.noticias', compact('noticias'));
    }

    public function show($id)
    {
        $noticia = Noticia::find($id);
        if (!$noticia) {
            return redirect()->route('admin.noticias.index')->with('error', 'Noticia no encontrada');
        }
        return view('adminPages.noticias', compact('noticia'));
    }

    public function store(Request $request)
    {
        // Validar datos, incluyendo la imagen
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'url_imagen'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fecha_inicio' => 'required|date',
            'hora_inicio'  => 'required',
            'fecha_fin'    => 'required|date',
            'hora_fin'     => 'required',
        ]);

        // Procesar la imagen subida
        if ($request->hasFile('url_imagen')) {
            $imagen = $request->file('url_imagen');
            // Genera un nombre único para la imagen
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            // Guarda la imagen en storage/app/public/imagenes_noticias
            $ruta = $imagen->storeAs('imagenes_noticias', $nombreArchivo, 'public');
        } else {
            $ruta = null;
        }

        // Convierte las fechas y horas a formato DateTime usando Carbon
        $fecha_inicio = Carbon::parse($request->fecha_inicio . ' ' . $request->hora_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin . ' ' . $request->hora_fin);

        // Crea la noticia
        Noticia::create([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'url_imagen'   => $ruta, // Guarda la ruta relativa de la imagen
            'id_usuario'   => $request->id_user,
            'likes'        => 0,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin'    => $fecha_fin,
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia registrada con éxito');
    }

    public function update(Request $request, $id)
    {
        $noticia = Noticia::find($id);
        if (!$noticia) {
            return redirect()->route('admin.noticias.index')->with('error', 'Noticia no encontrada');
        }

        $fecha_inicio = Carbon::parse($request->fecha_inicio_update . ' ' . $request->hora_inicio_update);
        $fecha_fin = Carbon::parse($request->fecha_fin_update . ' ' . $request->hora_fin_update);

        // Si se actualiza la imagen, se puede procesar de forma similar al store
        if ($request->hasFile('url_imagen_update')) {
            $imagen = $request->file('url_imagen_update');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $ruta = $imagen->storeAs('imagenes_noticias', $nombreArchivo, 'public');
        } else {
            $ruta = $noticia->url_imagen;
        }

        $noticia->update([
            'titulo'       => $request->titulo_update,
            'descripcion'  => $request->descripcion_update,
            'url_imagen'   => $ruta,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin'    => $fecha_fin,
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia actualizada con éxito');
    }

    public function destroy($id)
    {
        $noticia = Noticia::find($id);
        if (!$noticia) {
            return redirect()->route('admin.noticias.index')->with('error', 'Noticia no encontrada');
        }

        $noticia->delete();
        return redirect()->route('admin.noticias.index')->with('success', 'Noticia eliminada con éxito');
    }

    // Método opcional para obtener una noticia en formato JSON (útil para rellenar el formulario de actualización mediante AJAX)
    public function edit($id)
    {
        $noticia = Noticia::find($id);
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }
        return response()->json($noticia);
    }
}
