document.addEventListener("DOMContentLoaded", () => {

    /* ======================
          UTILIDAD GLOBAL
    ====================== */
    const open = modal => modal && (modal.style.display = "flex");
    const close = modal => modal && (modal.style.display = "none");


    /* ======================
          MODAL CREAR
    ====================== */
    const modalCreate = document.getElementById("modal-create");
    const btnOpenCreate = document.getElementById("btn-open-create");
    const btnCloseCreate = document.getElementById("close-create");

    document.querySelectorAll("[data-close]").forEach(btn => {
        btn.addEventListener("click", () => {
            btn.closest(".modal").style.display = "none";
        });
    });

    if (btnOpenCreate && modalCreate) {
        btnOpenCreate.addEventListener("click", () => open(modalCreate));
    }
    if (btnCloseCreate && modalCreate) {
        btnCloseCreate.addEventListener("click", () => close(modalCreate));
    }


    /* ======================
           MODAL EDITAR
    ====================== */
    const modalEdit = document.getElementById("modal-edit");
    const btnCloseEdit = document.getElementById("close-edit");

    document.querySelectorAll(".btn-edit-curso").forEach(btn => {
        btn.addEventListener("click", () => {

            const id = btn.dataset.id;
            const card = document.querySelector(`.c-card[data-id="${id}"]`);
            if (!card) return;

            // Actualizar acción del formulario
            const editForm = document.getElementById("edit-form");
            if (editForm) editForm.action = "/cursos/" + id;

            // Campos editables
            const map = {
                nombre: card.dataset.nombre,
                descripcion: card.dataset.descripcion,
                stock_alumnos: card.dataset.stock,
                fecha_inicio: card.dataset.inicio,
                fecha_fin: card.dataset.fin,
                nivel: card.dataset.nivel,
                grado: card.dataset.grado,
                aula: card.dataset.aula,
                horario: card.dataset.horario,
                profesor_id: card.dataset.profesor_id,
                estado: card.dataset.estado
            };

            const estadoInput = document.getElementById("edit-estado");
            if (estadoInput) {
                estadoInput.value = card.dataset.estado;
            }

            // Rellenar inputs
            Object.entries(map).forEach(([key, value]) => {
                const input = document.getElementById(`edit-${key}`);
                if (input) input.value = value || "";
            });

            // Temas semanales (JSON → textarea)
            const temasInput = document.getElementById("edit-temas_semanales");
            if (temasInput) {
                try {
                    temasInput.value = JSON.parse(card.dataset.temas || "[]").join("\n");
                } catch {
                    temasInput.value = "";
                }
            }

            open(modalEdit);
        });
    });

    if (btnCloseEdit && modalEdit) {
        btnCloseEdit.addEventListener("click", () => close(modalEdit));
    }


    /* ======================
          MODAL SHOW
    ====================== */
    const modalShow = document.getElementById("modal-show");
    const btnCloseShow = document.getElementById("close-show");

    document.querySelectorAll(".btn-more-curso").forEach(btn => {
        btn.addEventListener("click", () => {

            const card = btn.closest("[data-id]");
            if (!card) return;

            // Profesor desde el HTML
            const profesor = card.querySelector(".c-prof")?.textContent || "—";

            // Campos simples
            const map = {
                nombre: card.dataset.nombre,
                descripcion: card.dataset.descripcion,
                stock: card.dataset.stock,
                inicio: card.dataset.inicio,
                fin: card.dataset.fin,
                nivel: card.dataset.nivel,
                grado: card.dataset.grado,
                aula: card.dataset.aula,
                horario: card.dataset.horario,
                profesor: profesor
            };

            Object.entries(map).forEach(([key, value]) => {
                const span = document.getElementById(`show-${key}`);
                if (span) span.textContent = value || "—";
            });

            // Temas semanales JSON → texto
            const temasShow = document.getElementById("show-temas");
            if (temasShow) {
                try {
                    temasShow.textContent = JSON.parse(card.dataset.temas || "[]").join("\n");
                } catch {
                    temasShow.textContent = "—";
                }
            }

            open(modalShow);
        });
    });

    if (btnCloseShow) {
        btnCloseShow.addEventListener("click", () => close(modalShow));
    }
});
