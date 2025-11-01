<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPublic extends Model
{
    use HasFactory;

    protected $table = 'categoriespublic';


    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    // Relación opcional con subcategorías
    public function subcategories()
    {
        return $this->hasMany(SubcategoryPublic::class, 'categorypublic_id');
    }
}
