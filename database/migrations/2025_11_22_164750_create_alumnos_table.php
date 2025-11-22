<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 15)->unique();
            $table->string('nombre');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');

            // correo institucional generado por dni (dni@speciaschool.com)
            $table->string('correo_institucional')->unique();

            // estado: activo/inactivo
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // sugerencia extra
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
