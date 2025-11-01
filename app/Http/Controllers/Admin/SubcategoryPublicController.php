<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubcategoryPublic;
use App\Models\CategoryPublic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubcategoryPublicController extends Controller
{
    /**
     * Mostrar listado de subcategorías con su categoría asociada
     */
    public function index()
    {
        // Cargar subcategorías con su categoría relacionada
        $subcategories = SubcategoryPublic::with('category')->latest()->paginate(10);
        $categories = CategoryPublic::all(); // Para el modal de creación

        return view('admin.subcategoriespublic.index', compact('subcategories', 'categories'));
    }

    /**
     * Guardar nueva subcategoría desde el modal
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'categorypublic_id' => 'required|exists:categoriespublic,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generar slug automáticamente
        $data['slug'] = Str::slug($data['name'], '-');

        // Guardar imagen si se sube
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('subcategoriespublic', 'public');
        }

        SubcategoryPublic::create($data);

        return redirect()->route('admin.subcategoriespublic.index')
            ->with('success', 'Subcategoría creada correctamente.');
    }

    /**
     * Eliminar una subcategoría
     */
    public function destroy(SubcategoryPublic $subcategorypublic)
    {
        if ($subcategorypublic->image) {
            Storage::disk('public')->delete($subcategorypublic->image);
        }

        $subcategorypublic->delete();

        return back()->with('success', 'Subcategoría eliminada correctamente.');
    }
}
