@extends('layouts.app')

@section('title', 'Administrar Promociones')

@section('content')
<div class="container py-4">

  <!-- 🔹 Encabezado -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-danger text-uppercase mb-0">
      <i class="bi bi-megaphone-fill me-2"></i> Promociones
    </h2>
    <button class="btn btn-danger rounded-pill fw-semibold shadow-sm"
            data-bs-toggle="modal" data-bs-target="#createPromotionModal">
      <i class="bi bi-plus-circle me-1"></i> Nueva Promoción
    </button>
  </div>

  <!-- 🔹 Alertas -->
  @if(session('success'))
    <div class="alert alert-success shadow-sm">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger shadow-sm">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- ===============================
        TABLA DE PROMOCIONES
  ================================== -->
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-dark text-white fw-semibold rounded-top-4">
      <i class="bi bi-megaphone"></i> Promociones Registradas
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle text-center mb-0">
        <thead class="table-danger">
          <tr>
            <th>#</th>
            <th>Imagen</th>
            <th>Título</th>
            <th>Precio</th>
            <th>Vigencia</th>
            <th>Publicado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($promotions as $promo)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              @if($promo->image && file_exists(public_path($promo->image)))
                <img src="{{ asset($promo->image) }}" width="70" height="70" class="rounded border object-fit-cover">
              @else
                <span class="text-muted fst-italic">Sin imagen</span>
              @endif
            </td>
            <td class="fw-semibold">{{ $promo->title }}</td>
            <td>Q{{ number_format($promo->price, 2) }}</td>
            <td>
              @if($promo->start_date && $promo->end_date)
                <span class="badge bg-light text-dark border">
                  {{ $promo->start_date->format('d/m/Y') }} - {{ $promo->end_date->format('d/m/Y') }}
                </span>
              @else
                <span class="text-muted fst-italic">Sin definir</span>
              @endif
            </td>
            <td>
              <form action="{{ route('admin.promotions.toggle', $promo->id) }}" method="POST">
                @csrf @method('PUT')
                <button type="submit" 
                        class="btn btn-sm {{ $promo->is_published ? 'btn-success' : 'btn-secondary' }}">
                  {{ $promo->is_published ? 'Publicado' : 'Oculto' }}
                </button>
              </form>
            </td>
            <td>
              <form action="{{ route('admin.promotions.destroy', $promo->id) }}" 
                    method="POST" 
                    onsubmit="return confirm('¿Eliminar esta promoción?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash"></i> Eliminar
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-muted py-3">
              <i class="bi bi-inboxes"></i> No hay promociones registradas.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ===============================
        MODAL CREAR PROMOCIÓN
================================= -->
<div class="modal fade" id="createPromotionModal" tabindex="-1" aria-labelledby="createPromotionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-danger text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="createPromotionModalLabel">
          <i class="bi bi-plus-circle me-2"></i> Nueva Promoción
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-semibold">Título *</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Subtítulo</label>
              <input type="text" name="subtitle" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Precio actual (Q)</label>
              <input type="number" name="price" class="form-control" step="0.01">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Precio anterior (Q)</label>
              <input type="number" name="old_price" class="form-control" step="0.01">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Fecha de inicio</label>
              <input type="date" name="start_date" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Fecha de finalización</label>
              <input type="date" name="end_date" class="form-control">
            </div>

            <div class="col-md-12">
              <label class="form-label fw-semibold">Beneficios</label>
              <input type="text" name="benefits" class="form-control" placeholder="Ej: Cambio de aceite gratis">
            </div>

            <div class="col-md-12">
              <label class="form-label fw-semibold">Descripción</label>
              <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Imagen</label>
              <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
              <small class="text-muted d-block mt-1">Formatos JPG o WEBP — Máx. 2MB</small>
            </div>

            <div class="col-md-6 text-center">
              <label class="form-label fw-semibold d-block">Vista previa</label>
              <img id="previewImage" src="{{ asset('images/placeholder.png') }}" 
                   alt="Vista previa" class="preview-img d-none" width="180" height="180">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-danger rounded-pill fw-semibold">
            <i class="bi bi-save2 me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/promotions.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/promotions.js') }}" defer></script>
@endpush
