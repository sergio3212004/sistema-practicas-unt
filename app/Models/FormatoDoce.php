<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatoDoce extends Model
{
    //
    protected $table = 'formatos_doce';
    protected $fillable = [
        'aula_id',
        'firma_coordinador',
    ];

    public function aula() {
        return $this->belongsTo(Aula::class, 'aula_id', 'id');
    }

    public function formatosDoceAlumnos() {
        return $this->hasMany(FormatoDoceAlumno::class, 'formato_doce_id', 'id');
    }
}
