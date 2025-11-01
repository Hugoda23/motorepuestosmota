@extends('layouts.public')

@section('title', 'Contáctanos')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <div class="contact-icon">
            <i class="bi bi-envelope-paper-heart"></i>
        </div>
        <h1 class="contact-title">Contáctanos</h1>
        <p class="text-muted">¿Tienes dudas o necesitas ayuda? Envíanos un mensaje y te responderemos pronto.</p>
    </div>

    <div class="contact-card mx-auto" style="max-width: 600px;">
        <form action="{{ route('public.contact.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre completo</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Tu nombre completo" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="tucorreo@ejemplo.com" required>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Asunto (opcional)</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Motivo de tu mensaje">
            </div>

            <div class="mb-4">
                <label for="message" class="form-label">Mensaje</label>
                <textarea name="message" id="message" rows="4" class="form-control" placeholder="Escribe tu mensaje..." required></textarea>
            </div>

            <button type="submit" class="btn btn-contact w-100">
                <i class="bi bi-send-fill me-1"></i> Enviar mensaje
            </button>
        </form>
    </div>
</div>
@endsection