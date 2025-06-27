<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers
     */
    public function index()
    {
        $suppliers = Supplier::where('isactive', true)
            ->orderBy('name')
            ->paginate(10); // Add pagination with 10 items per page
        
        return view('suppliers.index', compact('suppliers'));
    }
}
