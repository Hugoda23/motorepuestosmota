<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubcategoryPublic;
use App\Models\CategoryPublic;
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

        // 🔹 Generar slug automáticamente
        $data['slug'] = Str::slug($data['name'], '-');

        // 🔹 Guardar imagen directamente en /public/uploads/subcategoriespublic/
        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(
                pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $request->file('image')->getClientOriginalExtension();

            // Crear carpeta si no existe
            if (!file_exists(public_path('uploads/subcategoriespublic'))) {
                mkdir(public_path('uploads/subcategoriespublic'), 0755, true);
            }

            // Mover archivo
            $request->file('image')->move(public_path('uploads/subcategoriespublic'), $filename);
            $data['image'] = 'uploads/subcategoriespublic/' . $filename; // Ruta accesible por asset()
        }

        SubcategoryPublic::create($data);

        return redirect()->route('admin.subcategoriespublic.index')
            ->with('success', '✅ Subcategoría creada correctamente.');
    }

    /**
     * Eliminar una subcategoría
     */
    public function destroy(SubcategoryPublic $subcategorypublic)
    {
        // 🔹 Eliminar imagen si existe físicamente
        if (!empty($subcategorypublic->image) && file_exists(public_path($subcategorypublic->image))) {
            unlink(public_path($subcategorypublic->image));
        }

        $subcategorypublic->delete();

        return back()->with('success', '🗑️ Subcategoría eliminada correctamente.');
    }
}
