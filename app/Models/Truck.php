<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Truck extends Model
{
    protected $collection = 'trucks';

    protected $fillable = [
        'plates',
        'brand',
        'model',
        'status',
        'year',
    ];

    // MongoDB usa _id como clave primaria por defecto
    protected $primaryKey = '_id';
}
