@extends('layouts.public')

@section('content')
<section class="py-5 bg-light border-top border-bottom">
  <div class="container">
    
    <!-- === Encabezado === -->
    <div class="text-center mb-5">
      <h2 class="fw-bold text-uppercase" style="color:#dc2626;">{{ $product->name }}</h2>
      <p class="text-muted">{{ $product->subcategorypublic->name ?? '' }}</p>
    </div>

    <div class="row align-items-center g-4">
      <!-- Imagen -->
      <div class="col-md-6 text-center">
        @if($product->image)
          <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded shadow" style="max-height:400px; object-fit:cover;">
        @else
          <div class="bg-secondary text-white py-5 rounded">Sin imagen disponible</div>
        @endif
      </div>

      <!-- Información -->
      <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4">
          <h3 class="fw-bold text-uppercase mb-3" style="color:#dc2626;">{{ $product->name }}</h3>
          <p class="text-muted">{{ $product->description }}</p>
          
          @if($product->features)
            <div class="mt-3">
              <h6 class="fw-semibold text-uppercase text-secondary">Características</h6>
              <p class="mb-0">{{ $product->features }}</p>
            </div>
          @endif

          <div class="mt-4">
            <a href="javascript:history.back()" class="btn btn-outline-danger me-2">
              <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button class="btn btn-danger fw-semibold">
              <i class="bi bi-cart3 me-1"></i> Agregar al carrito
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- === Productos relacionados === -->
    @if($related->isNotEmpty())
      <div class="mt-5 pt-4 border-top">
        <h4 class="fw-bold text-uppercase mb-4" style="color:#b91c1c;">Productos Relacionados</h4>
        <div class="row g-4">
          @foreach($related as $r)
            <div class="col-md-3 col-sm-6">
              <div class="card border-0 shadow-sm hover-card transition h-100">
                <a href="{{ route('public.product.show', $r->slug) }}" class="text-decoration-none">
                  @if($r->image)
                    <img src="{{ asset('storage/'.$r->image) }}" class="card-img-top" style="height:180px; object-fit:cover;">
                  @endif
                  <div class="card-body text-center">
                    <h6 class="fw-bold text-uppercase text-danger">{{ $r->name }}</h6>
                    <small class="text-muted">{{ Str::limit($r->description, 50) }}</small>
                  </div>
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  </div>
</section>

<style>
.hover-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.transition { transition: all 0.3s ease; }
</style>
@endsection
