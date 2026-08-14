<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudEmpresa extends Model
{
    //
    protected $table = 'solicitudes_empresa';

    protected $fillable = [
        'ruc',
        'nombre',
        'email',
        'password',
        'razon_social_id',
        'telefono',
        'departamento',
        'provincia',
        'distrito',
        'direccion',
        'email_verificado',
        'codigo_verificacion',
        'estado',
        'motivo_rechazo',
    ];

    protected $hidden = [
        'password',
        'codigo_verificacion',
    ];

    protected function casts(): array
    {
        return [
            'email_verificado' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function isApprovable(): bool
    {
        return $this->estado === 'pendiente' && $this->email_verificado;
    }

    /**
     * Relación con razón social
     */
    public function razonSocial()
    {
        return $this->belongsTo(RazonSocial::class);
    }

    /**
     * Scope para solicitudes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente')
            ->where('email_verificado', true);
    }
}
