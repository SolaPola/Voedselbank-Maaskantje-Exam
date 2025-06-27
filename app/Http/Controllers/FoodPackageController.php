<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use Illuminate\Http\Request;

class FoodPackageController extends Controller
{
    public function index()
    {
        $foodpackages = FoodPackage::all();
        return view('foodpackages.index', compact('foodpackages'));
    }

    public function create()
    {
        return view('foodpackages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Voeg hier andere velden toe indien nodig
        ]);

        FoodPackage::create($validated);

        return redirect()->route('foodpackages.index')->with('success', 'Voedselpakket aangemaakt!');
    }

    public function show(FoodPackage $foodpackage)
    {
        return view('foodpackages.show', compact('foodpackage'));
    }

    public function edit(FoodPackage $foodpackage)
    {
        return view('foodpackages.edit', compact('foodpackage'));
    }

    public function update(Request $request, FoodPackage $foodpackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Voeg hier andere velden toe indien nodig
        ]);

        $foodpackage->update($validated);

        return redirect()->route('foodpackages.index')->with('success', 'Voedselpakket bijgewerkt!');
    }

    public function destroy(FoodPackage $foodpackage)
    {
        $foodpackage->delete();

        return redirect()->route('foodpackages.index')->with('success', 'Voedselpakket verwijderd!');
    }
}