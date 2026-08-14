<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaRegistroHorario extends Model
{
    //
    protected $table = 'fichas_registro_horarios';

    protected $fillable = [
        'ficha_registro_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin'
    ];

    /* -------------------------------------
    | RELACIÓN CON FICHA
    ------------------------------------- */

    public function ficha()
    {
        return $this->belongsTo(FichaRegistro::class, 'ficha_registro_id');
    }

    /* -------------------------------------
    | MUTADORES
    ------------------------------------- */

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'dia_semana' => 'integer',
    ];

    /* -------------------------------------
    | ACCESORES ÚTILES
    ------------------------------------- */

    public function getNombreDiaAttribute()
    {
        return [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ][$this->dia_semana] ?? 'Desconocido';
    }

}
