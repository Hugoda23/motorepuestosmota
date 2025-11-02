<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPublic;
use App\Models\SubcategoryPublic;
use App\Models\ProductPublic;
use App\Models\HeroSection;
use App\Models\FeaturedProduct;
use App\Models\Promotion;

class PublicController extends Controller
{
    /**
     * Página principal pública
     */
    public function index()
    {
        // Hero principal (imagen, texto, botón)
        $hero = HeroSection::first();

        // Categorías con subcategorías ordenadas
        $categories = CategoryPublic::with(['subcategories' => function ($query) {
                $query->orderBy('name', 'asc');
            }])
            ->orderBy('name', 'asc')
            ->get();

        // Productos destacados publicados
        $featured = FeaturedProduct::where('is_published', true)
            ->latest()
            ->take(8)
            ->get();

        // Retornar la vista principal
        return view('public.home', compact('hero', 'categories', 'featured'));
    }

    /**
     * Mostrar productos por subcategoría
     */
    public function showSubcategory($categorySlug, $subcategorySlug)
    {
        // Buscar categoría principal
        $category = CategoryPublic::where('slug', $categorySlug)->firstOrFail();

        // Buscar subcategoría dentro de esa categoría
        $subcategory = SubcategoryPublic::where('slug', $subcategorySlug)
            ->where('categorypublic_id', $category->id)
            ->firstOrFail();

        // Productos publicados dentro de esa subcategoría
        $products = ProductPublic::where('subcategorypublic_id', $subcategory->id)
            ->where('is_published', true)
            ->latest()
            ->get();

        return view('public.subcategory-products', compact('category', 'subcategory', 'products'));
    }

    /**
     * Mostrar detalle individual de producto
     */
    public function showProduct($slug)
    {
        // Buscar producto publicado
        $product = ProductPublic::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Buscar productos relacionados (misma subcategoría)
        $related = ProductPublic::where('subcategorypublic_id', $product->subcategorypublic_id)
            ->where('id', '!=', $product->id)
            ->where('is_published', true)
            ->take(4)
            ->get();

        return view('public.product-detail', compact('product', 'related'));
    }

    /**
     * Vista pública de todos los productos agrupados por categoría
     */
    public function publicView()
    {
        $categories = CategoryPublic::with([
            'subcategories.products' => function ($query) {
                $query->where('is_published', true);
            }
        ])->get();

        return view('public.productspublic.index', compact('categories'));
    }

    /**
     * Versión alternativa del home (por si quieres probar otra vista)
     */
    public function home2()
    {
        $hero = HeroSection::first();

        $categories = CategoryPublic::with('subcategories')->get();

        $featured = FeaturedProduct::where('is_published', true)
            ->latest()
            ->take(8)
            ->get();

        return view('public.home2', compact('hero', 'categories', 'featured'));
    }

     public function promociones()
    {
        $today = now()->toDateString();

        $promotions = Promotion::where('is_published', true)
            ->where(function ($q) use ($today) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
            })
            ->latest()
            ->get();

        return view('public.promociones', compact('promotions'));
    }
}
