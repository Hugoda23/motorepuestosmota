<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FeaturedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'old_price',
        'image',
        'is_published',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generar slug automáticamente
        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }
}
