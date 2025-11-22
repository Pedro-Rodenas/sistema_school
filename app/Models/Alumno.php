<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'dni',
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'correo_institucional',
        'estado',
        'telefono',
        'direccion',
    ];

    // Relación muchos a muchos con cursos
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'alumno_curso')
            ->withTimestamps();
    }
}
