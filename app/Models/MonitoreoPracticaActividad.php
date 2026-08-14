<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoreoPracticaActividad extends Model
{
    //
    protected $table = 'monitoreos_practicas_actividades';
    protected $fillable = [
        'monitoreo_practica_id',
        'cronograma_actividad_id',
        'al_dia', //  boolean
        'observacion',
        'firma_practicante',
        'firma_supervisor'
    ];

    public function cronogramaActividad() {
        return $this->belongsTo(CronogramaActividad::class, 'cronograma_actividad_id', 'id');
    }

    public function monitoreoPractica() {
        return $this->belongsTo(MonitoreoPractica::class, 'monitoreo_practica_id', 'id');
    }
}
