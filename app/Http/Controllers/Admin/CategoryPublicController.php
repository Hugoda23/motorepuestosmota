<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryPublic;
use Illuminate\Support\Facades\Storage;
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

        // 🔹 Generar el slug automáticamente desde el nombre
        $data['slug'] = Str::slug($data['name'], '-');

        // 🔹 Guardar imagen si se envía
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        CategoryPublic::create($data);

        return redirect()->route('admin.categoriespublic.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function destroy(CategoryPublic $categoriespublic)
    {
        if ($categoriespublic->image) {
            Storage::disk('public')->delete($categoriespublic->image);
        }

        $categoriespublic->delete();

        return back()->with('success', 'Categoría eliminada correctamente.');
    }
    public function show($id)
{
    $category = CategoryPublic::findOrFail($id);
    return view('admin.categoriespublic.show', compact('category'));
}

}
