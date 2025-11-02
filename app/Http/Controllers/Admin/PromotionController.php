<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function store(Request $request)
    {
       $data = $request->validate([
    'title' => 'required|string|max:255',
    'subtitle' => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'price' => 'nullable|numeric',
    'old_price' => 'nullable|numeric',
    'benefits' => 'nullable|string|max:255',
    'start_date' => 'nullable|date',
    'end_date' => 'nullable|date|after_or_equal:start_date',
    'image' => 'nullable|image|max:2048',
]);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/promotions'), $filename);
            $data['image'] = 'uploads/promotions/' . $filename;
        }

        Promotion::create($data);

        return back()->with('success', '✅ Promoción creada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $data = $request->validate([
    'title' => 'required|string|max:255',
    'subtitle' => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'price' => 'nullable|numeric',
    'old_price' => 'nullable|numeric',
    'benefits' => 'nullable|string|max:255',
    'start_date' => 'nullable|date',
    'end_date' => 'nullable|date|after_or_equal:start_date',
    'image' => 'nullable|image|max:2048',
]);

        if ($request->hasFile('image')) {
            if (!empty($promotion->image) && file_exists(public_path($promotion->image))) {
                unlink(public_path($promotion->image));
            }

            $filename = time() . '_' . Str::slug(pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/promotions'), $filename);
            $data['image'] = 'uploads/promotions/' . $filename;
        }

        $promotion->update($data);

        return back()->with('success', '✅ Promoción actualizada correctamente.');
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);

        if (!empty($promotion->image) && file_exists(public_path($promotion->image))) {
            unlink(public_path($promotion->image));
        }

        $promotion->delete();

        return back()->with('success', '🗑️ Promoción eliminada correctamente.');
    }

    public function toggle(Promotion $promotion)
    {
        $promotion->is_published = !$promotion->is_published;
        $promotion->save();

        return back()->with('success', $promotion->is_published ? 'Promoción publicada.' : 'Promoción despublicada.');
    }
}
