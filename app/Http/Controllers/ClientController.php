<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            $allClients = collect(DB::select('CALL GetClientOverview()'));

            // Filter by preference if provided
            $preferenceFilter = $request->get('preference');
            if ($preferenceFilter && $preferenceFilter !== 'all') {
                if ($preferenceFilter === 'none') {
                    $allClients = $allClients->whereNull('wensen');
                } else {
                    $allClients = $allClients->where('wensen', $preferenceFilter);
                }
            }

            $currentPage = $request->get('page', 1);
            $perPage = 25;

            $currentPageItems = $allClients->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $clients = new LengthAwarePaginator(
                $currentPageItems,
                $allClients->count(),
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'pageName' => 'page',
                ]
            );

            // Preserve filter parameters in pagination
            $clients->appends($request->except('page'));

            // Get unique preferences for filter dropdown
            $allPreferences = collect(DB::select('CALL GetClientOverview()'))
                ->pluck('wensen')
                ->filter()
                ->unique()
                ->sort()
                ->values();

            return view('client.index', compact('clients', 'allPreferences', 'preferenceFilter'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van de cliënten: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:500',
                'postal_code' => 'required|string|max:10',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:clients,email',
                'preference' => 'nullable|string|max:100',
                'adults' => 'required|integer|min:0|max:20',
                'children' => 'required|integer|min:0|max:20',
                'babies' => 'required|integer|min:0|max:10',
                'comment' => 'nullable|string|max:1000',
            ]);

            // Convert phone to integer, removing any non-numeric characters
            $validatedData['phone'] = (int) preg_replace('/\D/', '', $validatedData['phone']);

            Client::create($validatedData);

            return redirect()->route('clients.index')->with('success', 'Cliënt succesvol toegevoegd!');
        } catch (\Exception $e) {   
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het toevoegen van de cliënt: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $client = Client::findOrFail($id);
            return view('client.show', compact('client'));
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Cliënt niet gevonden.');
        }
    }

    public function edit($id)
    {
        try {
            $client = Client::findOrFail($id);
            return view('client.edit', compact('client'));
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Cliënt niet gevonden.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:500',
                'postal_code' => 'required|string|max:10',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:clients,email,' . $client->id,
                'preference' => 'nullable|string|max:100',
                'adults' => 'required|integer|min:0|max:20',
                'children' => 'required|integer|min:0|max:20',
                'babies' => 'required|integer|min:0|max:10',
                'comment' => 'nullable|string|max:1000',
            ]);

            // Convert phone to integer, removing any non-numeric characters
            $validatedData['phone'] = (int) preg_replace('/\D/', '', $validatedData['phone']);

            $client->update($validatedData);

            return redirect()->route('clients.index')->with('success', 'Cliënt succesvol bijgewerkt!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het bijwerken van de cliënt: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();

            return redirect()->route('clients.index')->with('success', 'Cliënt succesvol verwijderd!');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Er is een fout opgetreden bij het verwijderen van de cliënt: ' . $e->getMessage());
        }
    }
}
