<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Motorepuestos Mota')</title>

    <!-- ✅ Estilos principales -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ✅ Tus estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/public/contact.css') }}">

    <!-- ✅ Estilos básicos del layout -->
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Poppins', sans-serif;
        }

        header.navbar {
            background-color: #fff;
            border-bottom: 2px solid #dc2626; /* 🔴 rojo Honda */
        }

        footer {
            background-color: #fff;
        }

        footer small {
            color: #6b7280;
        }
    </style>
</head>
<body>

    <!-- 🔹 Navbar simple -->
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('assets/img/logo-mota.png') }}" style="height:45px;" alt="Motorepuestos Mota">
            </a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link fw-semibold text-dark">Inicio</a></li>
                    <li class="nav-item"><a href="{{ url('/#categorias') }}" class="nav-link fw-semibold text-dark">Categorías</a></li>
                    <li class="nav-item"><a href="{{ url('/contacto') }}" class="nav-link fw-semibold text-dark">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🔹 Contenido dinámico -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- 🔹 Footer -->
    <footer class="text-center py-4 border-top mt-5">
        <small>© {{ date('Y') }} Motorepuestos Mota — Todos los derechos reservados.</small>
    </footer>

    <!-- ✅ Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
