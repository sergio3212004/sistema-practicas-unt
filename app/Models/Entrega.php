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
        'fecha_entrega' => 'datetime'
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
        return !is_null($this->nota);
    }

    // Método helper para verificar si fue entregada a tiempo
    public function fueEntregadaATiempo()
    {
        if (!$this->fecha_entrega) {
            return false;
        }

        return $this->fecha_entrega <= $this->actividad->fecha_limite;
    }

    // Método helper para obtener el estado visual
    public function obtenerEstadoVisual()
    {
        $estados = [
            'pendiente' => ['clase' => 'bg-yellow-100 text-yellow-800', 'texto' => 'Pendiente'],
            'entregado' => ['clase' => 'bg-blue-100 text-blue-800', 'texto' => 'Entregado'],
            'observado' => ['clase' => 'bg-green-100 text-green-800', 'texto' => 'Revisado'],
            'rechazado' => ['clase' => 'bg-red-100 text-red-800', 'texto' => 'Rechazado'],
        ];

        return $estados[$this->estado] ?? ['clase' => 'bg-gray-100 text-gray-800', 'texto' => ucfirst($this->estado)];
    }

}
