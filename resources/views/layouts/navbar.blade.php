<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="#">MiMarca</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
        @guest
  <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
  <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
@else
  <li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
       {{ Auth::user()->name }}
    </a>

    <div class="dropdown-menu dropdown-menu-end">
      <a class="dropdown-item" href="{{ route('home') }}">Panel</a>
      <a class="dropdown-item" href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         Cerrar sesión
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
    </div>
  </li>
@endguest

      </ul>
    </div>
  </div>
</nav>
