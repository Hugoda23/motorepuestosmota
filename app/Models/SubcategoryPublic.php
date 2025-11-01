<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryPublic extends Model
{
    use HasFactory;

    protected $table = 'subcategoriespublic';

    protected $fillable = [
        'categorypublic_id',
        'name',
        'slug',
        'description',
        'image',
        'is_published',
    ];

    // 🔹 Relación con CategoryPublic
    public function category()
    {
        return $this->belongsTo(CategoryPublic::class, 'categorypublic_id');
    }

    // 🔹 Relación con los productos
    public function products()
    {
        return $this->hasMany(ProductPublic::class, 'subcategorypublic_id');
    }
}
