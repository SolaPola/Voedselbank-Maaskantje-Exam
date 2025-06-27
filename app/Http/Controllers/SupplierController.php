<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers
     */
    public function index()
    {
        try {
            $suppliers = Supplier::where('isactive', true)
                ->orderBy('name')
                ->paginate(10);
            
            return view('suppliers.index', [
                'suppliers' => $suppliers,
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
