<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Fallback naar Eloquent als de stored procedure niet bestaat
        // Controleer of de procedure bestaat
        $procedureExists = \DB::select("SELECT ROUTINE_NAME FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_TYPE='PROCEDURE' AND ROUTINE_NAME = 'insert_or_get_client'");
        if ($procedureExists) {
            $clientId = \DB::selectOne('CALL insert_or_get_client(?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['client_name'],
                '', '', '', '', 0, 0, 0
            ])->id;
        } else {
            // Gebruik Eloquent als fallback
            $client = Client::firstOrCreate(
                ['name' => $validated['client_name']],
                [
                    'name' => $validated['client_name'],
                    'address' => '',
                    'postal_code' => '',
                    'phone' => '',
                    'email' => '',
                    'adults' => 0,
                    'children' => 0,
                    'babies' => 0,
                ]
            );
            $clientId = $client->id;
        }

        // Zelfde aanpak voor insert_food_package
        $procedureExists = \DB::select("SELECT ROUTINE_NAME FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_TYPE='PROCEDURE' AND ROUTINE_NAME = 'insert_food_package'");
        if ($procedureExists) {
            \DB::statement('CALL insert_food_package(?, ?, ?, ?, ?, ?)', [
                $clientId,
                $validated['soort_voedselpakket'] ?? null,
                $validated['gezinssamenstelling'] ?? null,
                $validated['issued_at'] ?? null,
                $validated['comment'] ?? null,
                $validated['isactive']
            ]);
        } else {
            $foodpackage = new FoodPackage();
            $foodpackage->client_id = $clientId;
            $foodpackage->soort_voedselpakket = $validated['soort_voedselpakket'] ?? null;
            $foodpackage->gezinssamenstelling = $validated['gezinssamenstelling'] ?? null;
            $foodpackage->issued_at = $validated['issued_at'] ?? null;
            $foodpackage->comment = $validated['comment'] ?? null;
            $foodpackage->isactive = $validated['isactive'];
            $foodpackage->save();
        }

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
            'soort_voedselpakket' => 'nullable|string|max:255',
            'gezinssamenstelling' => 'nullable|string|max:255',
            'issued_at' => 'nullable|date',
            'comment' => 'nullable|string|max:255',
            'isactive' => 'required|boolean',
        ]);

        $procedureExists = \DB::select("SELECT ROUTINE_NAME FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_TYPE='PROCEDURE' AND ROUTINE_NAME = 'update_food_package'");
        if ($procedureExists) {
            \DB::statement('CALL update_food_package(?, ?, ?, ?, ?, ?)', [
                $foodpackage->id,
                $validated['soort_voedselpakket'] ?? null,
                $validated['gezinssamenstelling'] ?? null,
                $validated['issued_at'] ?? null,
                $validated['comment'] ?? null,
                $validated['isactive']
            ]);
        } else {
            $foodpackage->soort_voedselpakket = $validated['soort_voedselpakket'] ?? null;
            $foodpackage->gezinssamenstelling = $validated['gezinssamenstelling'] ?? null;
            $foodpackage->issued_at = $validated['issued_at'] ?? null;
            $foodpackage->comment = $validated['comment'] ?? null;
            $foodpackage->isactive = $validated['isactive'];
            $foodpackage->save();
        }

        return redirect()->route('foodpackages.index')->with('success', 'Voedselpakket bijgewerkt!');
    }

    public function destroy(FoodPackage $foodpackage)
    {
        $procedureExists = \DB::select("SELECT ROUTINE_NAME FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_TYPE='PROCEDURE' AND ROUTINE_NAME = 'delete_food_package_and_items'");
        if ($procedureExists) {
            \DB::statement('CALL delete_food_package_and_items(?)', [$foodpackage->id]);
        } else {
            // Verwijder eerst alle gekoppelde package_items
            $foodpackage->packageItems()->delete();
            $foodpackage->delete();
        }

        return redirect()->route('foodpackages.index')->with('success', 'Voedselpakket verwijderd!');
    }
}