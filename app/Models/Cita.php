<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'nombre',
        'telefono',
        'observacion',
        'fecha',
        'hora',
        'asistio',
        'created_by',
        'updated_by',
    ];

    /**
     * Relación con el usuario que creó la cita.
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con el usuario que actualizó la cita.
     */
    public function actualizador()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relación con el día disponible correspondiente.
     */
    public function diaDisponible()
    {
        return $this->belongsTo(DiaDisponible::class, 'fecha', 'fecha');
    }

    /**
     * Accesor para mostrar la fecha formateada como dd/mm/yyyy
     */
    public function getFechaFormateadaAttribute()
    {
        return Carbon::parse($this->fecha)->format('d/m/Y');
    }

    /**
     * Accesor para mostrar la hora formateada como HH:mm
     */
    public function getHoraFormateadaAttribute()
    {
        return $this->hora ? Carbon::parse($this->hora)->format('H:i') : null;
    }
}
