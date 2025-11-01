@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-3">{{ $category->name }}</h2>
  <div class="card p-3 shadow-sm">
    @if($category->image)
      <img src="{{ asset('storage/'.$category->image) }}" width="250" class="rounded mb-3">
    @endif
    <p>{{ $category->description }}</p>
    <p><strong>Slug:</strong> {{ $category->slug }}</p>
    <a href="{{ route('admin.categoriespublic.index') }}" class="btn btn-secondary mt-3">
      <i class="bi bi-arrow-left"></i> Volver
    </a>
  </div>
</div>
@endsection
