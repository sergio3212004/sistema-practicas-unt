<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoreoPractica extends Model
{
    //
    protected $table = 'monitoreos_practicas';
    protected $fillable = [
        'cronograma_id',
        'semana_id',
        'alumno_id',
    ];

    public function cronograma() {
        return $this->belongsTo(Cronograma::class, 'cronograma_id', 'id');
    }

    public function semana() {
        return $this->belongsTo(Semana::class, 'semana_id', 'id');
    }

    public function alumno() {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }

    public function monitoreosPracticasActividades() {
        return $this->hasMany(MonitoreoPracticaActividad::class, 'monitoreo_actividad_id', 'id');
    }
}
