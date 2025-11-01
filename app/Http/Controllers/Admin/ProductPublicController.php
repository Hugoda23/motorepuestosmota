<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPublic;
use App\Models\SubcategoryPublic;
use Illuminate\Support\Facades\Storage;
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

        //  Generar slug automáticamente
        $data['slug'] = Str::slug($data['name'], '-');

        // Guardar imagen si se sube
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('productspublic', 'public');
        }

        ProductPublic::create($data);

        return redirect()
            ->route('admin.productspublic.index')
            ->with('success', 'Producto creado correctamente.');
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
        if ($productpublic->image) {
            Storage::disk('public')->delete($productpublic->image);
        }

        $productpublic->delete();

        return back()->with('success', 'Producto eliminado correctamente.');
    }
}
