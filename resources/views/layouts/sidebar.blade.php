<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
        </div>
    </div>

    <nav class="sidebar-menu">

        {{-- PROFESORES --}}
        <a href="{{ route('dashboard.index') }}"
            class="menu-item {{ request()->is('dashboard') || request()->is('dashboard/*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-tie icon"></i>
            <span class="text">Dashboard</span>
        </a>

        {{-- PROFESORES --}}
        <a href="{{ route('profesores.index') }}"
            class="menu-item {{ request()->is('profesores') || request()->is('profesores/*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-tie icon"></i>
            <span class="text">Profesores</span>
        </a>

        {{-- CURSOS --}}
        <a href="{{ route('cursos.index') }}"
            class="menu-item {{ request()->is('cursos') || request()->is('cursos/*') ? 'active' : '' }}">
            <i class="fa-solid fa-book icon"></i>
            <span class="text">Cursos</span>
        </a>

        {{-- ALUMNOS (aún no existe) --}}
        <a href="{{ route('alumnos.index') }}"
            class="menu-item {{ request()->is('alumnos') || request()->is('alumnos/*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-graduate icon"></i>
            <span class="text">Alumnos</span>
        </a>

    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Cerrar sesión</button>
        </form>
    </div>

</div>