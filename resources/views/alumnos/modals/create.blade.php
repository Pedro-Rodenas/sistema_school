<div class="modal" id="modal-create-alumno">
    <div class="modal-content">

        <h2>Registrar Alumno</h2>

        <form action="{{ route('alumnos.store') }}" method="POST">
            @csrf

            <label>DNI</label>
            <input type="text" name="dni" id="dni-al-create" required>

            <label>Apellidos</label>
            <input type="text" name="apellidos" required>

            <label>Nombres</label>
            <input type="text" name="nombre" required>

            <label>Correo Institucional</label>
            <input type="email" name="correo_institucional" id="correo-al-create" readonly>

            <label>Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" required>

            <label>Teléfono</label>
            <input type="text" name="telefono">

            <label>Dirección</label>
            <input type="text" name="direccion">

            <label>Estado</label>
            <select name="estado" required>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" id="close-create-alumno">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>

        </form>
    </div>
</div>