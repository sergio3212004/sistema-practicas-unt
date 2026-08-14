<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    //
    protected $table = 'administradores';
    protected $fillable = [
        'user_id',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }

}
