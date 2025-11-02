@extends('layouts.app')

@section('content')
<div class="container py-4">

  <!-- 🔹 Encabezado -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-danger text-uppercase">
      <i class="bi bi-box-seam me-2"></i> Productos Públicos
    </h2>
    <button class="btn btn-danger rounded-pill shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#createProductModal">
      <i class="bi bi-plus-circle me-1"></i> Nuevo Producto
    </button>
  </div>

  <!-- 🔹 Mensajes -->
  @if(session('success'))
    <div class="alert alert-success shadow-sm">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
  @endif

  <!-- ===============================
        TABLA DE PRODUCTOS PÚBLICOS
  ================================== -->
  <div class="table-responsive shadow-sm border rounded-4">
    <table class="table table-hover align-middle text-center mb-0">
      <thead class="table-danger">
        <tr>
          <th>ID</th>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Subcategoría</th>
          <th>Características</th>
          <th>Publicado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $p)
          <tr>
            <td class="fw-semibold">{{ $p->id }}</td>

            <td>
              @if($p->image && file_exists(public_path($p->image)))
                <img src="{{ asset($p->image) }}" width="70" height="70" class="rounded shadow-sm object-fit-cover border">
              @else
                <span class="text-muted fst-italic">Sin imagen</span>
              @endif
            </td>

            <td class="fw-semibold">{{ $p->name }}</td>
            <td>{{ $p->subcategorypublic->name ?? '—' }}</td>
            <td>{{ $p->features ?? '—' }}</td>

            <td>
              <span class="badge rounded-pill {{ $p->is_published ? 'bg-success' : 'bg-secondary' }}">
                {{ $p->is_published ? 'Sí' : 'No' }}
              </span>
            </td>

            <td>
              <form action="{{ route('admin.productspublic.toggle', $p) }}" method="POST" class="d-inline">
                @csrf @method('PUT')
                <button class="btn btn-sm rounded-pill {{ $p->is_published ? 'btn-warning' : 'btn-success' }}" title="Publicar / Ocultar">
                  <i class="bi {{ $p->is_published ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                </button>
              </form>

              <form action="{{ route('admin.productspublic.destroy', $p) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Eliminar el producto {{ $p->name }}?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger rounded-pill" title="Eliminar">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="py-3 text-muted">
              <i class="bi bi-inboxes"></i> No hay productos registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- 🔹 Paginación -->
  <div class="mt-3">
    {{ $products->links() }}
  </div>
</div>

<!-- ===============================
        MODAL CREAR PRODUCTO
================================= -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-danger text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="createProductModalLabel">
          <i class="bi bi-box2-fill me-2"></i> Nuevo Producto Público
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.productspublic.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-semibold">Nombre del producto</label>
              <input type="text" name="name" class="form-control" placeholder="Ej. Motocicleta Hornet" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Subcategoría</label>
              <select name="subcategorypublic_id" class="form-select" required>
                <option value="">Seleccionar...</option>
                @foreach($subcategories as $sub)
                  <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-semibold">Descripción</label>
              <textarea name="description" class="form-control" rows="2" placeholder="Detalles del producto..."></textarea>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-semibold">Características</label>
              <textarea name="features" class="form-control" rows="2" placeholder="Ej. Motor 160cc, 4 tiempos..."></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Imagen</label>
              <input type="file" name="image" class="form-control" accept="image/*">
              <small class="text-muted d-block mt-1">Formato JPG o WEBP, máx. 2MB</small>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger rounded-pill fw-semibold px-4">
            <i class="bi bi-save2 me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
