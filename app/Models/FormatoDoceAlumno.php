<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatoDoceAlumno extends Model
{
    //
    protected $table = 'formatos_doce_alumno';
    protected $fillable = [
        'formato_doce_id',
        'alumno_id',
        'nivel', // 'inicial', 'intermedio', 'avanzado'
        'sede_practica',
        'responsable',
        'contacto_responsable',
        'al_dia', // boolean si o no
        'observaciones'
    ];

    public function formatoDoce() {
        return $this->belongsTo(FormatoDoce::class, 'formato_doce_id', 'id');
    }

    public function alumno() {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }
}
