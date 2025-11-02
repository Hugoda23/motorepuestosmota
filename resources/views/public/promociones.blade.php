@extends('layouts.public')

@section('title', 'Promociones Motorepuestos Mota')

@section('content')

<!-- Estilos -->
<link rel="stylesheet" href="{{ asset('css/public.css') }}">
<link rel="stylesheet" href="{{ asset('css/public/hero.css') }}">
<link rel="stylesheet" href="{{ asset('css/public/promociones.css') }}">
<script src="{{ asset('js/public/promociones.js') }}" defer></script>

@php
  $today = now();
@endphp

@if($promotions->isEmpty())
<section class="promo-empty">
  <div class="container text-center">
    <div class="p-5 rounded-4 shadow-lg bg-white mx-auto animate__animated animate__fadeIn" style="max-width: 600px;">
      <div class="mb-4">
        <i class="bi bi-megaphone-fill text-danger display-2" style="animation: pulseIcon 2s infinite;"></i>
      </div>
      <h3 class="fw-bold text-dark mb-3">No hay promociones activas por el momento</h3>
      <p class="text-muted mb-4 fs-5">
        Estamos preparando <span class="fw-semibold text-danger">nuevas ofertas</span> para ti.<br>
        Vuelve pronto para descubrirlas 🚀
      </p>
      <a href="{{ url('/') }}" class="btn btn-danger fw-semibold rounded-pill px-4 py-2 shadow-sm glow-on-hover">
        <i class="bi bi-house-door me-2"></i> Volver al inicio
      </a>
    </div>
  </div>
</section>
@endif

<div class="container py-5">
  <div class="row g-4">
    @foreach($promotions as $promo)
      @if($promo->is_published && 
          (!$promo->start_date || $promo->start_date <= $today) && 
          (!$promo->end_date || $promo->end_date >= $today))
        
        <!-- Card Promo -->
        <div class="col-md-4">
          <div class="card shadow-lg border-0 rounded-4 h-100 overflow-hidden promo-card position-relative">

            <!-- Imagen principal -->
            @if($promo->image)
              <img src="{{ asset($promo->image) }}" class="card-img-top" alt="{{ $promo->title }}">
            @endif

            <!-- 🟢 Etiqueta de vigencia (sobre la imagen) -->
            @if($promo->end_date && $today->lt($promo->end_date))
              <span class="badge bg-success position-absolute top-0 end-0 m-2 shadow-sm rounded-pill px-3 py-2 fs-6">
                <i class="bi bi-check-circle me-1"></i> Activa
              </span>
            @elseif($promo->end_date && $today->gt($promo->end_date))
              <span class="badge bg-secondary position-absolute top-0 end-0 m-2 shadow-sm rounded-pill px-3 py-2 fs-6">
                <i class="bi bi-clock-history me-1"></i> Expirada
              </span>
            @endif

            <!-- Contenido -->
            <div class="card-body">
              <h5 class="fw-bold text-dark mt-2">{{ $promo->title }}</h5>
              <p class="text-muted small mb-2">{{ $promo->subtitle }}</p>

              <div class="mb-2">
                <span class="fw-bold fs-5 text-danger">Q{{ number_format($promo->price,2) }}</span>
                @if($promo->old_price)
                  <span class="text-muted text-decoration-line-through ms-2">
                    Q{{ number_format($promo->old_price,2) }}
                  </span>
                @endif
              </div>

              <p class="text-success small fw-semibold mb-2">{{ $promo->benefits }}</p>

              @if($promo->start_date && $promo->end_date)
                <p class="text-muted small mb-3">
                  <i class="bi bi-calendar3 me-1"></i>
                  Vigencia:
                  <strong>{{ \Carbon\Carbon::parse($promo->start_date)->format('d/m/Y') }}</strong> -
                  <strong>{{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}</strong>
                </p>
              @endif

              <a href="https://wa.me/50231527117?text=Hola%20quiero%20más%20información%20sobre%20{{ urlencode($promo->title) }}"
                 class="btn btn-danger w-100 fw-semibold rounded-pill">
                 <i class="bi bi-whatsapp"></i> Consultar promoción
              </a>
            </div>
          </div>
        </div>
      @endif
    @endforeach
  </div>
</div>

@endsection
