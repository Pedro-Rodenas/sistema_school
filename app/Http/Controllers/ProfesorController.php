<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index()
    {
        /* ============================
              CARGAR SOLO ACTIVOS
        ============================ */
        $profesores = Profesor::where('estado', 'activo')
            ->orderBy('apellido')
            ->get();

        /* ============================
           GRÁFICO 1: ESPECIALIDADES
           (solo activos)
        ============================ */
        $especialidades = Profesor::where('estado', 'activo')
            ->select('especialidad')
            ->groupBy('especialidad')
            ->pluck('especialidad');

        $conteoEspecialidades = Profesor::where('estado', 'activo')
            ->selectRaw('especialidad, COUNT(*) as total')
            ->groupBy('especialidad')
            ->pluck('total');

        /* ============================
           GRÁFICO 2: EDADES
           (solo activos)
        ============================ */
        $rango_20_29 = 0;
        $rango_30_39 = 0;
        $rango_40_49 = 0;
        $rango_50_mas = 0;

        foreach ($profesores as $p) {
            if (!$p->fecha_nacimiento)
                continue;

            $edad = \Carbon\Carbon::parse($p->fecha_nacimiento)->age;

            if ($edad >= 20 && $edad <= 29)
                $rango_20_29++;
            elseif ($edad >= 30 && $edad <= 39)
                $rango_30_39++;
            elseif ($edad >= 40 && $edad <= 49)
                $rango_40_49++;
            elseif ($edad >= 50)
                $rango_50_mas++;
        }

        return view('profesores.index', compact(
            'profesores',
            'especialidades',
            'conteoEspecialidades',
            'rango_20_29',
            'rango_30_39',
            'rango_40_49',
            'rango_50_mas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|unique:profesores',
            'email' => 'required|email|unique:profesores',
        ]);

        $data = $request->all();
        $data['estado'] = 'activo'; // por defecto

        Profesor::create($data);

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $profesor = Profesor::findOrFail($id);

        $request->validate([
            'dni' => "required|unique:profesores,dni,$id",
            'email' => "required|email|unique:profesores,email,$id",
        ]);

        $profesor->update($request->all());

        return redirect()->route('profesores.index')
            ->with('success', 'Datos del profesor actualizados.');
    }

    public function cambiarEstado($id)
    {
        $profesor = Profesor::findOrFail($id);

        $profesor->estado = $profesor->estado === 'activo' ? 'inactivo' : 'activo';
        $profesor->save();

        return response()->json(['ok' => true]);
    }

    public function filtrar($estado)
    {
        return Profesor::where('estado', $estado)
            ->orderBy('apellido')
            ->get();
    }
}
