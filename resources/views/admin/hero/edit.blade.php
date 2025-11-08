@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-danger text-white fw-semibold rounded-top-4">
      <i class="bi bi-image-fill me-2"></i> Editar Sección Principal (Hero)
    </div>

    <div class="card-body">

      @if(session('success'))
        <div class="alert alert-success shadow-sm">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
      @endif

      <form method="POST" enctype="multipart/form-data" action="{{ route('admin.hero.update') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label fw-semibold">Título principal</label>
          <input type="text" name="title" class="form-control"
                 value="{{ old('title', $hero->title ?? '') }}"
                 placeholder="Ej. Encuentra las mejores motos del país" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Subtítulo</label>
          <input type="text" name="subtitle" class="form-control"
                 value="{{ old('subtitle', $hero->subtitle ?? '') }}"
                 placeholder="Ej. Repuestos originales, precios imbatibles...">
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Texto del botón</label>
            <input type="text" name="button_text" class="form-control"
                   value="{{ old('button_text', $hero->button_text ?? '') }}"
                   placeholder="Ej. Ver productos">
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Enlace del botón</label>
            <input type="text" name="button_link" class="form-control"
                   value="{{ old('button_link', $hero->button_link ?? '') }}"
                   placeholder="Ej. /productos">
          </div>
        </div>

        <div class="row align-items-center mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Imagen de fondo</label>
            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
            <small class="text-muted d-block mt-1">Formatos JPG o WEBP — Máx. 2MB</small>
          </div>

          <div class="col-md-6 text-center">
            <label class="form-label fw-semibold d-block">Vista previa</label>
            <img id="previewImage"
                 src="{{ !empty($hero->image) && file_exists(public_path($hero->image)) ? asset($hero->image) : asset('images/placeholder.png') }}"
                 alt="Vista previa"
                 class="img-fluid rounded border shadow-sm preview-img"
                 style="max-width: 280px;">
          </div>
        </div>

        <div class="text-end">
          <button class="btn btn-danger rounded-pill px-4">
            <i class="bi bi-save2 me-2"></i> Guardar cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/hero.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/hero.js') }}" defer></script>
@endpush
