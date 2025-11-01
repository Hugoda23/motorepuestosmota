<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPublic extends Model
{
    use HasFactory;
protected $table = 'productspublic';
    protected $fillable = [
        'subcategorypublic_id',
        'name',
        'slug',
        'description',
        'features',
        'image',
        'is_published',
    ];

    public function subcategorypublic()
    {
        return $this->belongsTo(SubcategoryPublic::class, 'subcategorypublic_id');
    }
}
