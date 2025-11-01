@extends('layouts.public')

@section('title', 'Promociones Honda')

@section('content')

<!-- 🏍️ SECCIÓN PROMOCIONES -->
<section class="py-5 bg-light">
  <div class="container">

    <div class="text-center mb-5">
      <h2 class="fw-bold text-danger">🔥 Promociones Exclusivas Honda</h2>
      <p class="text-muted mb-0">Aprovecha las mejores ofertas en motocicletas y servicios de mantenimiento.</p>
    </div>

    <div class="row g-4">

      <!-- 🚨 PROMO 1 -->
      <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 h-100 overflow-hidden promo-card">
          <img src="{{ asset('assets/img/promos/honda1.jpg') }}" class="card-img-top" alt="Honda Wave 110">
          <div class="card-body">
            <h5 class="fw-bold text-dark">Honda Wave 110S</h5>
            <p class="text-muted small mb-2">Con su estilo moderno y rendimiento confiable.</p>
            <div class="mb-2">
              <span class="fw-bold fs-5 text-danger">Q9,999</span>
              <span class="text-muted text-decoration-line-through ms-2">Q11,500</span>
            </div>
            <p class="text-success small fw-semibold">💸 Ahorra Q1,501 + Cambio de aceite gratis</p>
            <a href="https://wa.me/50231527117?text=Hola%20quiero%20más%20información%20sobre%20la%20Honda%20Wave%20110S"
               class="btn btn-danger w-100 fw-semibold rounded-pill">
               <i class="bi bi-whatsapp"></i> Consultar promoción
            </a>
          </div>
        </div>
      </div>

      <!-- 🚨 PROMO 2 -->
      <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 h-100 overflow-hidden promo-card">
          <img src="{{ asset('assets/img/promos/honda2.jpg') }}" class="card-img-top" alt="Honda CB160">
          <div class="card-body">
            <h5 class="fw-bold text-dark">Honda CB160F</h5>
            <p class="text-muted small mb-2">Estilo deportivo, potencia y eficiencia para ciudad y carretera.</p>
            <div class="mb-2">
              <span class="fw-bold fs-5 text-danger">Q18,499</span>
              <span class="text-muted text-decoration-line-through ms-2">Q20,000</span>
            </div>
            <p class="text-success small fw-semibold">🎁 Incluye casco y primer servicio gratuito</p>
            <a href="https://wa.me/50231527117?text=Hola%20quiero%20más%20información%20sobre%20la%20Honda%20CB160F"
               class="btn btn-danger w-100 fw-semibold rounded-pill">
               <i class="bi bi-whatsapp"></i> Consultar promoción
            </a>
          </div>
        </div>
      </div>

      <!-- 🚨 PROMO 3 -->
      <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 h-100 overflow-hidden promo-card">
          <img src="{{ asset('assets/img/promos/honda3.jpg') }}" class="card-img-top" alt="Honda XR190">
          <div class="card-body">
            <h5 class="fw-bold text-dark">Honda XR190L</h5>
            <p class="text-muted small mb-2">La todoterreno más resistente, ideal para trabajo y aventura.</p>
            <div class="mb-2">
              <span class="fw-bold fs-5 text-danger">Q22,999</span>
              <span class="text-muted text-decoration-line-through ms-2">Q25,000</span>
            </div>
            <p class="text-success small fw-semibold">🧰 Incluye kit de herramientas + primer servicio gratis</p>
            <a href="https://wa.me/50231527117?text=Hola%20quiero%20más%20información%20sobre%20la%20Honda%20XR190L"
               class="btn btn-danger w-100 fw-semibold rounded-pill">
               <i class="bi bi-whatsapp"></i> Consultar promoción
            </a>
          </div>
        </div>
      </div>

    </div>

    <!-- SECCIÓN EXTRA -->
    <div class="text-center mt-5">
      <h5 class="fw-semibold text-secondary">
        📍 Visítanos en <span class="text-danger">Motorepuestos Mota</span> y aprovecha estas ofertas limitadas.
      </h5>
      <p class="text-muted small mb-0">Promociones válidas hasta agotar existencias.</p>
    </div>

  </div>
</section>

<style>
  .promo-card {
    transition: all 0.3s ease;
  }

  .promo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 1.5rem rgba(0, 0, 0, 0.1);
  }

  .promo-card img {
    height: 210px;
    object-fit: cover;
  }
</style>

@endsection
