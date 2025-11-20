<div class="modal" id="modal-edit">
    <div class="modal-content">

        <h2>Editar Profesor</h2>

        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')

            <label>Apellido</label>
            <input type="text" name="apellido" id="edit-apellido" required>

            <label>Nombres</label>
            <input type="text" name="nombre" id="edit-nombre" required>

            <label>DNI</label>
            <input type="text" name="dni" id="edit-dni" required>

            <label>Correo electrónico</label>
            <input type="email" name="email" id="edit-email">

            <label>Teléfono</label>
            <input type="text" name="telefono" id="edit-telefono">

            <label>Dirección</label>
            <input type="text" name="direccion" id="edit-direccion">

            <label>Especialidad</label>
            <input type="text" name="especialidad" id="edit-especialidad">

            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="edit-fecha_nacimiento">

            <div class="modal-actions">
                <button type="button" class="btn-secondary" id="close-edit">Cancelar</button>
                <button type="submit" class="btn-primary">Actualizar</button>
            </div>
        </form>

    </div>
</div>