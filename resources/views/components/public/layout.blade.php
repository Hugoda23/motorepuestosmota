@props([
  'title' => 'Motorepuestos Mota',
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

  <!-- Estilos del sitio -->
<link rel="stylesheet" href="{{ asset('css/public.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>

</head>
<body>

  <!-- Navbar -->
  <x-public.navbar />

  <!-- Contenido principal -->
  <main class="py-4">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <x-public.footer />

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
