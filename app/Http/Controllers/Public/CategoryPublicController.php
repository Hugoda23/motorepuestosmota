<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CategoryPublic;
use App\Models\SubcategoryPublic;
use Illuminate\Http\Request;

class CategoryPublicController extends Controller
{
    public function show($categorySlug, $subcategorySlug)
    {
        // Buscar categoría
        $category = CategoryPublic::where('slug', $categorySlug)->firstOrFail();

        // Buscar subcategoría dentro de esa categoría
        $subcategory = SubcategoryPublic::where('categorypublic_id', $category->id)
            ->where('slug', $subcategorySlug)
            ->firstOrFail();

        // Obtener productos publicados
        $products = $subcategory->products()
            ->where('is_published', true)
            ->latest()
            ->get();

        return view('public.category-show', compact('category', 'subcategory', 'products'));
    }
}
