<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers
     */
    public function index()
    {
        try {
            // Get current page for pagination
            $currentPage = request()->get('page', 1);
            $perPage = 10;

            // Call the stored procedure
            $suppliers = DB::select('CALL GetActiveSuppliers()');
            
            // Convert to collection for pagination
            $collection = collect($suppliers);
            
            // Get the total count
            $total = $collection->count();
            
            // Slice the collection for the current page
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            
            // Create a paginator instance
            $paginatedSuppliers = new LengthAwarePaginator(
                $currentPageItems,
                $total,
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            
            return view('suppliers.index', [
                'suppliers' => $paginatedSuppliers,
                'error' => null
            ]);
        } catch (Exception $e) {
            // Log the error
            Log::error('Error loading suppliers: ' . $e->getMessage());
            
            // Return view with error message
            return view('suppliers.index', [
                'suppliers' => null,
                'error' => 'Er is een fout opgetreden bij het laden van het leveranciersoverzicht. Probeer het later opnieuw.'
            ]);
        }
    }

    /**
     * Show the form for creating a new supplier
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created supplier in the database
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'contact_name' => 'required|string|max:255',
                'contact_email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'next_delivery' => 'nullable|date',
                'comment' => 'nullable|string|max:1000',
            ]);

            // Add active status
            $validated['isactive'] = true;

            // Create the supplier
            Supplier::create($validated);

            // Redirect with success message
            return redirect()->route('suppliers.index')
                ->with('success', 'Leverancier succesvol toegevoegd.');
                
        } catch (Exception $e) {
            // Log the error
            Log::error('Error creating supplier: ' . $e->getMessage());
            
            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het toevoegen van de leverancier.');
        }
    }
}
