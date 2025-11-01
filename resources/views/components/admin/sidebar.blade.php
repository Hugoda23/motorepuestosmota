<aside class="sidebar">
  <div class="logo">
    <i class="bi bi-gear-fill me-2 text-info"></i>Admin Mota
  </div>

  <nav class="flex-grow-1">
    <a href="{{ route('admin.hero.edit') }}" class="{{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
      <i class="bi bi-image me-2"></i> Hero Section
    </a>
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
      <i class="bi bi-box-seam me-2"></i> Productos
    </a>
    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
      <i class="bi bi-tags me-2"></i> Categorías
    </a>
    <a href="{{ route('admin.clients.index') }}" class="{{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
      <i class="bi bi-people me-2"></i> Clientes
    </a>
  </nav>

  <div class="p-3 border-top">
    <a href="/" class="btn btn-sm btn-outline-light w-100">
      <i class="bi bi-arrow-left"></i> Volver al sitio
    </a>
  </div>
</aside>
