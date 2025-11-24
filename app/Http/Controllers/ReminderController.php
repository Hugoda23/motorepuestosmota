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
     *     (SIN colores, solo los datos necesarios para FullCalendar)
     */
    public function fetch()
    {
        $reminders = Reminder::where('user_id', Auth::id())
            ->get([
                'id',
                'title',
                'remind_at as start',
                'description',
                'notified'
            ]);

        return response()->json($reminders);
    }

    /**
     * 🔹 Crea un nuevo recordatorio
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at'   => 'required|date',
        ]);

        $data['user_id']   = Auth::id();
        $data['notified']  = false;

        Reminder::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio creado correctamente.',
        ]);
    }

    /**
     * 🔹 Actualiza un recordatorio existente
     *     (ahora también acepta "notified" para marcar como notificado o reactivado)
     */
    public function update(Request $request, Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at'   => 'required|date',
            'notified'    => 'nullable|boolean', // 👈 permite que el JS lo envíe
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
     * 🔹 Marca un recordatorio como notificado (si quisieras usarlo vía AJAX)
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
     *     => el JS llama a /reactivar cuando tocas el botón
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
