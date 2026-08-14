<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semana extends Model
{
    //
    protected $table = 'semanas';
    protected $fillable = [
        'aula_id',
        'numero',
        'nombre',
    ];

    // Relación con Aula
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    // Relación con Actividades
    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }

    public function monitoreosPracticas() {
        return $this->hasMany(MonitoreoPractica::class, 'semana_id', 'id');
    }
}
