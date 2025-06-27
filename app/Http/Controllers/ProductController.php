<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Category;
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
}
