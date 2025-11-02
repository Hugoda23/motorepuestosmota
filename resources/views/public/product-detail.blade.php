@extends('layouts.public')

@section('content')
<section class="py-5 bg-light border-top border-bottom">
  <div class="container">
    
    <!-- === Encabezado === -->
    <div class="text-center mb-5">
      <h2 class="fw-bold text-uppercase text-danger">{{ $product->name }}</h2>
      <p class="text-muted">
        <i class="bi bi-diagram-3 me-1 text-danger"></i>
        {{ $product->subcategorypublic->name ?? '' }}
      </p>
    </div>

    <div class="row align-items-center g-4">
      <!-- 🖼️ Imagen principal -->
      <div class="col-md-6 text-center">
        @if($product->image && file_exists(public_path($product->image)))
          <img src="{{ asset($product->image) }}" 
               alt="{{ $product->name }}" 
               class="img-fluid rounded shadow"
               style="max-height:400px; object-fit:cover;">
        @else
          <img src="{{ asset('images/no-image.jpg') }}" 
               alt="Sin imagen" 
               class="img-fluid rounded shadow"
               style="max-height:400px; object-fit:cover;">
        @endif
      </div>

      <!-- 📋 Información del producto -->
      <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4">
          <h3 class="fw-bold text-uppercase mb-3 text-danger">{{ $product->name }}</h3>
          <p class="text-muted mb-3">{{ $product->description }}</p>
          
          @if($product->features)
            <div class="mt-3">
              <h6 class="fw-semibold text-uppercase text-secondary">Características</h6>
              <p class="mb-0">{{ $product->features }}</p>
            </div>
          @endif

          <div class="mt-4">
            <a href="javascript:history.back()" class="btn btn-outline-danger fw-semibold rounded-pill">
              <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- === Productos relacionados === -->
    @if($related->isNotEmpty())
      <div class="mt-5 pt-4 border-top">
        <h4 class="fw-bold text-uppercase mb-4 text-danger">
          <i class="bi bi-grid-3x3-gap-fill me-1"></i> Productos Relacionados
        </h4>
        <div class="row g-4">
          @foreach($related as $r)
            <div class="col-md-3 col-sm-6">
              <div class="card border-0 shadow-sm hover-card transition h-100">
                <a href="{{ route('public.product.show', $r->slug) }}" class="text-decoration-none">
                  
                  {{-- Imagen del producto relacionado --}}
                  @if($r->image && file_exists(public_path($r->image)))
                    <img src="{{ asset($r->image) }}" class="card-img-top" style="height:180px; object-fit:cover;">
                  @else
                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" style="height:180px; object-fit:cover;">
                  @endif
                  
                  <div class="card-body text-center">
                    <h6 class="fw-bold text-uppercase text-danger">{{ $r->name }}</h6>
                    <small class="text-muted d-block">{{ Str::limit($r->description, 50) }}</small>
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
