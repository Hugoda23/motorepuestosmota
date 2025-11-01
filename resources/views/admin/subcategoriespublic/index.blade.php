@extends('layouts.app')

@section('content')
<div class="container py-4">

  <!-- ENCABEZADO -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold mb-0">
      <i class="bi bi-diagram-3 me-2 text-primary"></i> Subcategorías Públicas
    </h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSubcategoryModal">
      <i class="bi bi-plus-circle"></i> Nueva subcategoría
    </button>
  </div>

  <!-- ALERTAS -->
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- TABLA -->
  <div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Imagen</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody class="text-center">
        @forelse($subcategories as $sub)
          <tr>
            <td>{{ $sub->id }}</td>
            <td class="fw-semibold">{{ $sub->name }}</td>
            <td>{{ $sub->category->name ?? '-' }}</td>
            <td>
              @if($sub->image)
                <img src="{{ asset('storage/'.$sub->image) }}" width="70" class="rounded shadow-sm">
              @else
                <span class="text-muted">Sin imagen</span>
              @endif
            </td>
            <td>{{ Str::limit($sub->description, 40, '...') }}</td>
            <td>
              <form action="{{ route('admin.subcategoriespublic.destroy', $sub) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta subcategoría?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-muted">No hay subcategorías registradas</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- PAGINACIÓN -->
  <div class="mt-3">
    {{ $subcategories->links() }}
  </div>
</div>

<!-- MODAL: CREAR SUBCATEGORÍA -->
<div class="modal fade" id="createSubcategoryModal" tabindex="-1" aria-labelledby="createSubcategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="createSubcategoryModalLabel">
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
                <option value="">-- Selecciona una categoría --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Descripción -->
            <div class="col-12">
              <label for="description" class="form-label fw-semibold">Descripción</label>
              <textarea name="description" id="description" rows="3" class="form-control" placeholder="Descripción breve de la subcategoría..."></textarea>
            </div>

            <!-- Imagen -->
            <div class="col-md-6">
              <label for="image" class="form-label fw-semibold">Imagen</label>
              <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewSubcategoryImage(event)">
            </div>

            <!-- Vista previa -->
            <div class="col-md-6 text-center">
              <label class="form-label fw-semibold d-block">Vista previa</label>
              <img id="previewSubcategory" src="{{ asset('images/placeholder.png') }}" alt="Vista previa" class="img-fluid rounded border" style="max-width: 200px;">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SCRIPT: PREVISUALIZAR IMAGEN -->
<script>
function previewSubcategoryImage(event) {
  const reader = new FileReader();
  reader.onload = function(){
    const output = document.getElementById('previewSubcategory');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
