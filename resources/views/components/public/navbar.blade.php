<nav class="navbar navbar-expand-lg py-3 shadow-sm bg-white">
  <div class="container">
    <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
      <img src="{{ asset('assets/img/logo-mota.png') }}" style="height:45px;" alt="Motorepuestos Mota">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link fw-semibold {{ request()->is('/') ? 'text-danger' : 'text-dark' }}">Inicio</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/#categorias') }}" class="nav-link fw-semibold text-dark">Categorías</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/contacto') }}" class="nav-link fw-semibold text-dark">Contacto</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
