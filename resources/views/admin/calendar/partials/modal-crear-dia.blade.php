<div class="modal fade" id="crearDiaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.dias-disponibles.store') }}" method="POST">

        @csrf
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nuevo Día Disponible</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Hora de inicio</label>
                    <input type="time" name="hora_inicio" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Hora de fin</label>
                    <input type="time" name="hora_fin" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Límite de citas</label>
                    <input type="number" name="limite_citas" min="1" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-success">Guardar</button>
            </div>
        </div>
    </form>
  </div>
</div>
