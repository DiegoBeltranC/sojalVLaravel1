<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TrabajadorController extends Controller
{
    public function data()
    {
        // Filtra los usuarios cuyo rol sea 'trabajador'
        $trabajadores = User::where('rol', 'trabajador')->get()->map(function($user) {
            return [
                // Convertimos el _id a string para facilitar su uso en la vista
                'id'       => (string)$user->_id,
                'nombre'   => $user->nombre,
                // Suponiendo que el campo 'apellidos' es un objeto con 'paterno' y 'materno'
                'apellidos'=> $user->apellidos,
                'correo'   => $user->correo,
                'telefono' => $user->telefono,
                // Agrega otros campos si lo requieres
            ];
        });

        return response()->json(['data' => $trabajadores]);
    }
}
