<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    /**
     * 🔹 Muestra la vista del calendario de recordatorios
     */
    public function index()
    {
        return view('admin.reminders.index');
    }

    /**
     * 🔹 Devuelve todos los recordatorios del usuario autenticado
     */
  public function fetch()
{
    $reminders = Reminder::where('user_id', Auth::id())
        ->get(['id', 'title', 'remind_at as start', 'description', 'notified']);

    $now = now();

    // Agregar color dinámico según estado
    $reminders = $reminders->map(function ($r) use ($now) {
        $remindTime = \Carbon\Carbon::parse($r->start);

        if ($r->notified) {
            $r->color = '#22c55e'; // 🟢 Reactivado (notificado pero reactivado)
        } elseif ($remindTime->isToday()) {
            $r->color = '#facc15'; // 🟡 Hoy
        } elseif ($remindTime->isPast()) {
            $r->color = '#ef4444'; // 🔴 Pasado
        } else {
            $r->color = '#3b82f6'; // 🔵 Futuro (pendiente)
        }

        return $r;
    });

    return response()->json($reminders);
}


    /**
     * 🔹 Crea un nuevo recordatorio
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at' => 'required|date',
        ]);

        $data['user_id'] = Auth::id();
        $data['notified'] = false;

        Reminder::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio creado correctamente.',
        ]);
    }

    /**
     * 🔹 Actualiza un recordatorio existente
     */
    public function update(Request $request, Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at' => 'required|date',
        ]);

        $reminder->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio actualizado correctamente.',
        ]);
    }

    /**
     * 🔹 Elimina un recordatorio
     */
    public function destroy(Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $reminder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio eliminado correctamente.',
        ]);
    }

    /**
     * 🔹 Marca un recordatorio como notificado (cuando se muestra la notificación)
     */
    public function markNotified(Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) {
            abort(403);
        }

        $reminder->update(['notified' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * 🔹 Reactiva un recordatorio (para volver a notificarlo)
     */
    public function reactivar(Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) {
            abort(403);
        }

        $reminder->update(['notified' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio reactivado correctamente.',
        ]);
    }
}
