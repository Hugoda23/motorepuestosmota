<!-- resources/views/admin/layouts/navigation.blade.php -->
<nav class="sidebar bg-dark text-white position-fixed vh-100 p-3" style="width:240px;">
  <h5 class="text-uppercase mb-4 fw-bold">Admin Panel</h5>
  <ul class="nav flex-column">
    <li class="nav-item mb-2">
     <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
    <i class="bi bi-speedometer2 me-2"></i> Dashboard
</a>

    </li>
    <li class="nav-item mb-2">
      <a href="{{ route('admin.products.index') }}" class="nav-link text-white">
        <i class="bi bi-box-seam me-2"></i> Productos
      </a>
    </li>
     </li>
    <li class="nav-item mb-2">
      <a href="{{ route('admin.hero.edit') }}" class="nav-link text-white">
        <i class="bi bi-box-seam me-2"></i> Hero
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
        <i class="bi bi-tags me-2"></i> Categorías
      </a>
    </li>
    <li class="nav-item mb-2">
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
