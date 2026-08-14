<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    //
    protected $table = 'publicaciones';
    protected $fillable = [
        'nombre',
        'cargo',
        'empresa_id',
        'descripcion',
        'estado',
        'imagen',
        'created_at',
        'updated_at'
    ];

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function postulaciones() {
        return $this->hasMany(Postulacion::class, 'publicacion_id', 'id');
    }
}
