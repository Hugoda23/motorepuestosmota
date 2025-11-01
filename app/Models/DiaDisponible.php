<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiaDisponible extends Model
{
    use HasFactory;

    protected $table = 'dias_disponibles'; 

    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin',
        'limite_citas',
    ];

    public function getFechaFormateadaAttribute()
    {
        return Carbon::parse($this->fecha)->format('d/m/Y');
    }

    public function getHoraInicioFormateadaAttribute()
    {
        return Carbon::parse($this->hora_inicio)->format('H:i');
    }

    public function getHoraFinFormateadaAttribute()
    {
        return Carbon::parse($this->hora_fin)->format('H:i');
    }
}
