<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoActividad extends Model
{
    //
    protected $table = 'tipos_actividad';
    protected $fillable = [
        'nombre', // Reporte, Informe de unidad, Informe Final
        'modo_entrega'
    ];

    public function actividad() {
        return $this->hasMany(Actividad::class, 'tipo_actividad_id', 'id');
    }

}
