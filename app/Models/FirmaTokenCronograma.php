<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmaTokenCronograma extends Model
{
    //
    protected $table = 'firma_token_cronogramas';
    protected $fillable = [
        'cronograma_id',
        'email',
        'token',
        'rol',
        'usado_en',
        'expira_en'
    ];

    protected $casts = [
        'usado_en' => 'datetime',
        'expira_en' => 'datetime',
    ];

    /* -------------------------------------
    | RELACIONES
    ------------------------------------- */

    public function cronograma()
    {
        return $this->belongsTo(Cronograma::class);
    }

    /* -------------------------------------
    | SCOPES ÚTILES
    ------------------------------------- */

    public function scopeVigente($query)
    {
        return $query
            ->whereNull('usado_en')
            ->where('expira_en', '>', now());
    }

    public function scopeRol($query, string $rol)
    {
        return $query->where('rol', $rol);
    }

    /* -------------------------------------
    | HELPERS / LÓGICA DE DOMINIO
    ------------------------------------- */

    public function estaUsado(): bool
    {
        return !is_null($this->usado_en);
    }

    public function estaExpirado(): bool
    {
        return $this->expira_en->isPast();
    }

    public function esValido(): bool
    {
        return !$this->estaUsado() && !$this->estaExpirado();
    }

    public function marcarComoUsado(): void
    {
        $this->update([
            'usado_en' => now(),
        ]);
    }
}
