@extends('layouts.app')

@section('title', 'Recordatorios')
@section('header', 'Recordatorios')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">
    <i class="bi bi-alarm-fill text-info"></i> Mis Recordatorios
  </h2>

  <!-- 📅 Calendario -->
  <div id="calendar"></div>

  <!-- 🎨 Leyenda de colores -->
  <div class="mt-4 text-center">
    <div class="d-inline-block me-3">
      <span class="badge" style="background-color:#3b82f6;">Pendiente</span>
    </div>
    <div class="d-inline-block me-3">
      <span class="badge" style="background-color:#facc15; color:#000;">Hoy</span>
    </div>
    <div class="d-inline-block me-3">
      <span class="badge" style="background-color:#ef4444;">Vencido</span>
    </div>
    <div class="d-inline-block">
      <span class="badge" style="background-color:#22c55e;">Reactivado</span>
    </div>
  </div>

  <!-- Modal: Crear / Ver / Editar / Reactivar recordatorio -->
  <div class="modal fade" id="reminderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="reminderForm" class="modal-content">
        @csrf
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title" id="modalTitle">
            <i class="bi bi-plus-circle"></i> Nuevo Recordatorio
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <!-- ID oculto -->
          <input type="hidden" name="id">

          <div class="mb-3">
            <label class="form-label fw-semibold">Título</label>
            <input type="text" name="title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Descripción</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Fecha y hora</label>
            <input type="datetime-local" name="remind_at" class="form-control" required>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="notified" id="notifiedCheck" disabled>
            <label class="form-check-label" for="notifiedCheck">Notificado</label>
          </div>
        </div>

        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger d-none" id="deleteBtn">
            <i class="bi bi-trash"></i> Eliminar
          </button>

          <div>
            <button type="button" class="btn btn-warning d-none" id="reactivarBtn">
              <i class="bi bi-arrow-repeat"></i> Reactivar
            </button>
            <button type="button" class="btn btn-info d-none" id="updateBtn">
              <i class="bi bi-pencil-square"></i> Actualizar
            </button>
            <button type="submit" class="btn btn-success" id="saveBtn">
              <i class="bi bi-plus-circle"></i> Guardar
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/locales/es.global.min.js"></script>
<script src="{{ asset('js/reminders.js') }}"></script>
@endpush