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
}
