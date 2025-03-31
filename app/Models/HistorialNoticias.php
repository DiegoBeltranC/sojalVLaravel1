<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class HistorialNoticia extends Model
{
    // Define explícitamente el nombre de la colección en MongoDB.
    protected $collection = 'historial_noticias';

    // Indica los campos que se pueden asignar de forma masiva.
    protected $fillable = [
        'titulo',
        'descripcion',
        'url_imagen',
        'id_usuario',
        'likes',
        'fecha_inicio',
        'fecha_fin',
        'updated_at',
        'created_at'
    ];
}
