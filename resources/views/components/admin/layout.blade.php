@props([
  'title' => 'Panel Administrativo - Motorepuestos Mota',
  'header' => 'Panel de administración',
])

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }}</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Vite CSS -->
  @vite(['resources/css/admin.css', 'resources/js/app.js'])
</head>
<body>

  <!-- Sidebar -->
  <x-admin.sidebar />

  <!-- Contenido principal -->
  <main class="admin-content">
    <x-admin.topbar :title="$header" />

    <div class="py-3 px-3">
      {{ $slot }}
    </div>

    <x-admin.footer />
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
