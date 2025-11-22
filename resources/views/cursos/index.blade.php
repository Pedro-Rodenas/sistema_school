@extends('layouts.app')

@section('content')

    <div class="profesores-page">

        <div class="c-header">
            <h2>Cursos</h2>
            <button class="btn-add" id="btn-open-create">+ Nuevo Curso</button>
        </div>

        <div class="c-grid">
            @foreach($cursos as $curso)
                <div class="c-card" data-id="{{ $curso->id }}" data-nombre="{{ $curso->nombre }}"
                    data-descripcion="{{ $curso->descripcion }}" data-stock="{{ $curso->stock_alumnos }}"
                    data-inicio="{{ $curso->fecha_inicio }}" data-fin="{{ $curso->fecha_fin }}" data-nivel="{{ $curso->nivel }}"
                    data-grado="{{ $curso->grado }}" data-aula="{{ $curso->aula }}" data-horario="{{ $curso->horario }}"
                    data-profesor_id="{{ $curso->profesor_id }}" data-estado="{{ $curso->estado }}">

                    <h3>{{ $curso->nombre }}</h3>
                    <p class="c-prof">{{ $curso->profesor->nombre }}</p>

                    <div class="c-extra">
                        <span>Alumnos: {{ $curso->stock_alumnos }}</span>
                        <span class="badge {{ $curso->estado }}">
                            {{ ucfirst($curso->estado) }}
                        </span>
                    </div>

                    <button class="btn-more-curso">Ver más</button>
                    <button class="btn-edit-curso" data-id="{{ $curso->id }}">Editar</button>

                </div>
            @endforeach
        </div>

    </div>

    @include('cursos.modals.create')
    @include('cursos.modals.edit')
    @include('cursos.modals.show')

    <script src="{{ asset('js/cursos.js') }}"></script>

@endsection