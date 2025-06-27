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
    public function index(Request $request)
    {
        try {
            $deliveryFilter = $request->input('delivery_date', 'all');
            
            $query = Supplier::where('isactive', true);
            
            // Apply delivery date filter if specified
            if ($deliveryFilter !== 'all') {
                if ($deliveryFilter === 'this_week') {
                    $query->whereDate('next_delivery', '>=', now())
                          ->whereDate('next_delivery', '<=', now()->addDays(7));
                } elseif ($deliveryFilter === 'next_week') {
                    $query->whereDate('next_delivery', '>', now()->addDays(7))
                          ->whereDate('next_delivery', '<=', now()->addDays(14));
                } elseif ($deliveryFilter === 'later') {
                    $query->whereDate('next_delivery', '>', now()->addDays(14));
                } elseif ($deliveryFilter === 'none') {
                    $query->whereNull('next_delivery');
                }
            }
            
            // Get all unique delivery weeks for the filter dropdown
            $allDeliveryOptions = [
                'this_week' => 'Deze week',
                'next_week' => 'Volgende week',
                'later' => 'Later',
                'none' => 'Niet gepland'
            ];
            
            $suppliers = $query->orderBy('name')->paginate(10);
            
            return view('suppliers.index', [
                'suppliers' => $suppliers,
                'allDeliveryOptions' => $allDeliveryOptions,
                'deliveryFilter' => $deliveryFilter,
                'error' => null
            ]);
        } catch (Exception $e) {
            Log::error('Error loading suppliers: ' . $e->getMessage());
            
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
    
    /**
     * Display the specified supplier
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }
    
    /**
     * Show the form for editing the specified supplier
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }
    
    /**
     * Update the specified supplier in storage
     */
    public function update(Request $request, Supplier $supplier)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'contact_name' => 'required|string|max:255',
                'contact_email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'next_delivery' => 'nullable|date',
                'comment' => 'nullable|string',
            ]);
            
            $supplier->update($validated);
            
            return redirect()->route('suppliers.index')
                ->with('success', 'Leverancier succesvol bijgewerkt.');
        } catch (Exception $e) {
            Log::error('Error updating supplier: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van de leverancier.');
        }
    }
    
    /**
     * Remove the specified supplier from storage (soft delete)
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->update(['isactive' => false]);
            
            return redirect()->route('suppliers.index')
                ->with('success', 'Leverancier succesvol verwijderd.');
        } catch (Exception $e) {
            Log::error('Error removing supplier: ' . $e->getMessage());
            
            return back()->with('error', 'Er is een fout opgetreden bij het verwijderen van de leverancier.');
        }
    }
}
