@extends('layouts.app')

@section('content')
<div class="container py-4">

  <!-- 🔹 ENCABEZADO -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-danger text-uppercase mb-0">
      <i class="bi bi-diagram-3 me-2"></i> Subcategorías Públicas
    </h2>
    <button class="btn btn-danger rounded-pill fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createSubcategoryModal">
      <i class="bi bi-plus-circle me-1"></i> Nueva subcategoría
    </button>
  </div>

  <!-- 🔹 ALERTAS -->
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
        TABLA DE SUBCATEGORÍAS
  ================================== -->
  <div class="table-responsive shadow-sm border rounded-4">
    <table class="table table-hover align-middle text-center mb-0">
      <thead class="table-danger">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Imagen</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($subcategories as $index => $sub)
          <tr>
            <td>{{ $subcategories->firstItem() + $index }}</td>
            <td class="fw-semibold">{{ $sub->name }}</td>
            <td>{{ $sub->category->name ?? '—' }}</td>
            <td>
              @if($sub->image && file_exists(public_path($sub->image)))
                <img src="{{ asset($sub->image) }}" width="70" height="70" class="rounded shadow-sm border object-fit-cover">
              @else
                <span class="text-muted fst-italic">Sin imagen</span>
              @endif
            </td>
            <td>{{ Str::limit($sub->description ?? '—', 50, '...') }}</td>
            <td>
              <form action="{{ route('admin.subcategoriespublic.destroy', $sub->id) }}" 
                    method="POST" 
                    onsubmit="return confirm('¿Estás seguro de eliminar esta subcategoría?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash"></i> Eliminar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-muted py-3">
              <i class="bi bi-inboxes"></i> No hay subcategorías registradas
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- 🔹 PAGINACIÓN -->
  <div class="mt-3">
    {{ $subcategories->links() }}
  </div>
</div>

<!-- ===============================
        MODAL CREAR SUBCATEGORÍA
================================= -->
<div class="modal fade" id="createSubcategoryModal" tabindex="-1" aria-labelledby="createSubcategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-danger text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="createSubcategoryModalLabel">
          <i class="bi bi-plus-circle me-2"></i> Nueva Subcategoría
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form action="{{ route('admin.subcategoriespublic.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <!-- Nombre -->
            <div class="col-md-6">
              <label for="name" class="form-label fw-semibold">Nombre *</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Ejemplo: Motos Sport" required>
            </div>

            <!-- Categoría -->
            <div class="col-md-6">
              <label for="categorypublic_id" class="form-label fw-semibold">Categoría *</label>
              <select name="categorypublic_id" id="categorypublic_id" class="form-select" required>
                <option value="">Selecciona una categoría...</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Descripción -->
            <div class="col-12">
              <label for="description" class="form-label fw-semibold">Descripción</label>
              <textarea name="description" id="description" rows="3" class="form-control" placeholder="Descripción breve..."></textarea>
            </div>

            <!-- Imagen -->
            <div class="col-md-6">
              <label for="image" class="form-label fw-semibold">Imagen</label>
              <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
              <small class="text-muted d-block mt-1">Formato JPG o WEBP, máx. 2MB</small>
            </div>

            <!-- Vista previa -->
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
<link rel="stylesheet" href="{{ asset('css/admin/subcategories.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/subcategories.js') }}" defer></script>
@endpush
