<?php

namespace App\Observers;

use App\Models\Truck;
use App\Models\Asignacion;
use MongoDB\BSON\ObjectId; // <-- Import the ObjectId class

class TruckObserver
{
    public function updated(Truck $camion)
    {
        $truck = new ObjectId($camion->getKey());
        // Actualizar las asignaciones que tienen este idCamion
        Asignacion::where('idCamion', $truck)->get()->each(function ($asignacion) use ($camion) {
            $asignacion->placasCamion = $camion->plates;

            // Reconstruir el nombre completo usando los datos actuales del usuario y ruta
            $usuario = $asignacion->usuario;
            $rutaNombre = $asignacion->ruta ? $asignacion->ruta->nombre : 'SIN_RUTA';
            $nombreCompleto = $usuario
                ? trim($usuario->nombre . ' ' . ($usuario->apellidos['paterno'] ?? '') . ' ' . ($usuario->apellidos['materno'] ?? ''))
                : 'SIN_USUARIO';
            $asignacion->nombre = "{$nombreCompleto} ({$rutaNombre} - {$camion->plates})";

            $asignacion->save();
        });
    }
}