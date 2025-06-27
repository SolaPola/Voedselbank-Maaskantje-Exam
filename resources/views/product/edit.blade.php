@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Product Bewerken</h2>
        <p class="text-gray-600 mt-2">Bewerk de gegevens van {{ $product->name }}</p>
        <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Warning about EAN code changes -->
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm">
                    <strong>Let op:</strong> Het wijzigen van de EAN code kan gevolgen hebben voor de voorraadregistratie. Wees voorzichtig bij het aanpassen van deze waarde.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-green">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Productnaam <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>

                <!-- Category -->
                <div>
                    <label for="categoriesid" class="block text-sm font-medium text-gray-700 mb-2">
                        Categorie <span class="text-red-500">*</span>
                    </label>
                    <select name="categoriesid" id="categoriesid" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                        <option value="">Selecteer een categorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categoriesid', $product->categoriesid) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- EAN Code -->
                <div>
                    <label for="ean_code" class="block text-sm font-medium text-gray-700 mb-2">
                        EAN Code
                        <span class="text-yellow-600 text-xs">(wees voorzichtig met wijzigen)</span>
                    </label>
                    <input type="text" name="ean_code" id="ean_code" value="{{ old('ean_code', $product->ean_code) }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Voorraad <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Vervaldatum
                    </label>
                    <input type="date" name="expiry_date" id="expiry_date" 
                        value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                </div>

                <!-- Status -->
                <div>
                    <label for="isactive" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select name="isactive" id="isactive"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green">
                        <option value="1" {{ old('isactive', $product->isactive) == 1 ? 'selected' : '' }}>Actief</option>
                        <option value="0" {{ old('isactive', $product->isactive) == 0 ? 'selected' : '' }}>Inactief</option>
                    </select>
                </div>
            </div>

            <!-- Comment -->
            <div class="mt-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                    Opmerkingen
                </label>
                <textarea name="comment" id="comment" rows="3"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green"
                    placeholder="Eventuele opmerkingen over het product...">{{ old('comment', $product->comment) }}</textarea>
            </div>

            <!-- Product Information -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Product Informatie</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Aangemaakt:</span>
                        {{ $product->created_at->format('d-m-Y H:i') }}
                    </div>
                    <div>
                        <span class="font-medium">Laatst bijgewerkt:</span>
                        {{ $product->updated_at->format('d-m-Y H:i') }}
                    </div>
                    <div>
                        <span class="font-medium">Product ID:</span>
                        #{{ $product->id }}
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('products.index') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition">
                    Annuleren
                </a>
                <div class="flex space-x-3">
                    <a href="{{ route('products.show', $product->id) }}" 
                       class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                        Bekijk Details
                    </a>
                    <button type="submit" 
                            class="bg-green text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                        Product Bijwerken
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
