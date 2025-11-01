

@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title mb-3">Editar sección principal</h5>

      <form method="POST" enctype="multipart/form-data" action="{{ route('admin.hero.update') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Título</label>
          <input type="text" name="title" class="form-control" value="{{ old('title', $hero->title ?? '') }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Subtítulo</label>
          <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $hero->subtitle ?? '') }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Imagen</label>
          <input type="file" name="image" class="form-control">
          @if(!empty($hero->image))
            <img src="{{ asset('storage/'.$hero->image) }}" alt="Hero" width="200" class="mt-3 rounded">
          @endif
        </div>

        <button class="btn btn-primary">Guardar cambios</button>
      </form>
    </div>
  </div>
@endsection
