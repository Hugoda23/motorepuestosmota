<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white sticky-top border-bottom shadow-sm">
  <div class="container">

    <!-- 🔧 Logo / Marca -->
    <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="/home2">
      <img src="{{ asset('assets/img/logo-mota.png') }}" 
           alt="Motorepuestos Mota" 
           style="height:45px; width:auto;" class="me-2">
      Taller de Servicios Honda
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

       
        <!-- 🧱 Servicios -->
        <li class="nav-item">
          <a class="nav-link fw-semibold text-dark" href="{{ route('public.home2') }}">
            <i class="bi bi-tools me-1 text-primary"></i> Servicios
          </a>
        </li>

        <!-- 📍 Contacto -->
        <li class="nav-item">
          <a class="nav-link fw-semibold text-dark" href="{{ route('public.contact.index') }}">
            <i class="bi bi-envelope me-1 text-danger"></i> Contacto
          </a>
        </li>
      </ul>

      <!-- Sección derecha (acciones) -->
      <div class="d-flex align-items-center gap-2">
      
       <!-- 👤 Usuario -->
@if(Auth::check())
  <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
      <i class="bi bi-box-arrow-right me-1"></i> Salir
    </button>
  </form>
@else
  <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
    <i class="bi bi-person-circle me-1"></i> Ingresar
  </a>
@endif


        <!-- 💬 WhatsApp -->
        <a href="https://wa.me/50254824532" target="_blank" class="btn btn-sm btn-success rounded-pill fw-semibold">
          <i class="bi bi-whatsapp me-1"></i> Cita
        </a>
      </div>

    </div>
  </div>
</nav>
