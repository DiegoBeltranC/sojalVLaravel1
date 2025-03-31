<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrador extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre',
        'apellidoP',
        'apellidoM',
        'fechaNacimiento',
        'telefono',
        'correo',
        'curp',
        'rfc',
    ];

    // Si tienes campos ocultos (como password, tokens, etc.)
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
