<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipementCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipementCategoryController extends Controller
{
    public function index()
    {
        $categories = EquipementCategory::with('creator')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:equipement_categories',
        ]);

        EquipementCategory::create([
            'name' => $request->name,
            'added_by' => Auth::guard('user')->id(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(EquipementCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, EquipementCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:equipement_categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(EquipementCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
