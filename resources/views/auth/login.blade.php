<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - The Special School</title>

    <!-- Tu CSS -->
    <link rel="stylesheet" href="/css/auth.css">
</head>

<body>
    <main class="container">

        <!-- Columna izquierda (imagen grande) -->
        <section class="left-panel">
            <img src="/img/login-banner.png" alt="Banner" class="banner">
        </section>

        <!-- Columna derecha (formulario) -->
        <section class="right-panel">

            <h1 class="title">Continúa con los procesos<br>de tu compañía</h1>

            <div class="login-social-wrapper">
                <p class="subtitle">Inicia sesión con</p>

                <div class="social-login">
                    <!-- Google -->
                    <button class="btn-social google">
                        <svg width="20" height="20" viewBox="0 0 256 262" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#4285F4"
                                d="M255.79 133.51c0-10.72-.86-18.51-2.72-26.61H130.55v48.38h71.88c-1.45 12.04-9.28 30.17-26.7 42.36l-.24 1.57 38.73 30.04 2.68.27c24.64-22.8 38.89-56.42 38.89-96.01z" />
                            <path fill="#34A853"
                                d="M130.55 261.1c35.2 0 64.77-11.53 86.36-31.41l-41.13-31.88c-11.02 7.67-25.82 13.04-45.23 13.04-34.59 0-63.93-22.79-74.27-54.24l-1.54.13-40.2 31.06-.53 1.48c20.68 41.16 63.26 71.82 116.54 71.82z" />
                            <path fill="#FBBC05"
                                d="M56.28 156.61c-2.78-8.1-4.37-16.75-4.37-25.61 0-8.86 1.59-17.51 4.32-25.61l-.07-1.72-40.54-31.44-1.32.63C7.14 92.01 0 111.3 0 131c0 19.7 7.14 38.99 19.68 54.14l36.6-28.53z" />
                            <path fill="#EA4335"
                                d="M130.55 50.52c24.52 0 41.05 10.58 50.47 19.43l36.84-35.97C195.17 12.21 165.75 0 130.55 0 77.27 0 34.69 30.66 14.01 71.82l42.32 32.86c10.4-31.45 39.74-54.16 74.22-54.16z" />
                        </svg>
                    </button>

                    <!-- GitHub -->
                    <button class="btn-social github">
                        <svg width="20" height="20" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38
                    0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52
                    -.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07
                    -1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12
                    0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82
                    2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65
                    3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013
                    8.013 0 0016 8c0-4.42-3.58-8-8-8z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="divider">
                <span></span>
                <p>o</p> <span></span>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <label for="email" class="label">Correo</label>
                <input type="email" name="email" class="input" placeholder="Ingresa tu correo">

                <label for="password" class="label">Contraseña</label>
                <input type="password" name="password" class="input" placeholder="Ingresa tu contraseña">

                <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>

                <button class="btn-submit">Iniciar Sesión</button>
            </form>

            <p class="register">¿Tu cuenta es de supervisor? <a href="#">Ingresa aquí</a></p>

        </section>

    </main>
</body>

</html>