<!-- resources/views/admin/layouts/navigation.blade.php -->
<nav class="sidebar bg-dark text-white position-fixed vh-100 p-3" style="width:240px;">
  <h5 class="text-uppercase mb-4 fw-bold">Admin Panel</h5>
  <ul class="nav flex-column">

    <!-- 🔹 Dashboard -->
    <li class="nav-item mb-2">
      <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>

 <!-- 🔹 Página de Inicio (submenu) -->
<li class="nav-item mb-2">
  <a class="nav-link text-white d-flex justify-content-between align-items-center" 
     data-bs-toggle="collapse" href="#paginaInicioMenu" role="button" aria-expanded="false" aria-controls="paginaInicioMenu">
    <span><i class="bi bi-house-door-fill me-2"></i> Página de Inicio</span>
    <i class="bi bi-chevron-down small"></i>
  </a>

  <div class="collapse ps-3 mt-2" id="paginaInicioMenu">
    <ul class="nav flex-column small">

      <!-- 🦸‍♂️ Hero -->
      <li class="nav-item mb-1">
        <a href="{{ route('admin.hero.edit') }}" class="nav-link text-white">
          <i class="bi bi-image-alt me-2"></i> Hero
        </a>
      </li>

      <!-- 🏷️ Categorías -->
      <li class="nav-item mb-1">
        <a href="{{ route('admin.categoriespublic.index') }}" class="nav-link text-white">
          <i class="bi bi-tags-fill me-2"></i> Categorías
        </a>
      </li>

      <!-- 🏷️ Subcategorías -->
      <li class="nav-item mb-1">
        <a href="{{ route('admin.subcategoriespublic.index') }}" class="nav-link text-white">
          <i class="bi bi-diagram-3-fill me-2"></i> Subcategorías
        </a>
      </li>

      <!-- 📦 Productos -->
      <li class="nav-item mb-1">
        <a href="{{ route('admin.productspublic.index') }}" class="nav-link text-white">
          <i class="bi bi-box-seam me-2"></i> Productos
        </a>
      </li>

      <!-- 🎯 Promociones -->
      <li class="nav-item mb-1">
        <a href="{{ route('admin.promotions.index') }}" class="nav-link text-white">
          <i class="bi bi-megaphone-fill me-2 text-warning"></i> Promociones
        </a>
      </li>

    </ul>
  </div>
</li>

    <!-- 🔹 Cerrar Sesión -->
    <li class="nav-item mt-3">
      <a href="{{ route('logout') }}" 
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
         class="nav-link text-danger fw-semibold">
        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </li>
  </ul>
</nav>
