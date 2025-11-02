<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryPublic;
use Illuminate\Support\Str;

class CategoryPublicController extends Controller
{
    public function index()
    {
        $categories = CategoryPublic::latest()->paginate(10);
        return view('admin.categoriespublic.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // 🔹 Generar el slug automáticamente
        $data['slug'] = Str::slug($data['name'], '-');

        // 🔹 Guardar imagen en /public/uploads/categories/
        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'uploads/categories/' . $filename; // ruta accesible desde asset()
        }

        CategoryPublic::create($data);

        return redirect()->route('admin.categoriespublic.index')
            ->with('success', 'Categoría creada correctamente.');
    }

  public function destroy(Request $request, $id)
{
    $category = CategoryPublic::findOrFail($id);

    if (!empty($category->image) && file_exists(public_path($category->image))) {
        unlink(public_path($category->image));
    }

    $category->delete();

    return redirect()
        ->route('admin.categoriespublic.index')
        ->with('success', '🗑️ Categoría eliminada correctamente.');
}



    public function show($id)
    {
        $category = CategoryPublic::findOrFail($id);
        return view('admin.categoriespublic.show', compact('category'));
    }
}
