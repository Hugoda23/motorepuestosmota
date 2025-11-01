@extends('layouts.public')

@section('content')
<section class="py-5 bg-light border-top border-bottom">
  <div class="container">
    
    <div class="text-center mb-5">
      <h2 class="fw-bold text-uppercase" style="color:#dc2626; letter-spacing:1px;">
        {{ $subcategory->name }}
      </h2>
      <p class="text-muted">Categoría: <strong>{{ $category->name }}</strong></p>
    </div>

    @if($products->isEmpty())
      <div class="text-center text-muted py-5">
        <i class="bi bi-box-seam display-6 d-block mb-2"></i>
        No hay productos publicados en esta subcategoría.
      </div>
    @else
      <div class="row g-4">
        @foreach($products as $p)
          <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 h-100 hover-shadow transition">
              @if($p->image)
                <img src="{{ asset('storage/'.$p->image) }}" class="card-img-top" style="height:220px; object-fit:cover;">
              @endif
              <div class="card-body">
                <h5 class="fw-bold text-uppercase" style="color:#dc2626;">{{ $p->name }}</h5>
                <p class="text-muted small mb-2">{{ Str::limit($p->description, 80) }}</p>
                @if($p->features)
                  <p class="small text-secondary"><i class="bi bi-gear me-1"></i>{{ $p->features }}</p>
                @endif
                <a href="{{ route('public.product.show', $p->slug) }}" class="btn btn-danger w-100 fw-semibold mt-2">
  Ver detalles
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
</style>
@endsection
