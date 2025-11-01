<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\DiaDisponible;
use Carbon\Carbon;

class CitaController extends Controller
{
    public function index()
    {
        return view('calendario.calendar');
    }

    // ============================================================
    // 📅 OBTENER CITAS PARA EL CALENDARIO
    // ============================================================
    public function getCitas()
    {
        $citas = Cita::all();

        $eventos = $citas->map(function ($cita) {
            $horaFormateada = $cita->hora_formateada;
            $fechaFormateada = $cita->fecha_formateada;

            return [
                'id' => $cita->id,
                'title' => ($horaFormateada ? $horaFormateada . ' - ' : '') . $cita->nombre,
                'start' => $cita->fecha,
                'extendedProps' => [
                    'nombre' => $cita->nombre,
                    'telefono' => $cita->telefono,
                    'observacion' => $cita->observacion,
                    'hora' => $horaFormateada,
                    'fecha_formateada' => $fechaFormateada,
                ]
            ];
        });

        return response()->json($eventos);
    }

    // ============================================================
    // 📝 REGISTRAR NUEVA CITA
    // ============================================================
  public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string',
        'telefono' => 'required|string',
        'observacion' => 'nullable|string',
        'fecha' => 'required|date',
        'hora' => 'nullable|date_format:H:i',
    ]);
        $fecha = $request->fecha;
        $hora = $request->hora;

        $dia = DiaDisponible::where('fecha', $fecha)->first();

        if ($dia) {
            $citasAgendadas = Cita::where('fecha', $fecha)->count();
            if ($citasAgendadas >= $dia->limite_citas) {
                return response()->json([
                    'error' => 'Ya no hay disponibilidad para esta fecha. Intenta con otro día.'
                ], 422);
            }

            if ($hora) {
                $horaCita = Carbon::createFromFormat('H:i', $hora);
                $inicio = Carbon::createFromFormat('H:i:s', $dia->hora_inicio);
                $fin = Carbon::createFromFormat('H:i:s', $dia->hora_fin);

                if ($horaCita->lt($inicio) || $horaCita->gt($fin)) {
                    return response()->json([
                        'error' => 'La hora seleccionada está fuera del horario permitido (' .
                            $inicio->format('H:i') . ' - ' . $fin->format('H:i') . ').'
                    ], 422);
                }
            }
        }

        $cita = Cita::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'observacion' => $request->observacion,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'created_by' => auth()->id(),
        ]);

        // ============================================================
        // 💬 ENVÍO DE WHATSAPP (DESACTIVADO TEMPORALMENTE)
        // ============================================================
        /*
        // Limpia el número de teléfono y agrega el prefijo de país (+502)
        $numero = preg_replace('/\D/', '', $cita->telefono);
        $numeroWhatsApp = "+502{$numero}";

        // Mensaje personalizado que se enviará al cliente
        $mensaje = "Hola {$cita->nombre}, tu cita ha sido registrada exitosamente para el día {$cita->fecha_formateada}" .
                   ($cita->hora ? " a las {$cita->hora_formateada}" : "") . ".
Te esperamos en nuestra ubicación: xxxxxxxxxxxxxxxxxxxxxxxxxx. 
Si tienes alguna duda o deseas reprogramar, puedes escribirnos por este mismo medio. ¡Gracias por tu confianza!";

        try {
            // Servicio Twilio encargado de enviar el mensaje
            $twilio->enviarWhatsApp($numeroWhatsApp, $mensaje);
        } catch (\Exception $e) {
            \Log::error("Error al enviar WhatsApp: " . $e->getMessage());
        }
        */

        return response()->json(['success' => true]);
    }

    // ============================================================
    // ✏️ ACTUALIZAR CITA EXISTENTE
    // ============================================================
    public function actualizar(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:citas,id',
                'nombre' => 'required|string',
                'telefono' => 'required|string',
                'observacion' => 'nullable|string',
                'fecha' => 'required|date',
                'hora' => 'nullable|date_format:H:i',
            ]);

            $dia = DiaDisponible::where('fecha', $request->fecha)->first();

            if ($dia && $request->hora) {
                $horaCita = Carbon::createFromFormat('H:i', $request->hora);
                $inicio = Carbon::createFromFormat('H:i:s', $dia->hora_inicio);
                $fin = Carbon::createFromFormat('H:i:s', $dia->hora_fin);

                if ($horaCita->lt($inicio) || $horaCita->gt($fin)) {
                    return response()->json([
                        'error' => 'La hora seleccionada está fuera del horario permitido (' .
                            $inicio->format('H:i') . ' - ' . $fin->format('H:i') . ').'
                    ], 422);
                }
            }

            $cita = Cita::findOrFail($request->id);
            $cita->update([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'observacion' => $request->observacion,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'updated_by' => auth()->id(),
            ]);

            return response()->json(['mensaje' => 'Cita actualizada']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'details' => $e->errors()
            ], 422);
        }
    }

    // ============================================================
    // ❌ ELIMINAR CITA
    // ============================================================
    public function eliminar($id)
    {
        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['mensaje' => 'Cita no encontrada'], 404);
        }

        $cita->delete();

        return response()->json(['mensaje' => 'Cita eliminada correctamente']);
    }
}
