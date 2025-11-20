@extends('layouts.app')

@section('title', 'Profesores')

@section('content')

    <div class="profesores-page">

        <!-- TÍTULO Y ACCIONES -->
        <div class="top-bar">
            <h1>Profesores</h1>

            <div class="actions">
                <div class="search-box">
                    <input type="text" id="buscador" placeholder="Buscar profesor...">
                    <button id="btn-search">Buscar</button>
                </div>

                <div class="toggle-wrapper">
                    <span id="label-estado">Activos</span>

                    <label class="switch">
                        <input type="checkbox" id="switch-estado">
                        <span class="slider round"></span>
                    </label>
                </div>


                <button class="btn-new" id="btn-open-create">Nuevo Profesor</button>
            </div>
        </div>

        <!-- SECCIÓN DE GRÁFICOS -->
        <div class="charts-grid">
            <div class="chart-card">
                <canvas id="chart1"></canvas>
            </div>

            <div class="chart-card">
                <canvas id="chart2"></canvas>
            </div>
        </div>

        <!-- TABLA -->
        <div class="table-container">
            <table class="prof-table" id="tabla-profesores">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Especialidad</th>
                        <th>Fecha Nac.</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($profesores as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->apellido }}</td>
                            <td>{{ $p->nombre }}</td>
                            <td>{{ $p->dni }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->telefono }}</td>
                            <td>{{ $p->direccion }}</td>
                            <td>{{ $p->especialidad }}</td>
                            <td>{{ $p->fecha_nacimiento }}</td>

                            <!-- ACCIONES -->
                            <td>
                                <button class="btn-edit" data-id="{{ $p->id }}" data-nombre="{{ $p->nombre }}"
                                    data-apellido="{{ $p->apellido }}" data-dni="{{ $p->dni }}" data-email="{{ $p->email }}"
                                    data-telefono="{{ $p->telefono }}" data-direccion="{{ $p->direccion }}"
                                    data-especialidad="{{ $p->especialidad }}" data-fecha="{{ $p->fecha_nacimiento }}">
                                    Editar
                                </button>

                                <button class="btn-toggle" data-id="{{ $p->id }}">
                                    {{ $p->estado === 'activo' ? 'Inactivar' : 'Activar' }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @include('profesores.modals.create')
    @include('profesores.modals.edit')

    <script>
        window.profData = {
            especialidades: @json($especialidades),
            conteoEspecialidades: @json($conteoEspecialidades),
            edades: {
                r1: {{ $rango_20_29 }},
                r2: {{ $rango_30_39 }},
                r3: {{ $rango_40_49 }},
                r4: {{ $rango_50_mas }}
                                                                                            }
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/profesores.js') }}"></script>

@endsection