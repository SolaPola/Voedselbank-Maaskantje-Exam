<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Call stored procedure to get client overview
            $allClients = collect(DB::select('CALL GetClientOverview()'));

            // Get current page from request, default to 1
            $currentPage = $request->get('page', 1);
            $perPage = 25;

            // Slice the collection to get items for current page
            $currentPageItems = $allClients->slice(($currentPage - 1) * $perPage, $perPage)->values();

            // Create paginator
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

            return view('client.index', compact('clients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van de cliënten: ' . $e->getMessage());
        }
    }
}
