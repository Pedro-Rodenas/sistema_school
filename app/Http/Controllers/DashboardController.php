<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $topCursos = Curso::withCount('alumnos')
            ->orderBy('alumnos_count', 'desc')
            ->take(4)
            ->get();

        $totalCursos = Curso::count();
        $totalAlumnos = Alumno::count();
        $totalProfes = Profesor::count();

        $ultimosAlumnos = Alumno::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'topCursos',
            'totalCursos',
            'totalAlumnos',
            'totalProfes',
            'ultimosAlumnos'
        ));
    }

}
