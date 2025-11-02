@extends('layouts.app')

@section('content')
<div class="container py-4">

  <!-- 🔹 Título y botón principal -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-danger">
      <i class="bi bi-star-fill me-2"></i> Productos Destacados
    </h2>
    <button class="btn btn-danger rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addFeaturedModal">
      <i class="bi bi-plus-circle"></i> Agregar producto
    </button>
  </div>

  <!-- 🔹 Mensaje de éxito -->
  @if(session('success'))
    <div class="alert alert-success shadow-sm">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
  @endif

  <!-- ===============================
        TABLA DE PRODUCTOS DESTACADOS
  ================================= -->
  <div class="table-responsive shadow-sm rounded-4 border">
    <table class="table table-hover align-middle text-center mb-0">
      <thead class="table-danger">
        <tr>
          <th>Imagen</th>
          <th>Título</th>
          <th>Precio</th>
          <th>Publicado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($featured as $item)
          <tr>
            <!-- Imagen -->
            <td>
              @if($item->image && file_exists(public_path($item->image)))
                <img src="{{ asset($item->image) }}" width="80" height="80" class="rounded shadow-sm object-fit-cover border">
              @else
                <span class="text-muted fst-italic">Sin imagen</span>
              @endif
            </td>

            <!-- Título -->
            <td class="fw-semibold">{{ $item->title }}</td>

            <!-- Precio -->
            <td>
              @if($item->price)
                <span class="fw-bold text-success">Q{{ number_format($item->price, 2) }}</span>
                @if($item->old_price)
                  <small class="text-muted text-decoration-line-through d-block">
                    Q{{ number_format($item->old_price, 2) }}
                  </small>
                @endif
              @else
                <span class="text-muted">—</span>
              @endif
            </td>

            <!-- Estado -->
            <td>
              <form action="{{ route('admin.featured.toggle', $item) }}" method="POST">
                @csrf @method('PUT')
                <button class="btn btn-sm rounded-pill {{ $item->is_published ? 'btn-success' : 'btn-secondary' }}">
                  {{ $item->is_published ? 'Publicado' : 'Oculto' }}
                </button>
              </form>
            </td>

            <!-- Acciones -->
            <td>
              <form action="{{ route('admin.featured.destroy', $item) }}" method="POST"
                    onsubmit="return confirm('¿Eliminar el producto destacado {{ $item->title }}?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger rounded-pill">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="py-3 text-muted">
              <i class="bi bi-inboxes"></i> No hay productos destacados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- 🔹 Paginación -->
  <div class="mt-3">
    {{ $featured->links() }}
  </div>

</div>

<!-- ===============================
        MODAL: NUEVO PRODUCTO
================================= -->
<div class="modal fade" id="addFeaturedModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-danger text-white rounded-top-4">
        <h5 class="modal-title">
          <i class="bi bi-star-fill me-2"></i> Nuevo Producto Destacado
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.featured.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Título</label>
            <input type="text" name="title" class="form-control" required placeholder="Ej. Aceite Honda Pro Racing">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Descripción</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Detalles opcionales..."></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Precio actual (Q)</label>
              <input type="number" step="0.01" name="price" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Precio anterior (Q)</label>
              <input type="number" step="0.01" name="old_price" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Imagen</label>
            <input type="file" name="image" class="form-control">
            <small class="text-muted d-block mt-1">Se recomienda formato JPG o WEBP (máx. 2MB)</small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-danger rounded-pill px-4">
            <i class="bi bi-save2 me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
