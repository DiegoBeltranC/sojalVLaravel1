<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Asignacion;
use MongoDB\BSON\ObjectId; // <-- Import the ObjectId class

class UserObserver
{
    public function updated(User $user)
    {
        // Convertir el ID del usuario a ObjectId
        $userIdObject = new ObjectId($user->getKey());

        // Obtener las asignaciones con el idUsuario correspondiente
        Asignacion::where('idUsuario', $userIdObject)->get()->each(function ($asignacion) use ($user) {
            $asignacion->nombreUsuario = $user->nombre;
            $asignacion->apellidoPaterno = $user->apellidos['paterno'] ?? null;
            $asignacion->apellidoMaterno = $user->apellidos['materno'] ?? null;
            $asignacion->telefono = $user->telefono;

            // Reconstruir el nombre completo
            $rutaNombre = $asignacion->ruta ? $asignacion->ruta->nombre : 'SIN_RUTA';
            $camionPlacas = $asignacion->camion ? $asignacion->camion->plates : 'SIN_CAMION';
            $nombreCompleto = trim($user->nombre . ' ' . ($user->apellidos['paterno'] ?? '') . ' ' . ($user->apellidos['materno'] ?? ''));
            $asignacion->nombre = "{$nombreCompleto} ({$rutaNombre} - {$camionPlacas})";

            $asignacion->save();
        });
    }

}
