@extends('layouts.app')

@section('title', 'Administrar Promociones')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold text-danger mb-4">
    <i class="bi bi-megaphone-fill me-2"></i> Administrar Promociones
  </h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- 🔹 Formulario Crear Promoción -->
  <div class="card mb-4 shadow-sm border-0 rounded-4">
    <div class="card-header bg-danger text-white fw-semibold rounded-top-4">
      <i class="bi bi-plus-circle me-2"></i> Nueva Promoción
    </div>
    <div class="card-body">
      <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Título</label>
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
            <input type="file" name="image" class="form-control">
          </div>

          <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-danger px-4 fw-semibold">
              <i class="bi bi-save me-1"></i> Guardar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- 🔹 Listado de Promociones -->
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-dark text-white fw-semibold rounded-top-4">
      <i class="bi bi-megaphone"></i> Promociones Registradas
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle text-center mb-0">
        <thead class="table-danger">
          <tr>
            <th>ID</th>
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
            <td>{{ $promo->id }}</td>
            <td>
              @if($promo->image && file_exists(public_path($promo->image)))
                <img src="{{ asset($promo->image) }}" width="70" class="rounded border">
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
              <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar promoción?')">
                  <i class="bi bi-trash"></i>
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
@endsection
