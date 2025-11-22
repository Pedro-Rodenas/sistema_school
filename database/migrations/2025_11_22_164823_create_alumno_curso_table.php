<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumno_curso', function (Blueprint $table) {

            $table->id();

            // LLAVES FORÁNEAS
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('curso_id');

            // FECHAS DE INSCRIPCIÓN (OPCIONAL)
            $table->date('fecha_inscripcion')->nullable();

            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('alumno_id')
                ->references('id')->on('alumnos')
                ->onDelete('cascade'); // Si se elimina el alumno → eliminar relación

            $table->foreign('curso_id')
                ->references('id')->on('cursos')
                ->onDelete('cascade'); // Si se elimina el curso → eliminar relación

            // Para evitar duplicados (un alumno no se asigna dos veces al mismo curso)
            $table->unique(['alumno_id', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumno_curso');
    }
};
