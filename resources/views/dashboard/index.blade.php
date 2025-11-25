@extends('layouts.app')

@section('content')
    <div class="dashboard-container">

        <div class="cards-indicadores">
            <div class="card-ind">
                <i class="fa-solid fa-book"></i>
                <span class="title">Cursos</span>
                <span class="value">{{ $totalCursos }}</span>
            </div>

            <div class="card-ind">
                <i class="fa-solid fa-user-graduate"></i>
                <span class="title">Alumnos</span>
                <span class="value">{{ $totalAlumnos }}</span>
            </div>

            <div class="card-ind">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span class="title">Profesores</span>
                <span class="value">{{ $totalProfes }}</span>
            </div>
        </div>

        <div class="widget top-profesores">
            <h3>Top 5 Profesores con Más Cursos</h3>
            <ul class="lista-alumnos">
                @foreach ($topProfesores as $profesor)
                    <li class="alumno-item">
                        <div class="avatar">{{ substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1) }}</div>
                        <div>
                            <span style="display:block; font-size: 14px;">{{ $profesor->nombre }}
                                {{ $profesor->apellido }}</span>
                            <span style="font-size: 12px; color: var(--txt-muted);">{{ $profesor->especialidad }}</span>
                        </div>
                        <span class="tiempo" style="font-weight: 700;">{{ $profesor->cursos_count }} cursos</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="widget top-cursos-populares">
            <h3>Top 5 Cursos con Más Alumnos</h3>
            <ul class="lista-alumnos">
                @foreach ($topCursosPopulares as $curso)
                    <li class="alumno-item">
                        <i class="fa-solid fa-graduation-cap" style="font-size: 20px; color: #17a2b8;"></i>
                        <div>
                            <span style="display:block; font-size: 14px; font-weight: 600;">{{ $curso->nombre }}</span>
                            <span style="font-size: 12px; color: var(--txt-muted-dark);">Profesor ID: {{ $curso->profesor_id }}
                                - Nivel: {{ $curso->nivel }}</span>
                        </div>
                        <span class="tiempo"
                            style="font-weight: 700; background: #17a2b8; color: var(--txt-light); padding: 4px 8px; border-radius: 8px;">
                            {{ $curso->alumnos_count }} Alumnos
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="widget proximos-cursos">
            <h3>Próximos Cursos a Iniciar</h3>
            <ul class="lista-alumnos">
                @foreach ($proximosCursos as $curso)
                    <li class="alumno-item" style="align-items: flex-start;">
                        <i class="fa-solid fa-calendar-alt"></i>
                        <div>
                            <span style="display:block; font-size: 14px; font-weight: 600;">{{ $curso->nombre }}
                                ({{ $curso->nivel }})</span>
                            <span style="font-size: 12px; color: #888;">Por: {{ $curso->profesor->nombre }}
                                {{ $curso->profesor->apellido }}</span>
                        </div>
                        <span class="tiempo" style="text-align: right;">
                            <span
                                style="display: block; font-weight: 600; color: var(--txt-dark);">{{ $curso->fecha_inicio->format('d/M') }}</span>
                            <span
                                style="display: block; font-size: 10px; color: var(--txt-muted-dark);">{{ $curso->fecha_inicio->diffForHumans() }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="charts-row">

            <div class="widget estado-chart">
                <h3>Distribución de Alumnos por Estado</h3>
                <canvas id="estadoChart" style="max-height: 420px;"></canvas>

            </div>

            <div class="widget nivel-chart">
                <h3>Cursos por Nivel</h3>
                <canvas id="nivelChart" style="max-height: 420px;"></canvas>

            </div>

        </div>

    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

        <script>
            const estadoLabels = @json($chartEstadoLabels);
            const estadoData = @json($chartEstadoData);
            const nivelLabels = @json($chartNivelLabels);
            const nivelData = @json($chartNivelData);
        </script>

        <script src="{{ asset('js/dashboard-charts.js') }}"></script>
    @endpush
@endsection