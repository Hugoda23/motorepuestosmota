@extends('layouts.app')

@section('content')
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-danger">Productos Destacados</h2>
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addFeaturedModal">
      <i class="bi bi-plus-circle"></i> Agregar producto
    </button>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle text-center">
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
            <td>
              @if($item->image)
                <img src="{{ asset('storage/'.$item->image) }}" width="80" class="rounded shadow-sm">
              @else
                <span class="text-muted">Sin imagen</span>
              @endif
            </td>
            <td class="fw-semibold">{{ $item->title }}</td>
            <td>Q{{ number_format($item->price, 2) }}</td>
            <td>
              <form action="{{ route('admin.featured.toggle', $item) }}" method="POST">
                @csrf @method('PUT')
                <button class="btn btn-sm {{ $item->is_published ? 'btn-success' : 'btn-secondary' }}">
                  {{ $item->is_published ? 'Publicado' : 'Oculto' }}
                </button>
              </form>
            </td>
            <td>
              <form action="{{ route('admin.featured.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-muted">No hay productos destacados.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $featured->links() }}

</div>

<!-- Modal para agregar producto -->
<div class="modal fade" id="addFeaturedModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-star-fill me-2"></i>Nuevo Producto Destacado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.featured.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Título</label>
            <input type="text" name="title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Descripción</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Precio</label>
              <input type="number" step="0.01" name="price" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Precio anterior</label>
              <input type="number" step="0.01" name="old_price" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Imagen</label>
            <input type="file" name="image" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
