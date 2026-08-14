<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    //
    protected $fillable = [
        'ficha_id',
        'firma_practicante',
        'firma_jefe_directo',
        'firma_profesor',
        'calificacion'
    ];

    public function fichaRegistro()
    {
        return $this->belongsTo(FichaRegistro::class, 'ficha_id');
    }

    public function actividades()
    {
        return $this->hasMany(\App\Models\CronogramaActividad::class, 'cronograma_id');
    }


    // Helpers útiles
    public function estaFirmadoCompleto(): bool
    {
        return !empty($this->firma_practicante)
            && !empty($this->firma_jefe_directo)
            && !empty($this->firma_profesor);
    }

    public function estaPendienteFirmaJefe(): bool
    {
        return empty($this->firma_jefe_directo);
    }

    public function estaPendienteFirmaProfesor(): bool
    {
        return empty($this->firma_profesor);
    }

    public function tokensFirma()
    {
        return $this->hasOne(FirmaTokenCronograma::class);
    }

    public function tokenProfesor()
    {
        return $this->hasOne(FirmaTokenCronograma::class)
            ->where('rol', 'profesor');
    }

    public function estaCalificado(): bool
    {
        return $this->calificacion !== null;
    }

    public function puedeSerCalificado(): bool
    {
        return $this->estaFirmadoCompleto() && !$this->estaCalificado();
    }

    public function monitoreosPracticas() {
        return $this->hasMany(MonitoreoPractica::class, 'cronograma_id', 'id');
    }
}
