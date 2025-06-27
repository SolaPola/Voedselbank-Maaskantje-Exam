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
            //this calls the stored procedure
            $allClients = collect(DB::select('CALL GetClientOverview()'));


            $currentPage = $request->get('page', 1);
            $perPage = 25;

            $currentPageItems = $allClients->slice(($currentPage - 1) * $perPage, $perPage)->values();

            //this is the pagination
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

            //unhappy scenario
            return view('client.index', compact('clients'));
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

            Client::create($validatedData);

            return redirect()->route('clients.index')->with('success', 'Cliënt succesvol toegevoegd!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Er is een fout opgetreden bij het toevoegen van de cliënt: ' . $e->getMessage());
        }
    }
}
