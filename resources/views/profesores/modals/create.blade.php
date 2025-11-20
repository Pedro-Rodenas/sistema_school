<div class="modal" id="modal-create">
    <div class="modal-content">

        <h2>Registrar Profesor</h2>

        <form action="{{ route('profesores.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Apellido</label>
            <input type="text" name="apellido" required>

            <label>Nombres</label>
            <input type="text" name="nombre" required>

            <label>DNI</label>
            <input type="text" name="dni" required>

            <label>Correo electrónico</label>
            <input type="email" name="email" required>

            <label>Teléfono</label>
            <input type="text" name="telefono">

            <label>Dirección</label>
            <input type="text" name="direccion">

            <label>Especialidad</label>
            <input type="text" name="especialidad">

            <label>Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento">

            <div class="modal-actions">
                <button type="button" class="btn-secondary" id="close-create">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>

    </div>
</div>