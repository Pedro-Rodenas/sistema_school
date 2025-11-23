@extends('layouts.app')

@section('title', 'Alumnos')

@section('content')
    <div class="alumnos-page profesores-page">

        <div class="top-bar">
            <h1>Alumnos</h1>

            <div class="actions">
                <!-- Buscador -->
                <div class="search-box">
                    <input type="text" id="buscador-alumnos" placeholder="Buscar alumno...">
                    <button id="btn-search-alumno">Buscar</button>
                </div>

                <!-- Activo / Inactivo -->
                <div class="toggle-wrapper">
                    <span id="label-estado-alumnos">Activos</span>
                    <label class="switch">
                        <input type="checkbox" id="switch-estado-alumnos">
                        <span class="slider round"></span>
                    </label>
                </div>

                <button class="btn-new" id="btn-open-create-alumno">Nuevo Alumno</button>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="charts-grid">
            <div class="chart-card">
                <canvas id="alumnosChart1"></canvas>
            </div>
            <div class="chart-card">
                <canvas id="alumnosChart2"></canvas>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-container">
            <table class="alumnos-table" id="tabla-alumnos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Correo Inst.</th>
                        <th>Fecha Nac.</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumnos as $a)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ $a->dni }}</td>
                            <td>{{ $a->apellidos }}</td>
                            <td>{{ $a->nombre }}</td>
                            <td>{{ $a->correo_institucional }}</td>
                            <td>{{ $a->fecha_nacimiento }}</td>

                            <td>
                                <span class="badge {{ $a->estado }}">
                                    {{ ucfirst($a->estado) }}
                                </span>
                            </td>

                            <td>
                                <button class="btn-edit-alumno" data-id="{{ $a->id }}" data-dni="{{ $a->dni }}"
                                    data-apellidos="{{ $a->apellidos }}" data-nombre="{{ $a->nombre }}"
                                    data-nacimiento="{{ $a->fecha_nacimiento }}" data-correo="{{ $a->correo_institucional }}"
                                    data-estado="{{ $a->estado }}">
                                    Editar
                                </button>

                                <button class="btn-toggle" data-id="{{ $a->id }}">
                                    {{ $a->estado === 'activo' ? 'Inactivar' : 'Activar' }}
                                </button>
                                <button class="btn-assign-cursos" data-id="{{ $a->id }}">
                                    Asignar Cursos
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('alumnos.modals.create')
    @include('alumnos.modals.edit')
    @include('alumnos.modals.assign-cursos')

    <script>
        window.alumnoData = {
            conteoPorEdad: @json($conteoPorEdad ?? []),
            conteoPorMes: @json($conteoPorMes ?? [])
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/alumnos.js') }}"></script>

@endsection