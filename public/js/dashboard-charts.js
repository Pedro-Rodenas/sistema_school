document.addEventListener('DOMContentLoaded', function () {

    // 💡 DEFINICIÓN DE COLORES FUTURISTAS (Transparencia en RGBA)
    // Usaremos un negro muy oscuro y un blanco brillante con transparencia.
    const ACCENT_TRANSPARENT = 'rgba(0, 0, 0, 0.7)';  // Negro semi-transparente para texto y barras
    const FILL_LIGHT_TRANSPARENT = 'rgba(0, 0, 0, 0.05)'; // Relleno muy sutil (casi invisible)
    const BORDER_TRANSPARENT = 'rgba(0, 0, 0, 0.4)';  // Borde nítido pero no opaco
    const GRID_COLOR = 'rgba(0, 0, 0, 0.1)';          // Líneas de rejilla sutiles
    const TEXT_COLOR = 'var(--txt-dark)';             // Usar el color oscuro definido en CSS (negro)
    const BACKGROUND_WIDGET = 'var(--bg-light-widget)';

    // ===========================================
    // GRÁFICO 1: DISTRIBUCIÓN DE ALUMNOS POR ESTADO (Doughnut)
    // - Estilo minimalista, usando transparencia y bordes gruesos.
    // ===========================================

    const ctxEstado = document.getElementById('estadoChart')?.getContext('2d');

    if (ctxEstado) {
        new Chart(ctxEstado, {
            type: 'doughnut',
            data: {
                labels: estadoLabels,
                datasets: [{
                    label: 'Número de Alumnos',
                    data: estadoData,
                    backgroundColor: [
                        'rgba(0, 0, 0, 0.8)',   // Activos: Negro oscuro semi-transparente
                        'rgba(0, 0, 0, 0.5)'    // Inactivos: Gris oscuro semi-transparente
                    ],
                    // Borde grueso blanco para efecto "recorte"
                    borderColor: BACKGROUND_WIDGET,
                    borderWidth: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: TEXT_COLOR,
                            padding: 20,
                            font: {
                                size: 14,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        // Tooltip oscuro y futurista
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        bodyFont: {
                            size: 14
                        }
                    }
                }
            }
        });
    }

    // ===========================================
    // GRÁFICO 2: CURSOS POR NIVEL (Barra)
    // - Estilo de barras "fantasma" con contorno definido.
    // ===========================================

    const ctxNivel = document.getElementById('nivelChart')?.getContext('2d');

    if (ctxNivel) {
        new Chart(ctxNivel, {
            type: 'bar',
            data: {
                labels: nivelLabels,
                datasets: [{
                    label: 'Cursos',
                    data: nivelData,
                    // Relleno muy ligero (efecto cristal)
                    backgroundColor: FILL_LIGHT_TRANSPARENT,
                    // Borde negro semi-transparente (el foco del estilo futurista)
                    borderColor: BORDER_TRANSPARENT,
                    borderWidth: 2,
                    borderRadius: 4,
                    // El hover debe ser más opaco para el efecto "encendido"
                    hoverBackgroundColor: 'rgba(0, 0, 0, 0.2)',
                    hoverBorderColor: ACCENT_TRANSPARENT,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        bodyFont: {
                            size: 14
                        }
                    }
                },
                scales: {
                    x: {
                        // Ocultamos la rejilla para mayor limpieza
                        grid: { display: false },
                        ticks: { color: TEXT_COLOR, font: { weight: '500' } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: TEXT_COLOR
                        },
                        // Líneas de rejilla muy sutiles, simulando un plano de proyección
                        grid: { color: GRID_COLOR, borderDash: [4, 4] }
                    }
                }
            }
        });
    }
});