<div class="modal" id="modal-create">
    <div class="modal-content">
        <h2>Registrar Curso</h2>

        <form id="form-create" action="{{ route('cursos.store') }}" method="POST">
            @csrf

            <div class="form-grid">

                <div class="form-group form-full">
                    <label>Nombre del Curso</label>
                    <input type="text" name="nombre" required>
                </div>

                <div class="form-group form-full">
                    <label>Descripción</label>
                    <textarea name="descripcion"></textarea>
                </div>

                <div class="form-group">
                    <label>Stock de alumnos</label>
                    <input type="number" name="stock_alumnos" min="0" required>
                </div>

                <div class="form-group">
                    <label>Nivel</label>
                    <input type="text" name="nivel">
                </div>

                <div class="form-group">
                    <label>Grado</label>
                    <input type="text" name="grado">
                </div>

                <div class="form-group">
                    <label>Aula</label>
                    <input type="text" name="aula">
                </div>

                <div class="form-group">
                    <label>Fecha inicio</label>
                    <input type="date" name="fecha_inicio">
                </div>

                <div class="form-group">
                    <label>Fecha fin</label>
                    <input type="date" name="fecha_fin">
                </div>

                <div class="form-group form-full">
                    <label>Horario</label>
                    <input type="text" name="horario">
                </div>

                <div class="form-group form-full">
                    <label>Profesor</label>
                    <select name="profesor_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($profesores as $profe)
                            <option value="{{ $profe->id }}">{{ $profe->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-full">
                    <label>Estado</label>
                    <select name="estado" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" data-close>Cancelar</button>
                <button type="submit" class="btn-save">Guardar</button>
            </div>
        </form>
    </div>
</div>