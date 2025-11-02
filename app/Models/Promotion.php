<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'price',
        'old_price',
        'benefits',
        'image',
        'is_published',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // 🔹 Saber si la promoción está vigente automáticamente
    public function getIsActiveAttribute()
    {
        if (!$this->is_published) return false;

        $today = Carbon::today();
        if ($this->start_date && $today->lt($this->start_date)) return false;
        if ($this->end_date && $today->gt($this->end_date)) return false;

        return true;
    }
}
