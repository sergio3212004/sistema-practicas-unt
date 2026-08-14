<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    //
    protected $table = 'empresas';

    protected $fillable = [
        'ruc',
        'nombre',
        'user_id',
        'nombre',
        'telefono',
        'departamento',
        'provincia',
        'distrito',
        'direccion',
        'codigo_verificacion',
        'email_verificado',
        'razon_social_id',
        'aprobado',
    ];

    protected function casts(): array
    {
        return [
            'aprobado' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function razonSocial()
    {
        return $this->belongsTo(RazonSocial::class, 'razon_social_id', 'id');
    }

    public function publicaciones(): HasMany
    {
        return $this->hasMany(Publicacion::class, 'empresa_id', 'id');
    }

    /** @deprecated Use publicaciones(). */
    public function publicacion(): HasMany
    {
        return $this->publicaciones();
    }
}
