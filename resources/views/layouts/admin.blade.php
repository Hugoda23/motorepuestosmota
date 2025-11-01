<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Administrativo - Motorepuestos Mota</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --admin-primary: #0ea5e9;
      --admin-dark: #0f172a;
      --admin-light: #f8fafc;
    }

    body {
      font-family: "Poppins", sans-serif;
      background-color: var(--admin-light);
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: var(--admin-dark);
      color: #fff;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
    }

    .sidebar .logo {
      font-size: 1.25rem;
      font-weight: 600;
      color: #fff;
      text-align: center;
      padding: 1.2rem 0;
      border-bottom: 1px solid rgba(255,255,255,.1);
    }

    .sidebar a {
      color: #cbd5e1;
      text-decoration: none;
      display: block;
      padding: 0.8rem 1.25rem;
      font-size: 0.95rem;
      transition: all 0.15s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: rgba(255,255,255,.1);
      color: #fff;
    }

    /* Contenido */
    .admin-content {
      margin-left: 240px;
      padding: 1.5rem;
      min-height: 100vh;
      background-color: var(--admin-light);
    }

    /* Navbar superior */
    .topbar {
      position: sticky;
      top: 0;
      z-index: 10;
      background-color: #fff;
      border-bottom: 1px solid #e2e8f0;
      padding: 0.75rem 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .topbar h5 {
      font-weight: 600;
      color: var(--admin-dark);
    }

    .user-menu i {
      font-size: 1.25rem;
      color: var(--admin-dark);
    }

    /* Botón guardado */
    .btn-primary {
      background-color: var(--admin-primary);
      border-color: var(--admin-primary);
    }

    .btn-primary:hover {
      background-color: #0284c7;
      border-color: #0284c7;
    }

    @media (max-width: 991px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }
      .admin-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="bi bi-gear-fill me-2 text-info"></i>Admin Mota
    </div>
    <nav class="flex-grow-1">
      <a href="{{ route('admin.hero.edit') }}" class="{{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
        <i class="bi bi-image me-2"></i> Hero Section
      </a>
      <a href="#">
        <i class="bi bi-box-seam me-2"></i> Productos
      </a>
      <a href="#">
        <i class="bi bi-tags me-2"></i> Categorías
      </a>
      <a href="#">
        <i class="bi bi-people me-2"></i> Clientes
      </a>
    </nav>
    <div class="p-3 border-top">
      <a href="/" class="btn btn-sm btn-outline-light w-100">
        <i class="bi bi-arrow-left"></i> Volver al sitio
      </a>
    </div>
  </aside>

  <!-- Contenido -->
  <main class="admin-content">
    <div class="topbar">
      <h5>@yield('title', 'Panel de administración')</h5>
      <div class="user-menu">
        <i class="bi bi-person-circle"></i>
      </div>
    </div>

    <div class="py-3">
      @yield('content')
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
