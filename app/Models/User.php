<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Notifications\CustomResetPasswordNotification;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'rol_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id');
    }

    public function hasRole(UserRole|string $role): bool
    {
        $roleName = $role instanceof UserRole ? $role->value : $role;

        return $this->rol?->nombre === $roleName;
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class);
    }

    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'user_id', 'id');
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'user_id', 'id');
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class, 'user_id', 'id');
    }

    public function getNombreAttribute()
    {
        if ($this->administrador) {
            return trim($this->administrador->apellido_paterno.' '.$this->administrador->apellido_materno.' '.$this->administrador->nombres);

        }

        if ($this->alumno) {
            return trim($this->alumno->apellido_paterno.' '.$this->alumno->apellido_materno.' '.$this->alumno->nombres);
        }

        if ($this->profesor) {
            return trim($this->profesor->apellido_paterno.' '.$this->profesor->apellido_materno.' '.$this->profesor->nombres);
        }

        if ($this->empresa) {
            return trim($this->empresa->nombre.' '.$this->empresa->razonSocial->acronimo);
        }

        return null;
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
