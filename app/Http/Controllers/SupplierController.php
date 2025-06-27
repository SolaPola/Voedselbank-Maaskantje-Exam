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
            // Check if a supplier with the same name AND email already exists
            $existingSupplier = Supplier::where('isactive', true)
                ->where('name', $request->name)
                ->where('contact_email', $request->contact_email)
                ->first();
                
            if ($existingSupplier) {
                return redirect()->back()
                    ->withInput()
                    ->with('duplicate_error', true);
            }
            
            // Enhanced validation with better rules and custom messages
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:suppliers,name,NULL,id,isactive,1',
                'address' => 'required|string|max:255',
                'contact_name' => 'required|string|max:100',
                'contact_email' => 'required|email:rfc,dns|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)\.]+$/',
                'next_delivery' => 'nullable|date|after_or_equal:today',
                'comment' => 'nullable|string|max:1000',
            ], [
                'name.required' => 'De naam van de leverancier is verplicht.',
                'name.unique' => 'Er bestaat al een actieve leverancier met deze naam.',
                'address.required' => 'Het adres van de leverancier is verplicht.',
                'contact_name.required' => 'De naam van de contactpersoon is verplicht.',
                'contact_email.required' => 'Het e-mailadres is verplicht.',
                'contact_email.email' => 'Vul een geldig e-mailadres in.',
                'phone.required' => 'Het telefoonnummer is verplicht.',
                'phone.regex' => 'Vul een geldig telefoonnummer in (alleen cijfers, spaties en de tekens + - ( ) . zijn toegestaan).',
                'next_delivery.after_or_equal' => 'De leveringsdatum moet vandaag of in de toekomst zijn.',
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
        // Load the supplier's deliveries relationship
        $supplier->load(['deliveries' => function($query) {
            $query->orderBy('delivery_date', 'desc');
        }, 'deliveries.product']);
        
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
            // Check if email is already in use by another active supplier
            $duplicateEmail = Supplier::where('isactive', true)
                ->where('id', '!=', $supplier->id) // Exclude current supplier
                ->where('contact_email', $request->contact_email)
                ->first();
                
            if ($duplicateEmail) {
                return redirect()->back()
                    ->withInput()
                    ->with('email_error', 'Dit e-mailadres is al in gebruik bij een andere leverancier.');
            }
            
            // Check if another supplier with the same name AND email already exists
            $existingSupplier = Supplier::where('isactive', true)
                ->where('id', '!=', $supplier->id) // Exclude current supplier
                ->where('name', $request->name)
                ->where('contact_email', $request->contact_email)
                ->first();
                
            if ($existingSupplier) {
                return redirect()->back()
                    ->withInput()
                    ->with('duplicate_error', true);
            }
            
            // Validate the request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'contact_name' => 'required|string|max:100',
                'contact_email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)\.]+$/',
                'next_delivery' => 'nullable|date|after_or_equal:today',
                'comment' => 'nullable|string|max:1000',
            ], [
                'name.required' => 'De naam van de leverancier is verplicht.',
                'address.required' => 'Het adres van de leverancier is verplicht.',
                'contact_name.required' => 'De naam van de contactpersoon is verplicht.',
                'contact_email.required' => 'Het e-mailadres is verplicht.',
                'contact_email.email' => 'Vul een geldig e-mailadres in.',
                'phone.required' => 'Het telefoonnummer is verplicht.',
                'phone.regex' => 'Vul een geldig telefoonnummer in (alleen cijfers, spaties en de tekens + - ( ) . zijn toegestaan).',
                'next_delivery.after_or_equal' => 'De leveringsdatum moet vandaag of in de toekomst zijn.',
            ]);
            
            // Check database connection before attempting update
            if (!DB::connection()->getDatabaseName()) {
                throw new \Exception('Database connection failed');
            }
            
            // Perform the update
            $supplier->update($validated);
            
            return redirect()->route('suppliers.edit', $supplier)
                ->with('success', 'Leverancier succesvol bijgewerkt.');
                
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions specifically
            Log::error('Database error updating supplier: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van de wijzigingen. Probeer het later opnieuw.');
                
        } catch (\PDOException $e) {
            // Handle PDO exceptions (database connection issues)
            Log::error('PDO error updating supplier: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van de wijzigingen. Probeer het later opnieuw.');
                
        } catch (Exception $e) {
            // Handle all other exceptions
            Log::error('Error updating supplier: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van de wijzigingen. Probeer het later opnieuw.');
        }
    }
    
    /**
     * Remove the specified supplier from storage (soft delete)
     */
    public function destroy(Supplier $supplier)
    {
        try {
            // Store the supplier name for the success message
            $supplierName = $supplier->name;
            
            // Perform soft delete by setting isactive to false
            $supplier->update(['isactive' => false]);
            
            // Redirect to the suppliers index with a success message
            return redirect()->route('suppliers.index')
                ->with('success', "Leverancier '{$supplierName}' succesvol verwijderd.");
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions specifically
            Log::error('Database error removing supplier: ' . $e->getMessage());
            
            return back()->with('error', 'Er is een fout opgetreden bij het verwijderen van de leverancier.');
        } catch (Exception $e) {
            // Log the error
            Log::error('Error removing supplier: ' . $e->getMessage());
            
            // Redirect back with error message
            return back()->with('error', 'Er is een fout opgetreden bij het verwijderen van de leverancier.');
        }
    }
}
