<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reporte extends Model
{
    // Nombre de la colección en MongoDB
    protected $collection = 'reportes';

    // Si deseas especificar la conexión (opcional si ya la defines globalmente)
    // protected $connection = 'mongodb';

    // Atributos asignables
    protected $fillable = [
        'idUsuario',
        'descripcion',
        'location',
        'calles',
        'colonias',
        'status',
        'conjunto',
        'cruzamientos',
        'fechaCreacion',
    ];

    // Castings para convertir atributos a tipos nativos
    protected $casts = [
        'location'      => 'array',    // { latitud, longitud }
        'calles'        => 'array',    // { idCalle, nombre }
        'colonias'      => 'array',    // { idColonia, colonia }
        'cruzamientos'  => 'array',    // Array de cadenas
        'fechaCreacion' => 'datetime', // Se convertirá a instancia de Carbon
    ];
}
