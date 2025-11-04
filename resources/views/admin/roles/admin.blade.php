@extends('layouts.app')

@section('title', 'Gestión de Roles')
@section('header', 'Roles de Usuario')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">
        <i class="bi bi-person-gear text-primary me-2"></i> Gestión de Roles
      </h4>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createRoleModal">
        <i class="bi bi-plus-circle me-1"></i> Nuevo Rol
      </button>
    </div>

    @if (session('success'))
      <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger py-2">
        {{ $errors->first() }}
      </div>
    @endif

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Nombre (interno)</th>
            <th>Nombre visible</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $role)
          <tr>
            <td>{{ $role->id }}</td>
            <td><span class="fw-semibold text-primary">{{ $role->name }}</span></td>
            <td>{{ $role->display_name ?? '—' }}</td>
            <td class="text-center">
              <button class="btn btn-warning btn-sm text-white me-1" 
                      data-bs-toggle="modal" 
                      data-bs-target="#editRoleModal{{ $role->id }}">
                <i class="bi bi-pencil-square"></i>
              </button>
              <form action="{{ route('admin.roles.destroy', $role->id) }}" 
                    method="POST" 
                    class="d-inline"
                    onsubmit="return confirm('¿Seguro que deseas eliminar este rol?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </td>
          </tr>

          <!-- 🟨 Modal Editar -->
          <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-white">
                  <h5 class="modal-title">Editar Rol</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Nombre interno</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                    <small class="text-muted">Ejemplo: admin, empleado, cliente</small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Nombre visible</label>
                    <input type="text" name="display_name" class="form-control" value="{{ $role->display_name }}">
                    <small class="text-muted">Ejemplo: Administrador</small>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Actualizar</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- 🟩 Modal Crear -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.roles.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Crear Rol</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nombre interno</label>
          <input type="text" name="name" class="form-control" placeholder="admin, empleado..." required>
        </div>
        <div class="mb-3">
          <label class="form-label">Nombre visible</label>
          <input type="text" name="display_name" class="form-control" placeholder="Administrador, Empleado...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/roles.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/roles.js') }}" defer></script>
@endpush
