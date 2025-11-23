@extends('layouts.app')

@section('content')
    <div class="dashboard-container">

        <!-- Indicadores -->
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

    </div>
@endsection