<div class="modal" id="modal-assign-cursos" style="display: none;">
    <div class="modal-content">

        <h2>Asignar cursos</h2>

        <form id="form-assign-cursos">
            @csrf
            <div id="lista-cursos">
                <!-- Se llenará con JS -->
            </div>

            <div class="modal-actions">
                <button type="button" id="close-assign-cursos" class="btn-secondary">
                    Cancelar
                </button>
                <button type="submit" class="btn-primary">
                    Guardar
                </button>
            </div>
        </form>

    </div>
</div>

<style>
    /* ======== MODAL ASIGNAR CURSOS ======== */
    #modal-assign-cursos .modal-content {
        width: 480px;
        max-height: 70vh;
        padding: 20px;
        background: #ffffff;
        border-radius: 12px;
        overflow-y: auto;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.2);
        animation: fadeInScale 0.25s ease-in-out;
    }

    /* Título */
    #modal-assign-cursos h2 {
        font-size: 20px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 18px;
        color: #222;
    }

    /* Contenedor de checkboxes */
    #lista-cursos {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 18px;
    }

    /* Cada checkbox-item */
    #lista-cursos .curso-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f7f7f7;
        padding: 10px;
        border-radius: 10px;
        transition: background 0.2s ease-in-out;
    }

    #lista-cursos .curso-item:hover {
        background: #e7e7e7;
    }

    /* Estilo de checkbox */
    #lista-cursos input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    /* Texto del curso */
    #lista-cursos label {
        font-size: 15px;
        cursor: pointer;
        color: #333;
    }

    /* Botones */
    #modal-assign-cursos .modal-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    #modal-assign-cursos .btn-primary,
    #modal-assign-cursos .btn-secondary {
        width: 50%;
        padding: 8px 10px;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        font-weight: 600;
        font-size: 14px;
    }

    #modal-assign-cursos .btn-primary {
        background: #007bff;
        color: white;
    }

    #modal-assign-cursos .btn-primary:hover {
        background: #005fcc;
    }

    #modal-assign-cursos .btn-secondary {
        background: #ccc;
        color: #222;
    }

    #modal-assign-cursos .btn-secondary:hover {
        background: #b5b5b5;
    }

    /* Animación */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>