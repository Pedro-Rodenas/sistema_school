<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profesores.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cursos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alumnos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <title>@yield('title', 'Special School')</title>
</head>

<body class="app-body">

    <div class="layout-container">

        @include('layouts.sidebar')

        <main class="content-wrapper">
            @yield('content')
        </main>

    </div>

    <button class="fab-ai-button" id="ai-chat-trigger">
        <i class="fa-solid fa-robot"></i>
    </button>

    <div class="ai-chat-modal" id="ai-chat-modal">
        <div class="chat-header">
            <h3>🤖 Asistente Académico IA</h3>
            <button id="close-chat-btn" class="close-btn">&times;</button>
        </div>
        <div class="chat-body" id="chat-body">
            <div class="message system-message">
                Hola! Soy tu asistente de gestión. Pregúntame sobre la cantidad de cursos, alumnos o profesores por
                nombre/estado.
            </div>
        </div>
        <div class="chat-input">
            <input type="text" id="user-input"
                placeholder="Escribe tu pregunta (Ej: ¿Cuántos alumnos tiene el curso X?)" autofocus>
            <button id="send-btn">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>

    @stack('scripts')
    <script src="{{ asset('js/ia_js.js') }}?v={{ time() }}"></script>
</body>

</html>