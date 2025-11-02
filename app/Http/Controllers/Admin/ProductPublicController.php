<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPublic;
use App\Models\SubcategoryPublic;
use Illuminate\Support\Str;

class ProductPublicController extends Controller
{
    public function index()
    {
        $products = ProductPublic::with('subcategorypublic')->latest()->paginate(10);
        $subcategories = SubcategoryPublic::all();
        return view('admin.productspublic.index', compact('products', 'subcategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subcategorypublic_id' => 'required|exists:subcategoriespublic,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // 🔹 Generar slug automáticamente
        $data['slug'] = Str::slug($data['name'], '-');

        // 🔹 Guardar imagen en /public/uploads/productspublic/
        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(
                pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $request->file('image')->getClientOriginalExtension();

            // Crear directorio si no existe (importante en Hostinger)
            if (!file_exists(public_path('uploads/productspublic'))) {
                mkdir(public_path('uploads/productspublic'), 0755, true);
            }

            // Mover archivo
            $request->file('image')->move(public_path('uploads/productspublic'), $filename);
            $data['image'] = 'uploads/productspublic/' . $filename; // ruta accesible por asset()
        }

        ProductPublic::create($data);

        return redirect()
            ->route('admin.productspublic.index')
            ->with('success', '✅ Producto creado correctamente.');
    }

    public function togglePublish(ProductPublic $productpublic)
    {
        $productpublic->is_published = !$productpublic->is_published;
        $productpublic->save();

        return back()->with('success', $productpublic->is_published
            ? 'Producto publicado correctamente.'
            : 'Producto despublicado.');
    }

    public function destroy(ProductPublic $productpublic)
    {
        // 🔹 Eliminar imagen si existe
        if (!empty($productpublic->image) && file_exists(public_path($productpublic->image))) {
            unlink(public_path($productpublic->image));
        }

        $productpublic->delete();

        return back()->with('success', '🗑️ Producto eliminado correctamente.');
    }
}
