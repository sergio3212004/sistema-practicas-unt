<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    //
    protected $table = 'alumnos';

    protected $fillable = [
        'codigo_matricula',
        'user_id',
        'aula_id',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'cv',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con aula
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function fichaRegistro()
    {
        return $this->hasOne(FichaRegistro::class, 'alumno_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function fichaActual()
    {
        return $this->hasOne(FichaRegistro::class, 'alumno_id')
            ->latestOfMany();
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class);
    }

    /** @deprecated Use postulaciones(). */
    public function postualaciones(): HasMany
    {
        return $this->postulaciones();
    }

    public function formatoOnceAlumnos()
    {
        return $this->hasMany(FormatoOnceAlumno::class, 'alumno_id', 'id');
    }

    public function formatoDoceAlumnos()
    {
        return $this->hasMany(FormatoDoceAlumno::class, 'alumno_id', 'id');
    }

    public function monitoreosPracticas()
    {
        return $this->hasMany(MonitoreoPractica::class, 'alumno_id', 'id');
    }
}
