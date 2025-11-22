<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            // Datos del curso
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            // Límite de alumnos
            $table->integer('stock_alumnos')->default(0);

            // Lista de temas semanales (JSON)
            $table->json('temas_semanales')->nullable();

            // Duración del curso
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            // Datos académicos
            $table->string('nivel')->nullable();   // Primaria, Secundaria, etc.
            $table->string('grado')->nullable();   // 1°, 2°, 3°, etc.
            $table->string('aula')->nullable();

            // Horario del curso (texto libre)
            $table->string('horario')->nullable();

            // Relación con profesor (1:N)
            $table->foreignId('profesor_id')
                ->constrained('profesores')
                ->onDelete('cascade');

            // Estado del curso
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
