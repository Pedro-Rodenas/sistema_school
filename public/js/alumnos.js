document.addEventListener("DOMContentLoaded", () => {

    // ------------------------------------
    // 📌 VARIABLES GLOBALES
    // ------------------------------------
    const tabla = document.querySelector("#tabla-alumnos tbody");
    const buscador = document.getElementById("buscador-alumnos");
    const switchEstado = document.getElementById("switch-estado-alumnos");
    const labelEstado = document.getElementById("label-estado-alumnos");

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    let estadoActual = "activo";

    const btnOpenCreate = document.getElementById("btn-open-create-alumno");
    const modalCreate = document.getElementById("modal-create-alumno");
    const modalEdit = document.getElementById("modal-edit-alumno");
    const formEdit = document.getElementById("form-edit-alumno");


    // ------------------------------------
    // 🔍 BUSCADOR
    // ------------------------------------
    const aplicarBuscador = () => {
        const texto = buscador.value.toLowerCase();
        document.querySelectorAll("#tabla-alumnos tbody tr").forEach(fila => {
            fila.style.display = fila.innerText.toLowerCase().includes(texto)
                ? ""
                : "none";
        });
    };


    // ------------------------------------
    // 🔄 CARGAR ALUMNOS CON AJAX SEGÚN ESTADO
    // ------------------------------------
    const cargarAlumnos = async () => {
        const res = await fetch(`/alumnos/filtrar/${estadoActual}`);
        const data = await res.json();
        tabla.innerHTML = "";

        data.forEach(a => {
            tabla.innerHTML += `
                <tr>
                    <td>${a.id}</td>
                    <td>${a.dni}</td>
                    <td>${a.apellidos}</td>
                    <td>${a.nombre}</td>
                    <td>${a.correo_institucional}</td>
                    <td>${a.fecha_nacimiento ?? ""}</td>
                    <td><span class="badge ${a.estado}">${a.estado}</span></td>
                    <td>
                        <button class="btn-edit-alumno"
                            data-id="${a.id}"
                            data-dni="${a.dni}"
                            data-apellidos="${a.apellidos}"
                            data-nombre="${a.nombre}"
                            data-nacimiento="${a.fecha_nacimiento}"
                            data-correo="${a.correo_institucional}"
                            data-estado="${a.estado}">
                            Editar
                        </button>
                        <button class="btn-toggle" data-id="${a.id}">
                            ${a.estado === "activo" ? "Inactivar" : "Activar"}
                        </button>
                    </td>
                </tr>
            `;
        });
    };


    // Inicializar tabla
    cargarAlumnos().then(aplicarBuscador);
    buscador.addEventListener("input", aplicarBuscador);


    // ------------------------------------
    // 🔁 CAMBIO DE ESTADO (Activos/Inactivos)
    // ------------------------------------
    switchEstado.addEventListener("change", () => {
        estadoActual = switchEstado.checked ? "inactivo" : "activo";
        labelEstado.textContent = estadoActual === "activo" ? "Activos" : "Inactivos";
        cargarAlumnos().then(aplicarBuscador);
    });


    // ------------------------------------
    // 🛠 ACCIONES DE TABLA: Editar + Cambiar Estado
    // ------------------------------------
    document.addEventListener("click", async (e) => {
        // Cambiar estado
        const btnToggle = e.target.closest(".btn-toggle");
        if (btnToggle) {
            if (!confirm("¿Seguro que deseas cambiar el estado?")) return;
            const id = btnToggle.dataset.id;

            await fetch(`/alumnos/${id}/estado`, {
                method: "PUT",
                headers: { "X-CSRF-TOKEN": csrfToken }
            });
            cargarAlumnos().then(aplicarBuscador);
        }

        // Abrir modal edición
        const btnEdit = e.target.closest(".btn-edit-alumno");
        if (btnEdit) {
            document.getElementById("edit-id-al").value = btnEdit.dataset.id;
            document.getElementById("edit-dni-al").value = btnEdit.dataset.dni;
            document.getElementById("edit-apellidos-al").value = btnEdit.dataset.apellidos;
            document.getElementById("edit-nombre-al").value = btnEdit.dataset.nombre;
            document.getElementById("edit-nacimiento-al").value = btnEdit.dataset.nacimiento;
            document.getElementById("edit-correo-al").value = btnEdit.dataset.correo;
            document.getElementById("edit-estado-al").value = btnEdit.dataset.estado;

            formEdit.action = `/alumnos/${btnEdit.dataset.id}`;
            modalEdit.style.display = "flex";
        }
    });


    // ------------------------------------
    // 🧩 CERRAR MODAL EDICIÓN
    // ------------------------------------
    document.addEventListener("click", (e) => {
        if (e.target.id === "close-edit-alumno") modalEdit.style.display = "none";
    });


    // ------------------------------------
    // ✏️ EDITAR ALUMNO (AJAX SUBMIT)
    // ------------------------------------
    if (formEdit) {
        formEdit.addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = document.getElementById("edit-id-al").value;
            const formData = new FormData(formEdit);
            formData.append('_method', 'PUT');

            const res = await fetch(`/alumnos/${id}`, {
                method: "POST",
                body: formData,
                headers: { "X-CSRF-TOKEN": csrfToken }
            });

            if (res.ok) {
                modalEdit.style.display = "none";
                cargarAlumnos().then(aplicarBuscador);
            } else {
                alert("Error al actualizar (DNI duplicado o datos inválidos)");
            }
        });
    }


    // ------------------------------------
    // 🆕 MODAL CREAR ALUMNO
    // ------------------------------------
    if (btnOpenCreate) {
        btnOpenCreate.addEventListener("click", () => {
            modalCreate.style.display = "flex";
        });
    }

    document.addEventListener("click", (e) => {
        if (e.target.id === "close-create-alumno") {
            modalCreate.style.display = "none";
        }
    });


    // ------------------------------------
    // 📊 GRÁFICOS Chart.js
    // ------------------------------------
    if (window.alumnoData) {
        const { conteoPorEdad, conteoPorMes } = window.alumnoData;

        const ctx1 = document.getElementById('alumnosChart1');
        if (ctx1) new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: Object.keys(conteoPorEdad),
                datasets: [{ label: 'Por edad', data: Object.values(conteoPorEdad) }]
            }
        });

        const ctx2 = document.getElementById('alumnosChart2');
        if (ctx2) new Chart(ctx2, {
            type: 'line',
            data: {
                labels: Object.keys(conteoPorMes),
                datasets: [{ label: 'Por mes', data: Object.values(conteoPorMes), fill: true }]
            }
        });
    }

});
