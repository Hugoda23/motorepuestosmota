<div class="modal fade" id="modalCita" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formCita">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nueva Cita</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id">
          <input type="hidden" name="fecha">

          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input name="nombre" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input name="telefono" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Observación</label>
            <textarea name="observacion" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Hora</label>
            <input type="time" name="hora" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
