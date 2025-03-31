<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use MongoDB\Laravel\Eloquent\Model;

class Noticia extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'titulo', 'descripcion', 'url_imagen', 'id_usuario', 'likes', 'fecha_inicio',  'fecha_fin'
    ];
    public function usuario() {
        return $this->belongsTo(User::class, 'id_usuario', '_id');
    }
    

}