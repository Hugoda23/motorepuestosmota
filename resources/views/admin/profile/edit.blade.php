@extends('layouts.app')

@section('title', 'Mi perfil')
@section('header', 'Configuración de Perfil')

@section('content')
<div class="row">
  {{-- Datos básicos --}}
  <div class="col-md-6 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white border-0">
        <h5 class="mb-0">
          <i class="bi bi-person-circle text-primary me-2"></i>
          Información de usuario
        </h5>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label fw-semibold">Nombre</label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}"
                   required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Correo electrónico</label>
            <input type="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}"
                   required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Guardar cambios
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- Cambio de contraseña --}}
  <div class="col-md-6 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white border-0">
        <h5 class="mb-0">
          <i class="bi bi-shield-lock text-danger me-2"></i>
          Cambiar contraseña
        </h5>
      </div>
      <div class="card-body">
        @if ($errors->has('current_password') || $errors->has('password'))
          <div class="alert alert-danger alert-dismissible fade show">
            <strong>Revisa los errores en el formulario.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <form action="{{ route('admin.profile.password') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label fw-semibold">Contraseña actual</label>
            <input type="password"
                   name="current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   required>
            @error('current_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Nueva contraseña</label>
            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Confirmar nueva contraseña</label>
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   required>
          </div>

          <button type="submit" class="btn btn-danger">
            <i class="bi bi-key-fill me-1"></i> Actualizar contraseña
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
