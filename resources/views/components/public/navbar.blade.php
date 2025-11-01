<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white sticky-top border-bottom shadow-sm">
  <div class="container">
<!-- Logo / Marca -->
<a class="navbar-brand" href="/">
  <img src="{{ asset('assets/img/logo-mota.png') }}" 
       alt="Motorepuestos Mota" 
       style="height:45px; width:auto;">
</a>


    <!-- Botón para móviles -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
      aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenido del menú -->
    <div class="collapse navbar-collapse" id="mainNav">
      
      <!-- Sección izquierda -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-categories">


  <!-- MENÚ CATEGORÍAS DINÁMICO -->
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle fw-semibold text-dark" href="#" id="dropdownCategorias" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-grid me-1"></i> Categorías
  </a>

  <div class="dropdown-menu shadow-lg border-0 p-3 rounded-3" aria-labelledby="dropdownCategorias" style="min-width: 420px;">
    <div class="row g-4">

      @forelse($categories as $cat)
        <div class="col-6">
          <!-- Nombre de la categoría -->
          <h6 class="dropdown-header text-primary px-0 fw-bold">
            <i class="bi bi-tags-fill me-1 text-danger"></i> {{ $cat->name }}
          </h6>

          <!-- Subcategorías dinámicas -->
          @forelse($cat->subcategories as $sub)
            <a 
              class="dropdown-item py-1 px-0 fw-semibold text-dark"
              href="{{ url('/categoria/'.$cat->slug.'/'.$sub->slug) }}"
              style="transition: all 0.3s ease;"
              onmouseover="this.style.color='#dc2626'; this.style.transform='translateX(4px)';"
              onmouseout="this.style.color=''; this.style.transform='translateX(0)';"
            >
              {{ $sub->name }}
            </a>
          @empty
            <span class="text-muted small fst-italic">Sin subcategorías</span>
          @endforelse
        </div>
      @empty
        <div class="col-12 text-center text-muted fst-italic">
          No hay categorías disponibles
        </div>
      @endforelse

    </div>
  </div>
</li>

        <li class="nav-item">
          <a class="nav-link" href="/productos">
            <i class="bi bi-basket"></i> Productos
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('public.home2') }}">
            <i class="bi bi-tools"></i> Servicios
          </a>
        </li>

        <li class="nav-item">
  <a class="nav-link" href="{{ route('public.promociones') }}">
    <i class="bi bi-tag"></i> Promociones
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ route('public.contact.index') }}">
  <i class="bi bi-envelope"></i> Contacto
</a>

</li>

      <!-- Acciones (usuario / carrito) -->
<div class="d-flex align-items-center gap-2">
  @if(Auth::check())
    <!-- Si el usuario ha iniciado sesión -->
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-box-arrow-right"></i> Salir
      </button>
    </form>
  @else
    <!-- Si el usuario NO ha iniciado sesión -->
    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-danger fw-semibold">
  <i class="bi bi-person-circle"></i> Ingresar
</a>
  @endif
</div>

    </div>
  </div>
</nav>