<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Category;
use App\Models\Product;
use App\Models\Delivery;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Call the stored procedure to get all products
            $allProducts = collect(DB::select('CALL GetProductOverview()'));
            
            // Get all categories for the filter
            $categories = Category::where('isactive', true)->get();
            
            // Apply search filter if provided
            if ($request->has('search') && !empty($request->search)) {
                $search = strtolower($request->search);
                $allProducts = $allProducts->filter(function ($product) use ($search) {
                    return str_contains(strtolower($product->name), $search) || 
                           str_contains(strtolower($product->ean_code), $search) ||
                           str_contains(strtolower($product->comment ?? ''), $search);
                });
            }
            
            // Apply category filter if provided
            if ($request->has('category') && !empty($request->category)) {
                $categoryId = $request->category;
                $allProducts = $allProducts->filter(function ($product) use ($categoryId) {
                    return $product->categoriesid == $categoryId;
                });
            }
            
            // Pagination - changed from 20 to 25 items per page
            $currentPage = $request->get('page', 1);
            $perPage = 25;
            
            $currentPageItems = $allProducts->slice(($currentPage - 1) * $perPage, $perPage)->values();
            
            $products = new LengthAwarePaginator(
                $currentPageItems,
                $allProducts->count(),
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
            
            // Calculate stats for the dashboard
            $totalStock = $allProducts->sum('stock');
            $expiringProducts = $allProducts->filter(function ($product) {
                return Carbon::parse($product->expiry_date)->lte(Carbon::now()->addDays(7));
            })->count();
            $lastDelivery = Delivery::orderBy('delivery_date', 'desc')->first();
            
            return view('product.index', compact('products', 'categories', 'totalStock', 'expiringProducts', 'lastDelivery'));
        } catch (\Exception $e) {
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de producten: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $categories = Category::where('isactive', true)->get();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'categoriesid' => 'required|exists:categories,id',
            'ean_code' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'comment' => 'nullable|string',
            'isactive' => 'required|boolean',
        ]);

        try {
            // Check if a product with the same EAN code already exists
            if (!empty($request->ean_code)) {
                $existingProduct = Product::where('ean_code', $request->ean_code)
                                        ->where('isactive', true)
                                        ->first();
                
                if ($existingProduct) {
                    // Add the new stock to the existing product's stock
                    $existingProduct->stock += $request->stock;
                    
                    // Update expiry date if the new one is earlier (fresher products expire sooner)
                    if ($request->expiry_date && (!$existingProduct->expiry_date || $request->expiry_date < $existingProduct->expiry_date)) {
                        $existingProduct->expiry_date = $request->expiry_date;
                    }
                    
                    // Update comment if provided
                    if ($request->comment) {
                        $existingProduct->comment = $existingProduct->comment 
                            ? $existingProduct->comment . ' | ' . $request->comment 
                            : $request->comment;
                    }
                    
                    $existingProduct->save();
                    
                    return redirect()->route('products.index')->with('success', 
                        'Voorraad toegevoegd aan bestaand product "' . $existingProduct->name . '". Nieuwe voorraad: ' . $existingProduct->stock);
                }
            }
            
            // Create new product if no existing EAN code found
            Product::create([
                'name' => $request->name,
                'categoriesid' => $request->categoriesid,
                'ean_code' => $request->ean_code,
                'stock' => $request->stock,
                'expiry_date' => $request->expiry_date,
                'comment' => $request->comment,
                'isactive' => $request->isactive,
            ]);

            return redirect()->route('products.index')->with('success', 'Nieuw product succesvol toegevoegd!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van het product: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);
            
            // Get recent deliveries for this product
            $recentDeliveries = Delivery::where('product_id', $id)
                                      ->orderBy('delivery_date', 'desc')
                                      ->limit(5)
                                      ->get();
            
            // Get package items that used this product
            $recentPackageItems = DB::table('package_items')
                                   ->join('food_packages', 'package_items.food_package_id', '=', 'food_packages.id')
                                   ->join('clients', 'food_packages.client_id', '=', 'clients.id')
                                   ->where('package_items.product_id', $id)
                                   ->select(
                                       'package_items.amount',
                                       'package_items.created_at',
                                       'clients.name as client_name',
                                       'food_packages.issued_at'
                                   )
                                   ->orderBy('food_packages.issued_at', 'desc')
                                   ->limit(10)
                                   ->get();
            
            return view('product.show', compact('product', 'recentDeliveries', 'recentPackageItems'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Product niet gevonden.');
        }
    }
}
