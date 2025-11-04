@extends('layouts.public')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="login-container">
    <div class="login-card shadow-lg p-4 rounded-4">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo-mota.png') }}" alt="Motorepuestos Mota" class="logo-login">
            <h2 class="text-danger fw-bold mt-2"><i class="bi bi-person-circle"></i> Inicia sesión</h2>
            <p class="text-muted">Accede a tu cuenta para administrar tus pedidos y preferencias.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

       <form action="{{ route('login.perform') }}" method="POST">

            @csrf
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label small text-muted">Recuérdame</label>
                </div>
                <a href="#" class="text-danger small fw-semibold text-decoration-none">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-semibold">Iniciar sesión</button>
        </form>
    </div>
</div>
@endsection
<script src="{{ asset('js/login.js') }}"></script>
