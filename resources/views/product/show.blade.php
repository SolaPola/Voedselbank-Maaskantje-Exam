@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Product Details</h2>
                <p class="text-gray-600 mt-2">{{ $product->name }}</p>
                <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
            </div>
            <div>
                <a href="{{ route('products.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                    ← Terug naar Overzicht
                </a>
            </div>
        </div>
    </div>

    <!-- Product Information Card -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Basic Information -->
        <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-green">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-green-50">
                <h3 class="text-lg font-semibold text-gray-900">Productinformatie</h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Naam:</span>
                    <span class="text-gray-900">{{ $product->name }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">EAN Code:</span>
                    <span class="text-gray-900">{{ $product->ean_code ?: 'Niet opgegeven' }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">Categorie:</span>
                    <span class="text-gray-900">{{ $product->category->name }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Voorraad:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $product->stock > 20 ? 'bg-green-100 text-green-800' : 
                          ($product->stock > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $product->stock }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Vervaldatum:</span>
                    <span class="text-sm {{ strtotime($product->expiry_date) < strtotime('+7 days') ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                        @if($product->expiry_date)
                            {{ \Carbon\Carbon::parse($product->expiry_date)->format('d-m-Y') }}
                            @if(strtotime($product->expiry_date) < strtotime('+7 days'))
                                <br><small class="text-red-500">(Vervalt binnenkort!)</small>
                            @endif
                        @else
                            Niet opgegeven
                        @endif
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Status:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $product->isactive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $product->isactive ? 'Actief' : 'Inactief' }}
                    </span>
                </div>
                
                @if($product->comment)
                <div class="pt-4 border-t">
                    <span class="font-medium text-gray-600">Opmerkingen:</span>
                    <p class="text-gray-900 mt-1">{{ $product->comment }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-orange">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-orange-50">
                <h3 class="text-lg font-semibold text-gray-900">Statistieken</h3>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green">{{ $recentDeliveries->sum('amount') }}</div>
                        <div class="text-sm text-gray-600">Totaal ontvangen</div>
                        <div class="text-xs text-gray-500">(laatste 5 leveringen)</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-orange">{{ $recentPackageItems->sum('amount') }}</div>
                        <div class="text-sm text-gray-600">Totaal uitgegeven</div>
                        <div class="text-xs text-gray-500">(laatste 10 pakketten)</div>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <div class="text-center">
                        <div class="text-sm text-gray-600">Toegevoegd op:</div>
                        <div class="text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($product->created_at)->format('d-m-Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Deliveries -->
        <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-blue-500">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50">
                <h3 class="text-lg font-semibold text-gray-900">Recente Leveringen</h3>
            </div>
            <div class="px-6 py-4">
                @if($recentDeliveries->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentDeliveries as $delivery)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $delivery->supplier_name }}</div>
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('d-m-Y') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green">+{{ $delivery->amount }}</div>
                                    <div class="text-xs text-gray-500">stuks</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Geen recente leveringen gevonden</p>
                @endif
            </div>
        </div>

        <!-- Recent Package Items -->
        <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-purple-500">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-purple-50">
                <h3 class="text-lg font-semibold text-gray-900">Recente Uitgiftes</h3>
            </div>
            <div class="px-6 py-4">
                @if($recentPackageItems->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentPackageItems as $item)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $item->client_name }}</div>
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->issued_at)->format('d-m-Y') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-red-600">-{{ $item->amount }}</div>
                                    <div class="text-xs text-gray-500">stuks</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Geen recente uitgiftes gevonden</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
