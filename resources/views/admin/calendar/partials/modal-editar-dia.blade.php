<div class="modal fade" id="editarDiaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editDiaForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Editar Día Disponible</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="dia_id" name="dia_id">

                <div class="mb-2">
                    <label class="form-label">Fecha</label>
                    <input type="date" id="edit_fecha" name="fecha" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Hora de inicio</label>
                    <input type="time" id="edit_hora_inicio" name="hora_inicio" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Hora de fin</label>
                    <input type="time" id="edit_hora_fin" name="hora_fin" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Límite de citas</label>
                    <input type="number" id="edit_limite" name="limite_citas" min="1" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-warning text-white">Guardar Cambios</button>
            </div>
        </div>
    </form>
  </div>
</div>
