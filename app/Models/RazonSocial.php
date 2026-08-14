<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RazonSocial extends Model
{
    //
    protected $table = 'razones_sociales';
    protected $fillable = [
        'acronimo'
    ];

    public function empresa() {
        return $this->hasOne(Empresa::class, 'razon_social_id', 'id');
    }

    public function solicitudEmpresa() {
        return $this->hasOne(SolicitudEmpresa::class);
    }
}
