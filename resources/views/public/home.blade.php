<x-public.layout title="Inicio - Motorepuestos Mota">

<!-- ===============================
      HERO PRINCIPAL MEJORADO
================================== -->
<section id="hero" class="hero-elegant d-flex align-items-center overflow-hidden">
  <div class="container-fluid px-5">
    <div class="row align-items-center justify-content-between">

      <!-- 🔹 Texto principal -->
      <div class="col-lg-6 col-md-7 text-white z-2 position-relative">
        <h1 class="display-3 fw-bold mb-4 text-uppercase animate__animated animate__fadeInLeft">
          {{ $hero->title ?? 'Motorepuestos Mota' }}
        </h1>

        @if(!empty($hero->subtitle))
          <p class="lead fs-4 text-light opacity-75 mb-4 animate__animated animate__fadeInUp">
            {{ $hero->subtitle }}
          </p>
        @endif

        @if(!empty($hero->button_text) && !empty($hero->button_link))
          <a href="{{ $hero->button_link }}" 
             class="btn btn-danger btn-lg rounded-pill shadow-lg px-5 animate__animated animate__zoomIn animate__delay-1s">
             <i class="bi bi-cart-fill me-2"></i>{{ $hero->button_text }}
          </a>
        @endif
      </div>

      <!-- 🔹 Imagen animada a la derecha -->
      <div class="col-lg-5 col-md-5 text-center position-relative z-2">
        @if(!empty($hero) && !empty($hero->image) && file_exists(public_path($hero->image)))
          <img src="{{ asset($hero->image) }}" 
               alt="Hero Image"
               class="img-fluid hero-floating-img animate-float">
        @else
          <img src="{{ asset('images/default-hero.png') }}" 
               alt="Motorepuestos Mota"
               class="img-fluid hero-floating-img animate-float">
        @endif
      </div>

    </div>
  </div>

  <!-- 🔹 Overlay y fondo degradado -->
  <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

  <!-- 🔹 Separador visual -->
  <div class="hero-separator"></div>
</section>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="{{ asset('css/public.css') }}">
<link rel="stylesheet" href="{{ asset('css/public/hero.css') }}">
<link rel="stylesheet" href="{{ asset('css/public/destacados.css') }}">


<!-- ===============================
      SECCIONES DINÁMICAS
================================== -->
<section id="categorias">
  @include('public.sections.categorias')
</section>

<section id="destacados">
  @include('public.sections.destacados')
</section>

<section id="vision-mision">
  @include('public.sections.vision-mision')
</section>

<section id="ubicacion">
  @include('public.sections.ubicacion')
</section>

</x-public.layout>
