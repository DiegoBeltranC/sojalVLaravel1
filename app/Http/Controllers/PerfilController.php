<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    // Muestra la previsualización del perfil
    public function show()
    {
        $user = Auth::user();
        return view('perfil.show', compact('user'));
    }

    // Muestra el formulario de edición del perfil
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    // Procesa la actualización del perfil
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'nombre'             => 'required|string|max:255',
            'correo'             => 'required|email|max:255',
            'apellidos.paterno'  => 'required|string|max:255',
            'apellidos.materno'  => 'nullable|string|max:255',
            'curp'               => 'required|string|max:18',
            'rfc'                => 'required|string|max:13',
        ]);

        // Actualiza los datos del usuario
        $user->nombre = $data['nombre'];
        $user->correo = $data['correo'];
        $user->apellidos = [
            'paterno' => $data['apellidos']['paterno'],
            'materno' => $data['apellidos']['materno'] ?? null,
        ];
        $user->curp = $data['curp'];
        $user->rfc = $data['rfc'];

        $user->save();

        // Retornar la vista de configuración directamente
        return view('adminpages.configuracion', compact('user'))
            ->with('success', 'Perfil actualizado correctamente.');
    }

}

