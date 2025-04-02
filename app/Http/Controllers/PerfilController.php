<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    // Muestra el formulario para cambiar la contraseña
    public function editPassword()
    {
        return view('perfil.change_password');
    }

    // Procesa la actualización de la contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Verifica que la contraseña actual sea correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualiza la contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('perfil.edit')->with('success', 'Contraseña actualizada correctamente.');
    }
}
