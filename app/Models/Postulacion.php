<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    //
    protected $table = 'postulaciones';
    protected $fillable = [
        'alumno_id',
        'aprobado', // null = pendiente, false = rechazado, true = aprobado
        'publicacion_id',
    ];

    public function alumno() {
        return $this->belongsTo(Alumno::class);
    }

    public function publicacion() {
        return $this->belongsTo(Publicacion::class, 'publicacion_id', 'id');
    }
}
