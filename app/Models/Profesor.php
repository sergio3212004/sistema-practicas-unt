<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    //
    protected $table = 'profesores';
    protected $fillable =[
        'codigo_profesor',
        'user_id',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function aulas() {
        return $this->hasMany(Aula::class, 'profesor_id', 'id');
    }

}
