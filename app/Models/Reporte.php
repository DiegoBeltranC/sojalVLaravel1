<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reporte extends Model
{
    protected $collection = 'reportes';

    protected $fillable = [
        'idUsuario',
        'descripcion',
        'location',
        'colonia',    // Corregido de 'colonias' a 'colonia' (string)
        'calle',      // Corregido de 'calles' a 'calle' (string)
        'status',
        'imagenes',   // Agregado para manejar imágenes
        'fechaCreacion',
    ];

    protected $casts = [
        // Decodificar location si está guardado como JSON string
        'location'      => 'string', // Se procesará en el controlador
        'imagenes'      => 'array',  // Asegura que se maneje como un array de imágenes
        'fechaCreacion' => 'datetime',
    ];
    
}
