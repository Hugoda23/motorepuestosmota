<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedProduct;
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
     * Guardar nuevo producto destacado
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

        // 🔹 Generar slug automáticamente
        $data['slug'] = Str::slug($data['title'], '-');

        // 🔹 Guardar imagen en /public/uploads/featured/
        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(
                pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $request->file('image')->getClientOriginalExtension();

            // Crear directorio si no existe (necesario en Hostinger)
            if (!file_exists(public_path('uploads/featured'))) {
                mkdir(public_path('uploads/featured'), 0755, true);
            }

            // Mover archivo
            $request->file('image')->move(public_path('uploads/featured'), $filename);
            $data['image'] = 'uploads/featured/' . $filename; // ruta accesible por asset()
        }

        FeaturedProduct::create($data);

        return redirect()
            ->route('admin.featured.index')
            ->with('success', '✅ Producto destacado agregado correctamente.');
    }

    /**
     * Publicar o despublicar un producto destacado
     */
    public function togglePublish(FeaturedProduct $featured)
    {
        $featured->is_published = !$featured->is_published;
        $featured->save();

        return back()->with('success', $featured->is_published
            ? 'Producto destacado publicado correctamente.'
            : 'Producto destacado despublicado.');
    }

    /**
     * Eliminar producto destacado
     */
    public function destroy(Request $request, $id)
    {
        $featured = FeaturedProduct::findOrFail($id);

        if (!empty($featured->image) && file_exists(public_path($featured->image))) {
            unlink(public_path($featured->image));
        }

        $featured->delete();

        return redirect()
            ->route('admin.featured.index')
            ->with('success', '🗑️ Producto destacado eliminado correctamente.');
    }
}
