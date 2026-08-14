<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmaToken extends Model
{
    //
    protected $table = 'firma_tokens';

    protected $fillable = [
        'ficha_registro_id',
        'contexto',
        'email',
        'tipo',
        'token',
        'expires_at',
        'signed_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'signed_at' => 'datetime',
    ];

    public function ficha()
    {
        return $this->belongsTo(FichaRegistro::class, 'ficha_registro_id');
    }


    // Helpers
    public function estaVencido(): bool
    {
        return $this->expires_at->isPast();
    }

    public function estaFirmado(): bool
    {
        return !is_null($this->signed_at);
    }

    public function puedeSerFirmado(): bool
    {
        return !$this->estaVencido() && !$this->estaFirmado();
    }
}
