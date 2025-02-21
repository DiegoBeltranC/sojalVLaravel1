<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Ruta extends Model
{
    protected $collection = 'rutas';
    protected $fillable = ['nombre', 'puntos','color', 'fechaCreacion'];

    protected $casts = [
        'puntos' => 'array', // Para que los puntos se guarden como un array
        'fechaCreacion' => 'datetime',
    ];
}
