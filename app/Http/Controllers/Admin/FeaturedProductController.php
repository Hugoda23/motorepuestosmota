<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FeaturedProductController extends Controller
{
    /**
     * Mostrar listado de productos destacados
     */
    public function index()
    {
        $featured = FeaturedProduct::orderByDesc('is_published')
            ->latest()
            ->paginate(10);

        return view('admin.featured.index', compact('featured'));
    }

    /**
     * Guardar nuevo producto destacado (desde modal)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generar slug automáticamente
        $data['slug'] = Str::slug($data['title'], '-');

        // Guardar imagen
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('featured', 'public');
        }

        // Guardar producto destacado
        FeaturedProduct::create($data);

        return redirect()->route('admin.featured.index')
            ->with('success', 'Producto destacado agregado correctamente.');
    }

    /**
     * Publicar o despublicar un producto destacado
     */
    public function toggle(FeaturedProduct $featured)
    {
        $featured->is_published = !$featured->is_published;
        $featured->save();

        return back()->with('success', $featured->is_published
            ? 'Producto publicado correctamente.'
            : 'Producto despublicado.');
    }

    /**
     * Eliminar producto destacado
     */
    public function destroy(FeaturedProduct $featured)
    {
        if ($featured->image) {
            Storage::disk('public')->delete($featured->image);
        }

        $featured->delete();

        return back()->with('success', 'Producto destacado eliminado correctamente.');
    }
}
