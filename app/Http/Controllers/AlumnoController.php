<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Carbon\Carbon; // Importación necesaria para usar Carbon::parse() y calcular edad/mes

class AlumnoController extends Controller
{
    /**
     * Muestra la lista de alumnos activos y calcula los datos para gráficos.
     */
    public function index()
    {
        // 1. Obtener todos los alumnos para los cálculos estadísticos
        $todosAlumnos = Alumno::all();

        // 2. Filtrar la lista de la tabla para mostrar solo activos por defecto
        $alumnos = $todosAlumnos->where('estado', 'activo');

        // 3. CALCULAR DATOS PARA GRÁFICOS
        $conteoPorEdad = $this->calcularConteoPorEdad($todosAlumnos);
        $conteoPorMes = $this->calcularConteoPorMes($todosAlumnos);

        // 4. Pasar todos los datos a la vista
        return view('alumnos.index', compact('alumnos', 'conteoPorEdad', 'conteoPorMes'));
    }

    /**
     * Calcula la edad de los alumnos y los agrupa por edad.
     */
    private function calcularConteoPorEdad($alumnos)
    {
        return $alumnos->map(function ($alumno) {
            if ($alumno->fecha_nacimiento) {
                return Carbon::parse($alumno->fecha_nacimiento)->age;
            }
            return null;
        })
            ->filter() // Eliminar entradas nulas (sin fecha de nacimiento)
            ->groupBy(function ($age) {
                return $age;
            })
            ->map(function ($items) {
                return $items->count(); // Contar cuántos alumnos hay por cada edad
            })
            ->sortKeys() // Ordenar por la clave (la edad)
            ->toArray();
    }

    /**
     * Calcula el conteo de alumnos agrupados por mes de nacimiento.
     */
    private function calcularConteoPorMes($alumnos)
    {
        $meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];

        $datosMes = $alumnos->map(function ($alumno) {
            if ($alumno->fecha_nacimiento) {
                // Obtenemos el número del mes (1 a 12)
                return Carbon::parse($alumno->fecha_nacimiento)->month;
            }
            return null;
        })
            ->filter()
            ->groupBy(function ($month) {
                return $month;
            })
            ->map(function ($items) {
                return $items->count();
            });

        // Aseguramos que todos los 12 meses estén presentes, rellenando con 0 si es necesario
        $conteoFinal = [];
        foreach ($meses as $num => $nombre) {
            $conteoFinal[$nombre] = $datosMes->get($num, 0);
        }

        return $conteoFinal;
    }

    // --------------------------------------------------------------------------------
    // MÉTODOS DE FILTRADO Y CRUD
    // --------------------------------------------------------------------------------

    /**
     * Retorna una lista de alumnos filtrada por estado para peticiones AJAX.
     */
    public function filtrar($estado)
    {
        return Alumno::where('estado', $estado)
            ->orderBy('apellidos')
            ->get();
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|unique:alumnos',
            'nombre' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required|date',
            'estado' => 'required',
        ]);

        $correo = $request->dni . '@speciaschool.com';

        Alumno::create([
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'correo_institucional' => $correo,
            'estado' => $request->estado,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }

    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'dni' => 'required|unique:alumnos,dni,' . $alumno->id,
            'nombre' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required|date',
            'estado' => 'required',
        ]);

        // generar nuevamente el correo por si se cambia el DNI
        $correo = $request->dni . '@speciaschool.com';

        $alumno->update([
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'correo_institucional' => $correo,
            'estado' => $request->estado,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }

    public function cambiarEstado($id)
    {
        $alumno = Alumno::findOrFail($id);

        $alumno->estado = $alumno->estado === 'activo' ? 'inactivo' : 'activo';
        $alumno->save();

        return response()->json(['ok' => true]);
    }
}