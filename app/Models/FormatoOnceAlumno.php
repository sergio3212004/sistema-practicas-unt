<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatoOnceAlumno extends Model
{
    //
    protected $table = 'formatos_once_alumno';
    protected $fillable = [
        'formato_once_id',
        'alumno_id',
        'sede_practicas',
        'ciclo_nivel',
        'competencias',
        'capacidades',
        'actividades',
        'producto',
        'conformidad',
        'comentarios'
    ];

    public function formatoOnce() {
        return $this->belongsTo(FormatoOnce::class, 'formato_once_id', 'id');
    }

    public function alumno() {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }
}
