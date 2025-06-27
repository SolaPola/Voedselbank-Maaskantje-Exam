<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use App\Models\Client;
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
            'client_name' => 'required|string|max:255',
            'soort_voedselpakket' => 'nullable|string|max:255',
            'gezinssamenstelling' => 'nullable|string|max:255',
            'issued_at' => 'nullable|date',
            'comment' => 'nullable|string|max:255',
            'isactive' => 'required|boolean',
        ]);

        // Zoek of maak de client op naam
        $client = Client::firstOrCreate(
            ['name' => $validated['client_name']],
            [
                'name' => $validated['client_name'],
                'address' => '', // <-- voeg lege string toe voor verplichte velden
                'postal_code' => '',
                'phone' => '',
                'email' => '',
                'adults' => 0,
                'children' => 0,
                'babies' => 0,
                // voeg andere verplichte velden toe indien nodig
            ]
        );

        $foodpackage = new FoodPackage();
        $foodpackage->client_id = $client->id;
        $foodpackage->soort_voedselpakket = $validated['soort_voedselpakket'] ?? null;
        $foodpackage->gezinssamenstelling = $validated['gezinssamenstelling'] ?? null;
        $foodpackage->issued_at = $validated['issued_at'] ?? null;
        $foodpackage->comment = $validated['comment'] ?? null;
        $foodpackage->isactive = $validated['isactive'];
        $foodpackage->save();

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
        // Pas validatie aan op basis van je velden
        $validated = $request->validate([
            'soort_voedselpakket' => 'nullable|string|max:255',
            'gezinssamenstelling' => 'nullable|string|max:255',
            'issued_at' => 'nullable|date',
            'comment' => 'nullable|string|max:255',
            'isactive' => 'required|boolean',
            // Voeg andere velden toe indien nodig
        ]);

        $foodpackage->soort_voedselpakket = $validated['soort_voedselpakket'] ?? null;
        $foodpackage->gezinssamenstelling = $validated['gezinssamenstelling'] ?? null;
        $foodpackage->issued_at = $validated['issued_at'] ?? null;
        $foodpackage->comment = $validated['comment'] ?? null;
        $foodpackage->isactive = $validated['isactive'];
        $foodpackage->save();

        return redirect()->route('foodpackages.index')->with('success', 'Voedselpakket bijgewerkt!');
    }

    public function destroy(FoodPackage $foodpackage)
    {
        $foodpackage->delete();

        return redirect()->route('foodpackages.index')->with('success', 'Voedselpakket verwijderd!');
    }
}