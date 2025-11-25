<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ... (Indicadores principales, Top Profesores y Próximos Cursos existentes) ...

        $totalCursos = Curso::count();
        $totalAlumnos = Alumno::count();
        $totalProfes = Profesor::count();

        // Top 5 Profesores
        $topProfesores = Profesor::withCount([
            'cursos' => function ($query) {
                $query->where('estado', 'activo');
            }
        ])
            ->orderBy('cursos_count', 'desc')
            ->take(5)
            ->get();

        // Top 5 Cursos Populares
        $topCursosPopulares = Curso::withCount('alumnos')
            ->where('estado', 'activo')
            ->orderBy('alumnos_count', 'desc')
            ->take(5)
            ->get();

        // Próximos Cursos
        $proximosCursos = Curso::where('estado', '!=', 'finalizado')
            ->where('fecha_inicio', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->with('profesor')
            ->take(5)
            ->get();

        // 🔔 NUEVA LÓGICA GRÁFICO 1: Alumnos por Estado
        $alumnosPorEstado = Alumno::select('estado', DB::raw('count(*) as count'))
            ->groupBy('estado')
            ->pluck('count', 'estado');

        $chartEstadoLabels = $alumnosPorEstado->keys();
        $chartEstadoData = $alumnosPorEstado->values();

        // 🔔 NUEVA LÓGICA GRÁFICO 2: Cursos por Nivel
        $cursosPorNivel = Curso::select('nivel', DB::raw('count(*) as count'))
            ->groupBy('nivel')
            ->orderBy('count', 'desc')
            ->pluck('count', 'nivel');

        $chartNivelLabels = $cursosPorNivel->keys();
        $chartNivelData = $cursosPorNivel->values();


        return view('dashboard.index', compact(
            'totalCursos',
            'totalAlumnos',
            'totalProfes',
            'topProfesores',
            'topCursosPopulares',
            'proximosCursos',
            // NUEVAS VARIABLES PARA GRÁFICOS
            'chartEstadoLabels',
            'chartEstadoData',
            'chartNivelLabels',
            'chartNivelData'
        ));
    }
}