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
        $subcategories = SubcategoryPublic::with('category')->latest()->paginate(10);
        $categories = CategoryPublic::all(); // Para el formulario o modal de creación

        return view('admin.subcategoriespublic.index', compact('subcategories', 'categories'));
    }

    /**
     * Guardar nueva subcategoría desde el formulario o modal
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

        // 🔹 Guardar imagen en /public/uploads/subcategoriespublic/
        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(
                pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $request->file('image')->getClientOriginalExtension();

            // Crear carpeta si no existe (importante en Hostinger)
            if (!file_exists(public_path('uploads/subcategoriespublic'))) {
                mkdir(public_path('uploads/subcategoriespublic'), 0755, true);
            }

            // Mover archivo al directorio público
            $request->file('image')->move(public_path('uploads/subcategoriespublic'), $filename);
            $data['image'] = 'uploads/subcategoriespublic/' . $filename; // ruta accesible por asset()
        }

        SubcategoryPublic::create($data);

        return redirect()
            ->route('admin.subcategoriespublic.index')
            ->with('success', '✅ Subcategoría creada correctamente.');
    }

    /**
     * Eliminar una subcategoría (igual que en productos y categorías)
     */
    public function destroy(Request $request, $id)
    {
        $subcategory = SubcategoryPublic::findOrFail($id);

        // 🔹 Eliminar imagen si existe físicamente
        if (!empty($subcategory->image) && file_exists(public_path($subcategory->image))) {
            unlink(public_path($subcategory->image));
        }

        $subcategory->delete();

        return redirect()
            ->route('admin.subcategoriespublic.index')
            ->with('success', '🗑️ Subcategoría eliminada correctamente.');
    }
}
