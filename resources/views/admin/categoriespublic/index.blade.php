@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">Categorías</h2>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- FORMULARIO NUEVA CATEGORÍA -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
      <i class="bi bi-plus-circle me-2"></i> Nueva Categoría
    </div>
    <div class="card-body">
      <form action="{{ route('admin.categoriespublic.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Nombre</label>
            <input type="text" name="name" class="form-control" required placeholder="Ej. Motos">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Imagen</label>
            <input type="file" name="image" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Descripción</label>
            <input type="text" name="description" class="form-control" placeholder="Opcional">
          </div>
        </div>
        <div class="text-end mt-3">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- LISTADO DE CATEGORÍAS -->
  <div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
      <i class="bi bi-tags me-2"></i> Categorías registradas
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-dark text-center">
          <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="text-center">
          @forelse($categories as $cat)
            <tr>
              <td>{{ $cat->id }}</td>
              <td>
                @if($cat->image)
                  <img src="{{ asset('storage/'.$cat->image) }}" width="60" class="rounded shadow-sm">
                @else
                  <span class="text-muted">Sin imagen</span>
                @endif
              </td>
              <td class="fw-semibold">{{ $cat->name }}</td>
              <td>{{ $cat->description ?? '—' }}</td>
              <td>
                <form action="{{ route('admin.categoriespublic.destroy', $cat) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar categoría?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-muted py-3">No hay categorías registradas</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
