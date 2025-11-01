<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Mostrar formulario
    public function index()
    {
        return view('public.contact');
    }

    // Procesar envío
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Guardar en BD
        $contact = Contact::create($data);

        // Enviar correo al administrador
        Mail::raw("Nuevo mensaje de contacto:\n\n".
                  "Nombre: {$data['name']}\n".
                  "Correo: {$data['email']}\n".
                  "Asunto: {$data['subject']}\n\n".
                  "Mensaje:\n{$data['message']}",
            function ($message) use ($data) {
                $message->to('admin@tusitio.com', 'Administrador')
                        ->subject('Nuevo mensaje de contacto');
            });

        return back()->with('success', 'Tu mensaje ha sido enviado correctamente. ¡Gracias por contactarnos!');
    }
}
