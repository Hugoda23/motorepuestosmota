<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Motorepuestos Mota')</title>

    <!-- =============================
         🎨 Estilos principales
    ============================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- =============================
         💅 Estilos personalizados
    ============================== -->
    <link rel="stylesheet" href="{{ asset('css/public/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/servicios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/destacados.css') }}">



    <!-- =============================
         ⚙️ Estilos base del layout
    ============================== -->
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
    <!-- =============================
         🔺 Navbar principal
    ============================== -->
    <nav class="navbar navbar-expand-lg py-3 shadow-sm">
        <div class="container">
            <!-- 🔹 Logo -->
            <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('assets/img/logo-mota.png') }}" alt="Motorepuestos Mota" style="height:45px;">
            </a>

            <!-- 🔹 Botón responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic"
                aria-controls="navbarPublic" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- 🔹 Enlaces -->
            <div class="collapse navbar-collapse" id="navbarPublic">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link fw-semibold text-dark">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/#categorias') }}" class="nav-link fw-semibold text-dark">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/contacto') }}" class="nav-link fw-semibold text-dark">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-danger fw-semibold ms-lg-3">
                            <i class="bi bi-person-circle me-1"></i> Ingresar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- =============================
         📦 Contenido dinámico
    ============================== -->
    <main class="py-5">
        @yield('content')
    </main>

    <!-- =============================
         ⚙️ Footer
    ============================== -->
    <footer class="text-center py-4 border-top mt-5">
        <small class="text-muted">
            © {{ date('Y') }} Motorepuestos Mota — Todos los derechos reservados.
        </small>
    </footer>

    <!-- =============================
         ⚡ Scripts globales
    ============================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
