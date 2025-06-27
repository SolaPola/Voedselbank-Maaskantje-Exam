@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Voorraad Overzicht</h2>
        <p class="text-gray-600 mt-2">Alle beschikbare producten in de voorraad</p>
        <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
    </div>
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Advanced Product Search and Filter -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Product Filters</h3>
        <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
            <!-- First Row: Name and EAN Code -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Naam</label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ request('name') }}" 
                           placeholder="Zoek op productnaam..." 
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>
                <div>
                    <label for="ean_code" class="block text-sm font-medium text-gray-700 mb-2">EAN Code / Barcode</label>
                    <input type="text" 
                           name="ean_code" 
                           id="ean_code"
                           value="{{ request('ean_code') }}" 
                           placeholder="Zoek op EAN code..." 
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>
            </div>
            
            <!-- Second Row: Category and Stock Range -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Categorie</label>
                    <select name="category" 
                            id="category"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                        <option value="">Alle categorieën</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="stock_min" class="block text-sm font-medium text-gray-700 mb-2">Min. Voorraad</label>
                    <input type="number" 
                           name="stock_min" 
                           id="stock_min"
                           value="{{ request('stock_min') }}" 
                           placeholder="Minimum..." 
                           min="0"
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>
                <div>
                    <label for="stock_max" class="block text-sm font-medium text-gray-700 mb-2">Max. Voorraad</label>
                    <input type="number" 
                           name="stock_max" 
                           id="stock_max"
                           value="{{ request('stock_max') }}" 
                           placeholder="Maximum..." 
                           min="0"
                           class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2 pt-2">
                <button type="submit" class="bg-green text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                    <i class="fa fa-search mr-2"></i>Zoeken
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition">
                    <i class="fa fa-refresh mr-2"></i>Reset Filters
                </a>
                <div class="ml-auto">
                    <a href="{{ route('products.create') }}" class="bg-orange text-white px-6 py-2 rounded-md hover:bg-orange-700 transition">
                        <i class="fa fa-plus mr-2"></i>Nieuw Product
                    </a>
                </div>
            </div>
        </form>
        
        <!-- Active Filters Display -->
        @if(request()->hasAny(['name', 'ean_code', 'category', 'stock_min', 'stock_max']))
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700">Actieve filters:</span>
                    
                    @if(request('name'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Naam: {{ request('name') }}
                            <a href="{{ route('products.index', array_merge(request()->except('name'))) }}" class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                        </span>
                    @endif
                    
                    @if(request('ean_code'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            EAN: {{ request('ean_code') }}
                            <a href="{{ route('products.index', array_merge(request()->except('ean_code'))) }}" class="ml-2 text-green-600 hover:text-green-800">×</a>
                        </span>
                    @endif
                    
                    @if(request('category'))
                        @php
                            $selectedCategory = $categories->firstWhere('id', request('category'));
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Categorie: {{ $selectedCategory ? $selectedCategory->name : request('category') }}
                            <a href="{{ route('products.index', array_merge(request()->except('category'))) }}" class="ml-2 text-purple-600 hover:text-purple-800">×</a>
                        </span>
                    @endif
                    
                    @if(request('stock_min') || request('stock_max'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Voorraad: {{ request('stock_min', '0') }} - {{ request('stock_max', '∞') }}
                            <a href="{{ route('products.index', array_merge(request()->except(['stock_min', 'stock_max']))) }}" class="ml-2 text-yellow-600 hover:text-yellow-800">×</a>
                        </span>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Results Summary -->
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Gevonden: <span class="font-bold text-gray-900">{{ $products->total() }}</span> producten
                @if(request()->hasAny(['name', 'ean_code', 'category', 'stock_min', 'stock_max']))
                    van alle beschikbare producten
                @endif
            </p>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-green">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-green-50">
                    <tr> 
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="group inline-flex items-center hover:text-gray-700">
                                Naam
                                @if(request('sort') == 'name')
                                    @if(request('direction') == 'asc')
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="ml-2 h-4 w-4 text-gray-300 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'ean_code', 'direction' => request('sort') == 'ean_code' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="group inline-flex items-center hover:text-gray-700">
                                EAN Code
                                @if(request('sort') == 'ean_code')
                                    @if(request('direction') == 'asc')
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="ml-2 h-4 w-4 text-gray-300 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'category', 'direction' => request('sort') == 'category' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="group inline-flex items-center hover:text-gray-700">
                                Categorie
                                @if(request('sort') == 'category')
                                    @if(request('direction') == 'asc')
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="ml-2 h-4 w-4 text-gray-300 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'stock', 'direction' => request('sort') == 'stock' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="group inline-flex items-center hover:text-gray-700">
                                Voorraad
                                @if(request('sort') == 'stock')
                                    @if(request('direction') == 'asc')
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="ml-2 h-4 w-4 text-gray-300 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vervaldatum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acties</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->ean_code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->category_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $product->stock > 20 ? 'bg-green-100 text-green-800' : 
                                      ($product->stock > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm {{ strtotime($product->expiry_date) < strtotime('+7 days') ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                    {{ \Carbon\Carbon::parse($product->expiry_date)->format('d-m-Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $product->isactive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $product->isactive ? 'Actief' : 'Inactief' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 flex items-center"
                                       title="Bekijk details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="text-green hover:text-green-700 flex items-center"
                                       title="Bewerk product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 flex items-center"
                                                title="Verwijder product"
                                                onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Geen producten gevonden
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $products->links() }}
        </div>
    </div>
    
    <!-- Product Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Totale voorraad</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalStock }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6 text-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Binnenkort verlopen</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $expiringProducts }}</p>
                </div>
            </div>
        </div> 
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Categorieën</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Laatste levering</h3>
                    <p class="text-sm text-gray-900">
                        @if($lastDelivery)
                            {{ $lastDelivery->supplier_name }} - {{ \Carbon\Carbon::parse($lastDelivery->delivery_date)->format('d-m-Y') }}
                        @else
                            Geen recente leveringen
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
