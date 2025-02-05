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
        'foto_perfil',
        'curp',
        'rfc',
        'camiones_asignados',
        'reportes_activos',
        'fecha_creacion'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // MongoDB usa _id como clave primaria por defecto
    protected $primaryKey = '_id';
}
