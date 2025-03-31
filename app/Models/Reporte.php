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
        'colonia',
        'calle',
        'cruzamientos',   // Agregado
        'referencias',    // Agregado
        'imagenes',
        'conjunto',
        'status',
        'fechaCreacion',
    ];

    protected $casts = [
        'location'      => 'string', // Se procesa en el controlador si es necesario
        'imagenes'      => 'array',  // Se manejará como array de imágenes
        'fechaCreacion' => 'datetime',
    ];
}

