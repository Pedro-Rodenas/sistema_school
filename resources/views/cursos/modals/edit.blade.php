<div class="modal" id="modal-edit">
    <div class="modal-content">

        <span id="close-edit" class="modal-close">×</span>

        <h2>Editar Curso</h2>

        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group form-full">
                    <label>Nombre del Curso</label>
                    <input type="text" id="edit-nombre" name="nombre" required>
                </div>

                <div class="form-group form-full">
                    <label>Descripción</label>
                    <textarea id="edit-descripcion" name="descripcion"></textarea>
                </div>

                <div class="form-group">
                    <label>Stock de alumnos</label>
                    <input type="number" id="edit-stock_alumnos" name="stock_alumnos" min="0" required>
                </div>

                <div class="form-group">
                    <label>Nivel</label>
                    <input type="text" id="edit-nivel" name="nivel">
                </div>

                <div class="form-group">
                    <label>Grado</label>
                    <input type="text" id="edit-grado" name="grado">
                </div>

                <div class="form-group">
                    <label>Aula</label>
                    <input type="text" id="edit-aula" name="aula">
                </div>

                <div class="form-group">
                    <label>Fecha inicio</label>
                    <input type="date" id="edit-fecha_inicio" name="fecha_inicio">
                </div>

                <div class="form-group">
                    <label>Fecha fin</label>
                    <input type="date" id="edit-fecha_fin" name="fecha_fin">
                </div>

                <div class="form-group form-full">
                    <label>Horario</label>
                    <input type="text" id="edit-horario" name="horario">
                </div>

                <div class="form-group form-full">
                    <label>Profesor</label>
                    <select id="edit-profesor_id" name="profesor_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($profesores as $profe)
                            <option value="{{ $profe->id }}">{{ $profe->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-full">
                    <label>Estado</label>
                    <select id="edit-estado" name="estado" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" data-close>Cancelar</button>
                <button type="submit" class="btn-save">Actualizar</button>
            </div>

        </form>
    </div>
</div>