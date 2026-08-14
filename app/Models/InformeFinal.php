<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformeFinal extends Model
{
    //
    protected $table = 'informes_finales';

    protected $fillable = [
        'alumno_id',
        'archivo_pdf',
        'nombre_original',
        'tamanio',
        'semestre_id',
        'fecha_subida'
    ];

    protected $casts = [
        'fecha_subida' => 'datetime',
    ];

    /**
     * Relación con Alumno
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    /**
     * Relación con Semestre
     */
    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    /**
     * Obtener el tamaño formateado
     */
    public function getTamanioFormateadoAttribute()
    {
        $bytes = $this->tamanio;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }
}
