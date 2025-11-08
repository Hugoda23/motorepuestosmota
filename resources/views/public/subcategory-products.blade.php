@extends('layouts.public')

@section('content')
<section class="py-5 bg-light border-top border-bottom">
  <div class="container">

    <!-- 🔹 Encabezado -->
    <div class="text-center mb-5">
      <h2 class="fw-bold text-uppercase text-danger" style="letter-spacing:1px;">
        {{ $subcategory->name }}
      </h2>
      <p class="text-muted">
        <i class="bi bi-diagram-3 me-1 text-danger"></i>
        Categoría: <strong>{{ $category->name }}</strong>
      </p>
    </div>

    <!-- 🔹 Verificar productos -->
    @if($products->isEmpty())
      <div class="text-center text-muted py-5">
        <i class="bi bi-box-seam display-6 d-block mb-3"></i>
        No hay productos publicados en esta subcategoría.
      </div>
    @else
      <div class="row g-4">
        @foreach($products as $p)
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 h-100 transition rounded-4 overflow-hidden hover-shadow">

              {{-- Imagen del producto --}}
              @if($p->image && file_exists(public_path($p->image)))
                <img src="{{ asset($p->image) }}" class="card-img-top" style="height:220px; object-fit:cover;">
              @else
                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" style="height:220px; object-fit:cover;">
              @endif

              <div class="card-body d-flex flex-column justify-content-between text-center">
                <h5 class="fw-bold text-uppercase text-danger mb-3">{{ $p->name }}</h5>
                <a href="{{ route('public.product.show', $p->slug) }}" 
                   class="btn btn-outline-danger w-100 fw-semibold rounded-pill">
                   <i class="bi bi-eye me-1"></i> Ver detalles
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

<style>
  .hover-shadow:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
  }

  .transition { transition: all 0.3s ease; }

  @media (max-width: 768px) {
    .card-img-top { height: 180px !important; }
  }
</style>
@endsection
