<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronogramaActividad extends Model
{
    //
    protected $table = 'cronograma_actividades';

    protected $fillable = [
        'cronograma_id',
        'actividad',

        'm1_s1','m1_s2','m1_s3','m1_s4', // semana 1, 2, 3,4
        'm2_s1','m2_s2','m2_s3','m2_s4', // 5, 6, 7, 8
        'm3_s1','m3_s2','m3_s3','m3_s4',
        'm4_s1','m4_s2','m4_s3','m4_s4',
    ];

    public function cronograma()
    {
        return $this->belongsTo(Cronograma::class);
    }

    public function monitoreoPracticaActividad() {
        return $this->hasMany(MonitoreoPracticaActividad::class, 'monitoreo_actividad_id', 'id');
    }
}
