<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Motorepuestos Mota</title>
  <meta name="description" content="Motorepuestos Mota" />

  <!-- Fuentes y Vite -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

 @vite([
    'resources/css/app.css',
    'resources/css/public.css',
    'resources/css/categories.css',
    'resources/js/app.js',
    'resources/js/categories.js'
])

</head>
<body>
  <!-- Incluimos los componentes -->
  @include('public.partials.topbar')
  @include('public.partials.navbar2')
    @include('public.partials.servicios')
  @include('public.partials.footer2')

  <!-- Modal global -->
  @include('public.partials.quickview')
</body>
</html>
