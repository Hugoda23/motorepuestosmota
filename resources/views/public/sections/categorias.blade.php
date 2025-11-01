<section id="categorias" class="py-5 bg-light border-top border-bottom">
  <div class="container">
    <h2 class="text-center fw-bold mb-5 text-uppercase text-danger" style="letter-spacing:1px;">
      CATEGORÍAS
    </h2>

    <!-- CATEGORÍAS PRINCIPALES -->
    <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
      @foreach($categories as $cat)
        <button 
          class="btn main-cat px-4 py-2 fw-semibold shadow-sm"
          data-target="#cat-{{ $cat->slug }}">
          {{ $cat->name }}
        </button>
      @endforeach
    </div>

    <!-- SUBCATEGORÍAS -->
    @foreach($categories as $cat)
      <div id="cat-{{ $cat->slug }}" 
           class="subcats d-none flex-wrap gap-3 justify-content-center mt-4 animate__animated animate__fadeIn">
        @forelse($cat->subcategories as $sub)
          <a href="{{ url('/categoria/'.$cat->slug.'/'.$sub->slug) }}" 
             class="category-pill text-decoration-none px-4 py-2 fw-semibold">
             {{ $sub->name }}
          </a>
        @empty
          <span class="text-muted fst-italic">No hay subcategorías disponibles</span>
        @endforelse
      </div>
    @endforeach
  </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="{{ asset('css/public/categorias.css') }}">
<script src="{{ asset('js/public/categorias.js') }}" defer></script>
