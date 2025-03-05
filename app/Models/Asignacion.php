<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\User;
use App\Models\Truck;
use App\Models\Ruta;
class Asignacion extends Model
{
    protected $collection = 'asignacion';

    // Atributos asignables
    protected $fillable = [
        'idUsuario',
        'idRuta',
        'idCamion'
    ];

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
     * Relación con el modelo Camion.
     */
    public function camion()
    {
        return $this->belongsTo(Truck::class, 'idCamion', '_id');
    }

    public function getNombreUsuarioAttribute()
    {
        return $this->usuario ? $this->usuario->nombre : null;
    }

    /**
     * Accesor para obtener el nombre de la ruta relacionada.
     */
    public function getNombreRutaAttribute()
    {
        return $this->ruta ? $this->ruta->nombre : null;
    }

    /**
     * Accesor para obtener las placas del camión relacionado.
     */
    public function getPlacasCamionAttribute()
    {
        return $this->camion ? $this->camion->plates : null;
    }
}
