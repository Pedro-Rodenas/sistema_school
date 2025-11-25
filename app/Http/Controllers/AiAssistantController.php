<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Profesor;

class AiAssistantController extends Controller
{
    public function processQuery(Request $request)
    {
        $query = $request->input('query');

        // Lógica simple: buscar coincidencias y devolver conteos
        $response = $this->handleDatabaseQuery($query);

        if ($response) {
            return response()->json([
                'response' => "DEBUG OK: [Respuesta de DB] -> {$response}"
            ], 200);
        }

        return response()->json([
            'response' => 'No puedo procesar esa pregunta. Intenta preguntar por el conteo de alumnos, profesores o cursos.'
        ], 200);
    }

    /**
     * Lógica que interpreta preguntas sobre la BD
     */
    protected function handleDatabaseQuery(string $query)
    {
        $query = strtolower($query);

        /* =====================================================
           1. CANTIDADES (estudiantes / profesores / cursos)
           ===================================================== */
        if (str_contains($query, 'alumnos') && (str_contains($query, 'cuantos') || str_contains($query, 'cantidad'))) {
            return "Hay " . Alumno::count() . " alumnos registrados.";
        }

        if (str_contains($query, 'profesores') && (str_contains($query, 'cuantos') || str_contains($query, 'cantidad'))) {
            return "Hay " . Profesor::count() . " profesores registrados.";
        }

        if (str_contains($query, 'cursos') && (str_contains($query, 'cuantos') || str_contains($query, 'cantidad'))) {
            return "Hay " . Curso::count() . " cursos registrados.";
        }

        /* =====================================================
           2. CURSO CON MÁS / MENOS ALUMNOS
           ===================================================== */
        if (str_contains($query, 'curso') && str_contains($query, 'mas alumnos')) {

            $curso = Curso::withCount('alumnos')->orderBy('alumnos_count', 'desc')->first();

            if (!$curso)
                return "No hay cursos con alumnos registrados.";

            return "El curso con más alumnos es {$curso->nombre} con {$curso->alumnos_count} alumnos.";
        }

        if (str_contains($query, 'curso') && str_contains($query, 'menos alumnos')) {

            $curso = Curso::withCount('alumnos')->orderBy('alumnos_count', 'asc')->first();

            if (!$curso)
                return "No hay cursos con alumnos registrados.";

            return "El curso con menos alumnos es {$curso->nombre} con {$curso->alumnos_count} alumnos.";
        }

        /* =====================================================
           3. LISTAS (nombres de cursos, alumnos, profesores)
           ===================================================== */
        if (str_contains($query, 'lista') && str_contains($query, 'cursos')) {
            return Curso::pluck('nombre')->implode(', ');
        }

        if (str_contains($query, 'lista') && str_contains($query, 'alumnos')) {
            return Alumno::pluck('nombre')->implode(', ');
        }

        if (str_contains($query, 'lista') && str_contains($query, 'profesores')) {
            return Profesor::pluck('nombre')->implode(', ');
        }

        /* =====================================================
           4. PRIMER / ÚLTIMO CURSO POR FECHA
           ===================================================== */
        if (str_contains($query, 'primer') && str_contains($query, 'curso')) {

            $curso = Curso::orderBy('created_at', 'asc')->first();

            if (!$curso)
                return "No hay cursos registrados.";

            return "El primer curso creado fue {$curso->nombre} el {$curso->created_at->format('d/m/Y')}.";
        }

        if (str_contains($query, 'ultimo') && str_contains($query, 'curso')) {

            $curso = Curso::orderBy('created_at', 'desc')->first();

            if (!$curso)
                return "No hay cursos registrados.";

            return "El curso más reciente es {$curso->nombre} creado el {$curso->created_at->format('d/m/Y')}.";
        }

        /* =====================================================
           5. INFORMACIÓN POR NOMBRE
           ===================================================== */
        // Ejemplos del user:
        // "cuantos alumnos tiene el curso matemáticas"
        // "alumnos del curso programacion"
        foreach (Curso::all() as $curso) {
            if (str_contains($query, $curso->nombre)) {

                $count = $curso->alumnos()->count();

                if (str_contains($query, 'cuantos') || str_contains($query, 'cantidad')) {
                    return "El curso {$curso->nombre} tiene {$count} alumnos.";
                }

                if (str_contains($query, 'alumnos')) {
                    $nombres = $curso->alumnos->pluck('nombre')->implode(', ') ?: 'No hay alumnos registrados.';
                    return "Alumnos del curso {$curso->nombre}: {$nombres}.";
                }

                return "Información sobre el curso {$curso->nombre}: tiene {$count} alumnos.";
            }
        }

        /* =====================================================
           6. INFORMACIÓN DE ESTADO GENERAL
           ===================================================== */
        if (str_contains($query, 'resumen') || str_contains($query, 'estadisticas')) {

            $alumnos = Alumno::count();
            $prof = Profesor::count();
            $cursos = Curso::count();

            return "📊 Resumen general:
        - Alumnos: {$alumnos}
        - Profesores: {$prof}
        - Cursos: {$cursos}";
        }

        /* =====================================================
           7. Si no se reconoce la consulta
           ===================================================== */
        return null;
    }

}
