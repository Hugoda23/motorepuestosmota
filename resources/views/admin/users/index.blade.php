@extends('layouts.app')

@section('title', 'Usuarios')
@section('header', 'Gestión de Usuarios')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
      <i class="bi bi-people-fill me-2 text-primary"></i>Gestión de Usuarios
    </h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
      <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
    </button>
  </div>

  <!-- 🔔 Mensajes -->
  @if (session('success'))
    <div class="alert alert-success py-2">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
  @endif

  <!-- 📋 Tabla -->
  <div class="table-responsive">
    <table id="usersTable" class="table table-bordered table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Rol</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $u->name }}</td>
          <td>{{ $u->email }}</td>
          <td>
            <span class="badge bg-info text-dark">
              {{ $u->role->display_name ?? 'Sin rol' }}
            </span>
          </td>
          <td class="text-center">
            <button class="btn btn-warning btn-sm text-white btn-edit"
              data-id="{{ $u->id }}"
              data-name="{{ $u->name }}"
              data-email="{{ $u->email }}"
              data-role="{{ $u->role_id }}">
              <i class="bi bi-pencil-square"></i>
            </button>

            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
              onsubmit="return confirm('¿Eliminar este usuario?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm">
                <i class="bi bi-trash3"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- 🟩 Modal Crear -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Crear Usuario</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select name="role_id" class="form-select" required>
            <option value="">Seleccionar rol...</option>
            @foreach($roles as $r)
              <option value="{{ $r->id }}">{{ $r->display_name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- 🟦 Modal Editar -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editUserForm" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Editar Usuario</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_user_id">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" id="edit_name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" id="edit_email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select id="edit_role_id" name="role_id" class="form-select" required>
            <option value="">Seleccionar rol...</option>
            @foreach($roles as $r)
              <option value="{{ $r->id }}">{{ $r->display_name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Nueva Contraseña (opcional)</label>
          <input type="password" id="edit_password" name="password" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-warning text-white">Actualizar</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/users.js') }}" defer></script>
@endpush
