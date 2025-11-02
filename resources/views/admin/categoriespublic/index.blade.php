@extends('layouts.app')

@section('content')
<div class="container py-4">
  
  <!-- 🔹 Encabezado -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-danger"><i class="bi bi-tags-fill me-2"></i> Categorías</h2>
  </div>

  <!-- 🔹 Mensaje de éxito -->
  @if(session('success'))
    <div class="alert alert-success shadow-sm">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
  @endif

  <!-- ==========================
       FORMULARIO NUEVA CATEGORÍA
  =========================== -->
  <div class="card shadow-sm mb-4 border-0 rounded-4">
    <div class="card-header bg-danger text-white fw-semibold rounded-top-4">
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
          <button type="submit" class="btn btn-danger px-4">
            <i class="bi bi-save2 me-2"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ==========================
       LISTADO DE CATEGORÍAS
  =========================== -->
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-dark text-white fw-semibold rounded-top-4">
      <i class="bi bi-collection me-2"></i> Categorías registradas
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-danger text-center">
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
              <td class="fw-semibold">{{ $cat->id }}</td>

              <td>
                @if($cat->image && file_exists(public_path($cat->image)))
                  <img src="{{ asset($cat->image) }}" width="70" height="70" class="rounded shadow-sm object-fit-cover border">
                @else
                  <span class="text-muted fst-italic">Sin imagen</span>
                @endif
              </td>

              <td class="fw-semibold">{{ $cat->name }}</td>
              <td>{{ $cat->description ?? '—' }}</td>

              <td>
                <form action="{{ route('admin.categoriespublic.destroy', $cat) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger rounded-pill" 
                          onclick="return confirm('¿Eliminar la categoría {{ $cat->name }}?')">
                    <i class="bi bi-trash3"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-muted py-3">
                <i class="bi bi-inboxes"></i> No hay categorías registradas.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Paginación -->
  <div class="mt-3">
    {{ $categories->links() }}
  </div>

</div>
@endsection
