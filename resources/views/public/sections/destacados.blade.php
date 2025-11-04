<section id="destacados" class="py-5 border-top border-bottom bg-white">
  <div class="container">

    <!-- Encabezado -->
    <div class="d-flex align-items-end justify-content-between mb-4 flex-wrap">
      <div>
        <h2 class="fw-bold text-uppercase text-danger">Destacados de la semana</h2>
        <p class="text-muted small mb-0">Descubre lo más popular entre nuestros clientes</p>
      </div>

      <div class="d-none d-md-flex gap-2">
        <button class="btn btn-outline-danger btn-sm" data-bs-target="#carouselDestacados" data-bs-slide="prev">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button class="btn btn-outline-danger btn-sm" data-bs-target="#carouselDestacados" data-bs-slide="next">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Carrusel de productos -->
    @if($featured->count() > 0)
      <div id="carouselDestacados" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          @foreach($featured->chunk(4) as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
              <div class="row g-4">
                @foreach($chunk as $product)
                  <div class="col-12 col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">

                      {{-- Imagen del producto --}}
                      @if($product->image && file_exists(public_path($product->image)))
                        <img src="{{ asset($product->image) }}" 
                             alt="{{ $product->title }}" 
                             class="card-img-top" 
                             style="height:200px; object-fit:cover;">
                      @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                          <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                      @endif

                      {{-- Descuento (solo si old_price > price) --}}
                      @if($product->old_price && $product->old_price > $product->price)
                        <span class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end small">
                          -{{ round(100 - ($product->price * 100 / $product->old_price)) }}%
                        </span>
                      @endif

                      {{-- Contenido --}}
                      <div class="card-body text-center">
                        <h5 class="fw-bold text-uppercase text-danger">{{ $product->title }}</h5>

                        @if($product->description)
                          <p class="text-muted small mb-2">{{ Str::limit($product->description, 50) }}</p>
                        @endif

                        <div class="mb-3">
                          @if($product->price)
                            <span class="fw-bold fs-5 text-success">Q{{ number_format($product->price, 2) }}</span>
                          @endif

                          @if($product->old_price)
                            <span class="text-muted text-decoration-line-through small ms-2">
                              Q{{ number_format($product->old_price, 2) }}
                            </span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @else
      <div class="text-center text-muted fst-italic py-5">
        <i class="bi bi-box-seam fs-3 d-block mb-2"></i>
        No hay productos destacados publicados aún.
      </div>
    @endif
  </div>
</section>

<link rel="stylesheet" href="{{ asset('css/public/destacados.css') }}">
<script src="{{ asset('js/public/destacados.js') }}" defer></script>
