<x-public.layout title="Inicio - Motorepuestos Mota">

  <!-- ===============================
        HERO DINÁMICO PRINCIPAL
  ================================== -->
  <section id="hero" class="position-relative overflow-hidden bg-light">
    <div class="container position-relative py-5">
      @if(!empty($hero) && $hero->image)
        <div class="position-absolute top-0 start-0 w-100 h-100">
          <img src="{{ asset('storage/'.$hero->image) }}" 
               alt="Hero Image" 
               class="w-100 h-100 object-fit-cover opacity-75">
        </div>
      @endif

      <div class="position-relative text-center text-white py-5" style="z-index: 2;">
        <h1 class="display-4 fw-bold text-uppercase mb-3 animate__animated animate__fadeInDown">
          {{ $hero->title ?? 'Motorepuestos Mota' }}
        </h1>

        @if(!empty($hero->subtitle))
          <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
            {{ $hero->subtitle }}
          </p>
        @endif

        @if(!empty($hero->button_text) && !empty($hero->button_link))
          <a href="{{ $hero->button_link }}" 
             class="btn btn-danger btn-lg rounded-pill shadow-sm mt-3 animate__animated animate__zoomIn animate__delay-2s">
             <i class="bi bi-cart me-2"></i>{{ $hero->button_text }}
          </a>
        @endif
      </div>
    </div>

    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0.4)); z-index: 1;">
    </div>
  </section>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="{{ asset('css/public.css') }}">

  <!-- ===============================
        SECCIONES DINÁMICAS
  ================================== -->
  @include('public.sections.categorias')
  @include('public.sections.destacados')
  @include('public.sections.vision-mision')
  @include('public.sections.ubicacion')

</x-public.layout>
