<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta name="google" content="notranslate">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- 🧩 Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <!-- 🧩 Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- 🧩 Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- 🧩 Custom Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/public.css') }}">
  <link rel="stylesheet" href="{{ asset('css/public/categories.css') }}">

  <!-- 🎨 Estilos generales -->
  <style>
    body {
      font-family: 'Nunito', sans-serif;
      background-color: #f9fafb;
    }

    .navbar {
      z-index: 1000;
    }

    .sidebar {
      width: 240px;
      background-color: #0f172a;
      color: #fff;
      position: fixed;
      height: 100vh;
    }

    .sidebar a {
      color: #e2e8f0;
      text-decoration: none;
      display: block;
      padding: 0.75rem 1rem;
      border-radius: 0.375rem;
      transition: all 0.2s ease-in-out;
    }

    .sidebar a:hover {
      color: #0ea5e9;
      background-color: rgba(255,255,255,0.05);
    }

    .sidebar .active {
      background-color: #0ea5e9;
      color: #fff;
    }
  </style>

  <!-- 🔥 Estilos adicionales de vistas (roles.css, usuarios.css, etc.) -->
  @stack('styles')
</head>

<body>
  <div id="app" class="d-flex">

    <!-- 🧭 Sidebar -->
    @include('admin.layouts.navigation')

    <!-- 🧩 Contenido principal -->
    <div class="flex-grow-1" style="margin-left:240px; transition:margin .3s ease;">

      <!-- 🧱 Navbar superior -->
      <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-center">
              @guest
                @if (Route::has('login'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                @endif
                @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
                @endif
              @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Cerrar sesión') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
              @endguest

              <!-- 🌙 Botón de modo oscuro -->
              <li class="nav-item ms-3">
                <button id="themeToggle" class="btn btn-outline-secondary btn-sm">
                  <i class="bi bi-moon-fill"></i>
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- 🧾 Contenido dinámico -->
      <main class="py-4 px-4">
        @yield('content')
      </main>
    </div>
  </div>

  <!-- 🧩 Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



  <script>
    // Ocultar modal tras crear producto (Livewire)
    window.addEventListener('product-created', () => {
      const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
      if (modal) modal.hide();
    });

    // 🌗 Modo oscuro básico
    document.getElementById('themeToggle').addEventListener('click', function() {
      document.body.classList.toggle('bg-dark');
      document.body.classList.toggle('text-light');
    });
  </script>

  <!-- 📝 CKEditor -->
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
  <script src="{{ asset('js/ckeditor-init.js') }}"></script>

  <!-- ⚙️ Scripts adicionales (roles.js, usuarios.js, etc.) -->
  @stack('scripts')
    <!-- 🔐 Variables globales de Laravel para JS -->
  <script>
    window.Laravel = {
      vapidKey: "{{ config('webpush.vapid.public_key') }}",
      csrfToken: "{{ csrf_token() }}",
      userId: {{ Auth::check() ? Auth::id() : 'null' }}
    };
  </script>

    <!-- ✅ Script que registra Service Worker + recordatorios -->
  <script src="/js/app.js" defer></script>
</body>
</html>
