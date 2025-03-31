<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $collection = 'users';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'password',
        'rol',
        'telefono',
        'fecha_nacimiento',
        'curp',
        'rfc',
        'profile_picture',
        'fecha_creacion'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // MongoDB usa _id como clave primaria por defecto
    protected $primaryKey = '_id';
}
