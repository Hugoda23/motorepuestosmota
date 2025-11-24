@extends('layouts.app')

@section('title', 'Calendario')
@section('header', 'Citas')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="fw-bold mb-4">
      <i class="bi bi-calendar3 me-2 text-primary"></i>Agenda de Citas
    </h4>
    <div id="calendar"></div>
  </div>
</div>

<!-- =========================
     Modal: Crear / Editar Cita
========================= -->
<div class="modal fade" id="modalCita" tabindex="-1" aria-labelledby="modalCitaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formCita">
      @csrf
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalCitaLabel">Registrar Cita</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="cita-id">
          <input type="hidden" name="fecha" id="fecha">

          <div class="mb-3">
            <label class="form-label fw-semibold">Nombre</label>
            <input name="nombre" class="form-control" placeholder="Nombre del cliente" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Teléfono</label>
            <input name="telefono" class="form-control" placeholder="Ej. 5555-5555" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Observación</label>
            <textarea name="observacion" class="form-control" placeholder="Ej. cambio de aceite, revisión general..."></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Hora</label>
            <input type="time" name="hora" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" id="btnEliminar" class="btn btn-danger" style="display:none;">Eliminar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css" rel="stylesheet">
<link href="{{ asset('css/admin/calendar.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<!-- 🔗 Variables de rutas dinámicas -->
<script>
  const RUTA_CITAS_GET = "{{ route('admin.citas.get') }}";
  const RUTA_CITAS_STORE = "{{ route('admin.citas.store') }}";
  const RUTA_CITAS_ACTUALIZAR = "{{ route('admin.citas.actualizar') }}";
  const RUTA_CITAS_ELIMINAR = "{{ url('/admin/citas/eliminar') }}";
  const RUTA_DIAS_LLENO = "{{ route('admin.dias.llenos') }}";
</script>

<script src="{{ asset('js/admin/calendar.js') }}?v=3" defer></script>

@endpush
