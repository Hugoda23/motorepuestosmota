<section class="py-5 bg-light border-top border-bottom">
  <div class="container">

    <h2 class="text-center fw-bold mb-5 text-uppercase" style="color:#dc2626; letter-spacing:1px;">
      CATEGORÍAS
    </h2>

    <!-- === CATEGORÍAS PRINCIPALES === -->
    <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
      @foreach($categories as $cat)
        <button 
          class="btn main-cat px-4 py-2 fw-semibold shadow-sm"
          data-target="#cat-{{ $cat->slug }}"
          style="
            background-color:#dc2626;
            color:#fff;
            border:none;
            border-radius:12px;
            letter-spacing:0.5px;
            text-transform:uppercase;
            transition:all 0.3s ease;
          "
          onmouseover="this.style.backgroundColor='#b91c1c'; this.style.transform='translateY(-3px)';"
          onmouseout="this.style.backgroundColor='#dc2626'; this.style.transform='translateY(0)';"
        >
          {{ $cat->name }}
        </button>
      @endforeach
    </div>

    <!-- === SUBCATEGORÍAS DINÁMICAS === -->
    @foreach($categories as $cat)
      <div 
        id="cat-{{ $cat->slug }}" 
        class="subcats d-none flex-wrap gap-3 justify-content-center mt-4 animate__animated animate__fadeIn"
      >
        @forelse($cat->subcategories as $sub)
          <a 
            href="{{ url('/categoria/'.$cat->slug.'/'.$sub->slug) }}" 
            class="category-pill text-decoration-none px-4 py-2 fw-semibold"
            style="
              border:2px solid #dc2626;
              color:#dc2626;
              background:#fff;
              border-radius:30px;
              transition:all 0.3s ease;
            "
            onmouseover="this.style.backgroundColor='#dc2626'; this.style.color='#fff'; this.style.transform='scale(1.08)';"
            onmouseout="this.style.backgroundColor='#fff'; this.style.color='#dc2626'; this.style.transform='scale(1)';"
          >
            {{ $sub->name }}
          </a>
        @empty
          <span class="text-muted fst-italic">No hay subcategorías disponibles</span>
        @endforelse
      </div>
    @endforeach

  </div>
</section>
@include('public.sections.featured')
@include('public.sections.vision-mision')
@include('public.sections.ubicacion')

<!-- Animación y script -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
  // Mostrar solo la categoría seleccionada
  document.querySelectorAll('.main-cat').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.subcats').forEach(el => el.classList.add('d-none'));
      const target = document.querySelector(btn.dataset.target);
      if (target) target.classList.remove('d-none');
    });
  });
</script>
