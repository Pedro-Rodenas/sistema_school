<div class="modal" id="modal-edit-alumno">
    <div class="modal-content">
        <h2>Editar Alumno</h2>

        <form id="form-edit-alumno" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit-id-al" name="id">

            <label>DNI</label>
            <input type="text" id="edit-dni-al" name="dni" required>

            <label>Apellidos</label>
            <input type="text" id="edit-apellidos-al" name="apellidos" required>

            <label>Nombres</label>
            <input type="text" id="edit-nombre-al" name="nombre" required>

            <label>Fecha Nacimiento</label>
            <input type="date" id="edit-nacimiento-al" name="fecha_nacimiento" required>

            <label>Correo Institucional</label>
            <input type="email" id="edit-correo-al" name="correo_institucional" required>

            <label>Estado</label>
            <select id="edit-estado-al" name="estado">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" id="close-edit-alumno">Cancelar</button>
                <button type="submit" class="btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>