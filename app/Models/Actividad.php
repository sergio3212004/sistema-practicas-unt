<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    //
    protected $table = 'actividades';
    protected $fillable = [
        'aula_id',
        'semana_id',
        'tipo_actividad_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_limite'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_limite' => 'datetime',
    ];
    public function tipoActividad() {
        return $this->belongsTo(TipoActividad::class, 'tipo_actividad_id', 'id');
    }

    public function semana() {
        return $this->belongsTo(Semana::class, 'semana_id', 'id');
    }

    public function aula() {
        return $this->belongsTo(Aula::class, 'aula_id', 'id');
    }

    public function entregas() {
        return $this->hasMany(Entrega::class, 'actividad_id', 'id');
    }

    public function estaActiva(): bool
    {
        $now = Carbon::now();

        $inicio = Carbon::parse($this->fecha_inicio);
        $limite = Carbon::parse($this->fecha_limite);

        return $now->between($inicio, $limite, true); // true = inclusive
    }

    public function estaVencida(): bool
    {
        $now = Carbon::now();
        $limite = Carbon::parse($this->fecha_limite);

        return $now->greaterThan($limite);
    }

    // Opcional: si quieres usar "Próxima"
    public function esFutura(): bool
    {
        $now = Carbon::now();
        $inicio = Carbon::parse($this->fecha_inicio);

        return $now->lessThan($inicio);
    }

    public function obtenerProgreso(): array
    {
        // Asegúrate de que la actividad tenga un aula cargada
        if (!$this->relationLoaded('aula')) {
            $this->load('aula');
        }

        // Total de alumnos en el aula
        $totalAlumnos = $this->aula->alumnos()->count();

        // Total de entregas realizadas para esta actividad
        $entregasRealizadas = $this->entregas()->count();

        // Evitar división por cero
        if ($totalAlumnos === 0) {
            return [
                'total' => 0,
                'entregadas' => 0,
                'porcentaje' => 0,
            ];
        }

        $porcentaje = round(($entregasRealizadas / $totalAlumnos) * 100, 1);

        return [
            'total' => $totalAlumnos,
            'entregadas' => $entregasRealizadas,
            'porcentaje' => $porcentaje,
        ];
    }
}
