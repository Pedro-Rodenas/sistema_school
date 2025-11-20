document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
                    ELEMENTOS GENERALES
    ===================================================== */
    const tabla = document.querySelector("#tabla-profesores tbody");
    const buscador = document.getElementById("buscador");
    const switchEstado = document.getElementById("switch-estado");
    const labelEstado = document.getElementById("label-estado");

    let estadoActual = "activo"; // por defecto


    /* =====================================================
                    FUNCIÓN PARA CARGAR TABLA
    ===================================================== */
    const cargarProfesores = async () => {
        const res = await fetch(`/profesores/filtrar/${estadoActual}`);
        const data = await res.json();

        tabla.innerHTML = "";

        data.forEach(p => {
            tabla.innerHTML += `
                <tr>
                    <td>${p.id}</td>
                    <td>${p.apellido}</td>
                    <td>${p.nombre}</td>
                    <td>${p.dni}</td>
                    <td>${p.email}</td>
                    <td>${p.telefono ?? ''}</td>
                    <td>${p.direccion ?? ''}</td>
                    <td>${p.especialidad ?? ''}</td>
                    <td>${p.fecha_nacimiento ?? ''}</td>
                    <td>
                        <button class="btn-edit"
                            data-id="${p.id}"
                            data-apellido="${p.apellido}"
                            data-nombre="${p.nombre}"
                            data-dni="${p.dni}"
                            data-email="${p.email}"
                            data-telefono="${p.telefono}"
                            data-direccion="${p.direccion}"
                            data-especialidad="${p.especialidad}"
                            data-fecha_nacimiento="${p.fecha_nacimiento}">
                            Editar
                        </button>

                        <button class="btn-toggle" data-id="${p.id}">
                            ${p.estado === "activo" ? "Inactivar" : "Activar"}
                        </button>
                    </td>
                </tr>
            `;
        });
    };

    cargarProfesores();


    /* =====================================================
                    BUSCADOR EN TIEMPO REAL
    ===================================================== */
    buscador.addEventListener("input", () => {
        const texto = buscador.value.toLowerCase();
        document.querySelectorAll("#tabla-profesores tbody tr").forEach(fila => {
            fila.style.display = fila.innerText.toLowerCase().includes(texto)
                ? "" : "none";
        });
    });


    /* =====================================================
                    FILTRO ACTIVO / INACTIVO
    ===================================================== */
    switchEstado.addEventListener("change", () => {
        estadoActual = switchEstado.checked ? "inactivo" : "activo";
        labelEstado.textContent = estadoActual === "activo" ? "Activos" : "Inactivos";
        cargarProfesores();
    });


    /* =====================================================
                    MODAL CREAR
    ===================================================== */
    const modalCreate = document.getElementById("modal-create");
    const btnOpenCreate = document.getElementById("btn-open-create");
    const btnCloseCreate = document.getElementById("close-create");

    btnOpenCreate.onclick = () => modalCreate.style.display = "flex";
    btnCloseCreate.onclick = () => modalCreate.style.display = "none";


    /* =====================================================
                    MODAL EDITAR (DINÁMICO)
    ===================================================== */
    const modalEdit = document.getElementById("modal-edit");
    const btnCloseEdit = document.getElementById("close-edit");

    // EVENT DELEGATION → para botones agregados dinámicamente
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;

        const campos = [
            "apellido", "nombre", "dni", "email",
            "telefono", "direccion", "especialidad", "fecha_nacimiento"
        ];

        campos.forEach(campo => {
            const input = document.getElementById(`edit-${campo}`);
            if (input) input.value = btn.dataset[campo] || "";
        });

        document.getElementById("edit-form").action = `/profesores/${btn.dataset.id}`;

        modalEdit.style.display = "flex";
    });

    btnCloseEdit.onclick = () => modalEdit.style.display = "none";


    /* =====================================================
            ACTIVAR / INACTIVAR PROFESOR (DINÁMICO)
    ===================================================== */
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-toggle");
        if (!btn) return;

        const id = btn.dataset.id;

        if (!confirm("¿Seguro que deseas cambiar el estado de este profesor?")) return;

        const res = await fetch(`/profesores/${id}/estado`, {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (res.ok) {
            alert("Estado actualizado");
            location.reload();
        }

    });


    /* =====================================================
                        GRAFICO 1
    ===================================================== */
    new Chart(document.getElementById('chart1'), {
        type: 'bar',
        data: {
            labels: window.profData.especialidades,
            datasets: [{
                label: 'Profesores por especialidad',
                data: window.profData.conteoEspecialidades,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });


    /* =====================================================
                        GRAFICO 2
    ===================================================== */
    new Chart(document.getElementById('chart2'), {
        type: 'bar',
        data: {
            labels: ['20-29', '30-39', '40-49', '50+'],
            datasets: [{
                label: 'Profesores por edad',
                data: [
                    window.profData.edades.r1,
                    window.profData.edades.r2,
                    window.profData.edades.r3,
                    window.profData.edades.r4
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

});
