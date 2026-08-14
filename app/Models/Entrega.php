<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    //
    protected $fillable = [
        'actividad_id',
        'alumno_id',
        'ruta',
        'estado',
        'nota',
        'observaciones',
        'fecha_entrega',
    ];

    protected $casts = [
        'fecha_entrega' => 'datetime',
    ];

    // Relación con Actividad
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    // Relación con Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    // Método helper para verificar si está calificada
    public function estaCalificada()
    {
        return ! is_null($this->nota);
    }

    // Método helper para verificar si fue entregada a tiempo
    public function fueEntregadaATiempo()
    {
        if (! $this->fecha_entrega) {
            return false;
        }

        return $this->fecha_entrega <= $this->actividad->fecha_limite;
    }
}
