<?php

namespace App\Casts;

use MongoDB\BSON\ObjectId;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ObjectIdCast implements CastsAttributes
{
    /**
     * Convierte el valor almacenado en la base de datos a un string para la aplicación.
     */
    public function get($model, string $key, $value, array $attributes)
    {
        // Si el valor es un ObjectId, lo convertimos a string.
        return $value instanceof ObjectId ? (string)$value : $value;
    }

    /**
     * Convierte el valor que proviene de la aplicación en un ObjectId.
     */
    public function set($model, string $key, $value, array $attributes)
    {
        // Si ya es un ObjectId, lo dejamos, si no, lo convertimos.
        if (!$value instanceof ObjectId) {
            try {
                $value = new ObjectId($value);
            } catch (\Exception $e) {
                // Opcional: maneja el error o asigna null
                $value = null;
            }
        }
        return $value;
    }
}
