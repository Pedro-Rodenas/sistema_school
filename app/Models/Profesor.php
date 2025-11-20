<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'direccion',
        'especialidad',
        'fecha_nacimiento',
        'estado'
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
