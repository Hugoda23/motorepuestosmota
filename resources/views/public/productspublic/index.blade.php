@extends('layouts.public')

@section('title', 'Nuestros Productos')

@section('content')
<style>
  /* === ESTILO PERSONALIZADO DE LAS TARJETAS === */
  .product-card {
    transition: all 0.3s ease-in-out;
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  }

  .product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
  }

  .product-card img {
    height: 220px;
    object-fit: cover;
    border-bottom: 1px solid #f1f1f1;
  }

  .product-card .card-body {
    padding: 1rem 1.25rem;
  }

  .product-card h6 {
    font-weight: 600;
    color: #0f172a;
  }

  .product-card p {
    font-size: 0.9rem;
    color: #6b7280;
  }

  .badge-category {
    background: #0ea5e9;
    color: white;
    font-size: 0.75rem;
    border-radius: 50rem;
    padding: 0.3rem 0.8rem;
  }

  .category-title {
    border-left: 5px solid #0ea5e9;
    padding-left: 10px;
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .btn-outline-primary {
    border-radius: 50rem;
  }
</style>

<section class="py-5 bg-light border-top border-bottom">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Nuestros Productos</h2>

    @foreach($categories as $category)
      <div class="mb-5">
        <h3 class="category-title">{{ strtoupper($category->name) }}</h3>

        @foreach($category->subcategories as $sub)
          <h5 class="fw-semibold mb-3 text-secondary">{{ $sub->name }}</h5>

          <div class="row g-4">
            @forelse($sub->products as $product)
              <div class="col-md-3 col-sm-6">
                <div class="card product-card h-100">
                  @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                  @else
                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="Sin imagen">
                  @endif

                  <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                      <h6>{{ $product->name }}</h6>
                      <p class="mb-2">{{ Str::limit($product->description, 70) }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
  <span class="badge-category">{{ $sub->name }}</span>
  <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">Ver más</a>
</div>

                  </div>
                </div>
              </div>
            @empty
              <p class="text-muted">No hay productos publicados en esta subcategoría.</p>
            @endforelse
          </div>
        @endforeach
      </div>
    @endforeach
  </div>
</section>
@endsection
