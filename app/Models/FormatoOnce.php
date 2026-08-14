<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatoOnce extends Model
{
    //
    protected $table = 'formatos_once';
    protected $fillable = [
        'aula_id',
        'firma_coordinador',
    ];

    public function aula() {
        return $this->belongsTo(Aula::class, 'aula_id', 'id');
    }

    public function formatoOnceAlumnos() {
        return $this->hasMany(FormatoOnceAlumno::class, 'formato_once_id', 'id');
    }

}
