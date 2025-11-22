<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Profesor;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Listar cursos
     */
    public function index()
    {
        $cursos = Curso::with('profesor')->get();
        $profesores = Profesor::all();

        return view('cursos.index', compact('cursos', 'profesores'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $profesores = Profesor::all();
        return view('cursos.create', compact('profesores'));
    }

    /**
     * Registrar curso
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock_alumnos' => 'required|integer|min:0',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'nivel' => 'nullable|string',
            'grado' => 'nullable|string',
            'aula' => 'nullable|string',
            'horario' => 'nullable|string',
            'profesor_id' => 'required|exists:profesores,id',
            'estado' => 'required|in:activo,inactivo'
        ]);

        // Convertir textarea → JSON
        $temas = $request->temas_semanales
            ? json_encode(array_filter(array_map('trim', explode("\n", $request->temas_semanales))))
            : null;

        Curso::create([
            ...$request->except('temas_semanales'),
            'temas_semanales' => $temas
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        $profesores = Profesor::all();

        return view('cursos.edit', compact('curso', 'profesores'));
    }

    /**
     * Actualizar curso
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock_alumnos' => 'required|integer|min:0',
            'temas_semanales' => 'nullable|string', // FIX REAL
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'nivel' => 'nullable|string',
            'grado' => 'nullable|string',
            'aula' => 'nullable|string',
            'horario' => 'nullable|string',
            'profesor_id' => 'required|exists:profesores,id',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $curso = Curso::findOrFail($id);

        // Convertir textarea → JSON
        $temas = $request->temas_semanales
            ? json_encode(array_filter(array_map('trim', explode("\n", $request->temas_semanales))))
            : null;

        $curso->update([
            ...$request->except('temas_semanales'),
            'temas_semanales' => $temas
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente');
    }

    /**
     * Eliminar curso
     */
    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso eliminado correctamente');
    }
}
