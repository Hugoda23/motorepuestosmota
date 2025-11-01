@php
  use App\Models\HeroSection;
  $hero = HeroSection::first();
@endphp

<header class="hero position-relative bg-black text-white py-5 overflow-hidden">
  <div class="container">
    <div class="row align-items-center g-4">

      <div class="col-lg-6">
        @if($hero?->title)
          <h1 class="display-4 fw-bold mb-3">{{ $hero->title }}</h1>
        @endif

        @if($hero?->subtitle)
          <p class="lead mb-4 text-light opacity-75">{{ $hero->subtitle }}</p>
        @endif

        @if($hero?->button_text && $hero?->button_link)
          <a href="{{ $hero->button_link }}" class="btn btn-danger btn-lg px-4 fw-semibold">
            <i class="bi bi-bag-check me-2"></i> {{ $hero->button_text }}
          </a>
        @endif
      </div>

      <div class="col-lg-6 text-end">
        @if($hero?->image)
          <img src="{{ asset('storage/'.$hero->image) }}" class="img-fluid rounded-4" alt="Hero">
        @endif
      </div>

    </div>
  </div>
</header>
