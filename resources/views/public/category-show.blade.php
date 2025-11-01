@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold text-uppercase">{{ $category->name }}</h1>
    <h2 class="text-primary">{{ $subcategory->name }}</h2>
    <p class="text-muted">{{ $subcategory->description }}</p>
  </div>

  <div class="row g-4">
    @forelse($products as $product)
      <div class="col-md-4 col-lg-3">
        <div class="card h-100 border-0 shadow-sm">
          <div class="ratio ratio-1x1">
            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top rounded" style="object-fit: cover;">
          </div>
          <div class="card-body">
            <h5 class="fw-semibold">{{ $product->name }}</h5>
            <p class="small text-muted">{{ Str::limit($product->description, 80) }}</p>
            <button class="btn btn-outline-primary btn-sm w-100">
              <i class="bi bi-info-circle"></i> Ver más
            </button>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-5">
        <i class="bi bi-emoji-frown display-5 text-muted"></i>
        <p class="mt-3 text-muted">No hay productos publicados aún en esta subcategoría.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection
