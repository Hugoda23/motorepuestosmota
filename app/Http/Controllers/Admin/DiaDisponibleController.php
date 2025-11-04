<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\DiaDisponible;
use App\Models\Cita;
class DiaDisponibleController extends Controller
{
    public function index()
    {
        $diasDisponibles = DiaDisponible::orderBy('fecha', 'asc')->get();
        return view('admin.calendar.dias', compact('diasDisponibles'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date|unique:dias_disponibles,fecha',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'limite_citas' => 'required|integer|min:0',
        ]);

        DiaDisponible::create([
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'limite_citas' => $request->limite_citas,
        ]);

        return redirect()->back()->with('success', 'Disponibilidad registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date|unique:dias_disponibles,fecha,' . $id,
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'limite_citas' => 'required|integer|min:1',
        ]);

        $dia = DiaDisponible::findOrFail($id);
        $dia->update([
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'limite_citas' => $request->limite_citas,
        ]);

        return redirect()->back()->with('success', 'Día actualizado correctamente.');
    }

    public function destroy($id)
    {
        $dia = DiaDisponible::findOrFail($id);
        $dia->delete();

        return redirect()->back()->with('success', 'Día eliminado correctamente.');
    }

    public function diasLlenos()
    {
        $dias = DiaDisponible::all();
        $diasLlenos = [];

        foreach ($dias as $dia) {
            $totalCitas = Cita::where('fecha', $dia->fecha)->count();
            if ($totalCitas >= $dia->limite_citas) {
                $diasLlenos[] = [
                    'title' => 'Cupo lleno',
                    'start' => $dia->fecha,
                    'allDay' => true,
                    'display' => 'background',
                    'backgroundColor' => '#ff4d4d'
                ];
            }
        }

        return response()->json($diasLlenos);
    }
}
