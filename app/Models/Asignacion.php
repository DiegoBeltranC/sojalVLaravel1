<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\User;
use App\Models\Ruta;
use App\Models\Truck;
use App\Casts\ObjectIdCast;

class Asignacion extends Model
{
    protected $collection = 'asignacions';

    protected $fillable = [
        'idUsuario',
        'idRuta',
        'idCamion',
        'nombreUsuario',
        'nombreRuta',
        'placasCamion',
        'nombre'
    ];

    protected $casts = [
        'idUsuario' => ObjectIdCast::class,
        'idRuta'    => ObjectIdCast::class,
        'idCamion'  => ObjectIdCast::class,
    ];


    // Si deseas que al convertir a JSON se incluyan también los atributos calculados
    protected $appends = ['nombre_usuario', 'nombre_ruta', 'placas_camion'];

    /**
     * Relación con el modelo User.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', '_id');
    }

    /**
     * Relación con el modelo Ruta.
     */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'idRuta', '_id');
    }

    /**
     * Relación con el modelo Truck.
     */
    public function camion()
    {
        return $this->belongsTo(Truck::class, 'idCamion', '_id');
    }

    /**
     * Accesor para obtener el nombre del usuario.
     */
    public function getNombreUsuarioAttribute()
    {
        return $this->usuario ? $this->usuario->nombre : $this->attributes['nombreUsuario'] ?? null;
    }

    /**
     * Accesor para obtener el nombre de la ruta.
     */
    public function getNombreRutaAttribute()
    {
        return $this->ruta ? $this->ruta->nombre : $this->attributes['nombreRuta'] ?? null;
    }

    /**
     * Accesor para obtener las placas del camión.
     */
    public function getPlacasCamionAttribute()
    {
        return $this->camion ? $this->camion->plates : $this->attributes['placasCamion'] ?? null;
    }

    /**
     * Evento para asignar automáticamente los datos redundantes y generar el nombre de la asignación.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($asignacion) {
            $usuario = User::find($asignacion->idUsuario);
            $ruta = Ruta::find($asignacion->idRuta);
            $camion = Truck::find($asignacion->idCamion);

            $asignacion->nombreUsuario = $usuario ? $usuario->nombre : null;
            $asignacion->apellidoPaterno = $usuario ? $usuario->apellidos['paterno'] : null;
            $asignacion->apellidoMaterno = $usuario ? $usuario->apellidos['materno'] : null;
            $asignacion->telefono = $usuario ? $usuario->telefono : null;
            $asignacion->nombreRuta = $ruta ? $ruta->nombre : null;
            $asignacion->placasCamion = $camion ? $camion->plates : null;

            // Construir el nombre completo del trabajador
            if ($usuario) {
                // Se concatena el nombre y los apellidos, asegurando espacios adecuados
                $nombreCompleto = trim($usuario->nombre . ' ' . ($usuario->apellidos['paterno'] ?? '') . ' ' . ($usuario->apellidos['materno'] ?? ''));
            } else {
                $nombreCompleto = 'SIN_USUARIO';
            }

            // Valores por defecto en caso de que no se encuentren la ruta o el camión
            $rutaNombre = $ruta ? $ruta->nombre : 'SIN_RUTA';
            $camionPlacas = $camion ? $camion->plates : 'SIN_CAMION';

            // Construir el nombre de la asignación con el formato deseado
            // Ejemplo: "Juan Pérez (Ruta Central - ABC123)"
            $asignacion->nombre = "{$nombreCompleto} ({$rutaNombre} - {$camionPlacas})";
        });

    }

}



