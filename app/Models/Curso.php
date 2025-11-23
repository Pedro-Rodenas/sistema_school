<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'stock_alumnos',
        'temas_semanales',
        'fecha_inicio',
        'fecha_fin',
        'nivel',
        'grado',
        'aula',
        'horario',
        'profesor_id',
        'estado',
    ];

    protected $casts = [
        'temas_semanales' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Relación con profesor
    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    // Relación con alumnos (Muchos a Muchos)
    public function alumnos()
    {
        return $this->belongsToMany(\App\Models\Alumno::class, 'alumno_curso')
            ->withTimestamps();
    }
}
