<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaRegistro extends Model
{
    //
    protected $table = 'fichas_registro';
    protected $fillable = [
        // Alumno
        'alumno_id',
        'ciclo',
        'semestre_id',
        // Empresa
        'razon_social',
        'ruc',
        'correo_empresa',
        'nombre_gerente',
        'nombre_jefe_rrhh',
        'direccion',
        'telefono_fijo',
        'telefono_movil',
        'departamento',
        'provincia',
        'distrito',
        'fecha_inicio',
        'fecha_termino',
        'descripcion',
        'area_practicas',
        'cargo',
        'nombre_jefe_directo',
        'telefono_jefe_directo',
        'correo_jefe_directo',
        'firma_empresa',
        'firma_programa',
        'firma_practicante',
        'aceptado'
    ];

    /* -------------------------------------
  | RELACIONES PRINCIPALES
  ------------------------------------- */

    // Alumno dueño de la ficha
    public function alumno()
    {
        return $this->belongsTo(\App\Models\Alumno::class, 'alumno_id');
    }

    // Semestre al que pertenece
    public function semestre()
    {
        return $this->belongsTo(\App\Models\Semestre::class, 'semestre_id');
    }

    // Horarios normalizados (lunes-sábado)
    public function horarios()
    {
        return $this->hasMany(FichaRegistroHorario::class, 'ficha_registro_id')
            ->orderBy('dia_semana', 'asc')
            ->orderBy('hora_inicio', 'asc');
    }

    public function cronograma() {
        return $this->hasOne(Cronograma::class, 'ficha_id');
    }

    public function firmaTokens()
    {
        return $this->hasMany(\App\Models\FirmaToken::class);
    }
    /* -------------------------------------
    | MUTADORES / CASTS
    ------------------------------------- */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];
}
