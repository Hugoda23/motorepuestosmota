<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function edit()
    {
        $hero = HeroSection::first();
        return view('admin.hero.edit', compact('hero'));
    }

   public function update(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'button_text' => 'nullable|string|max:100',
        'button_link' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048',
    ]);

    $hero = HeroSection::first() ?? new HeroSection();

    // Imagen
    if ($request->hasFile('image')) {
        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
        }
        $data['image'] = $request->file('image')->store('hero', 'public');
    }

    // Guardar (create o update sobre la misma instancia)
    $hero->fill($data);
    $hero->save();

    return back()->with('success', 'Sección Hero actualizada correctamente.');
}

}
