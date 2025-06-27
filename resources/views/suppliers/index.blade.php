<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leveranciers Overzicht - Voedselbank Maaskantje</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green': '#166534',
                        'orange': '#EA580C',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-green">Voedselbank Maaskantje</h1>
                    <p class="text-sm text-gray-600">Leveranciers Overzicht</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-green hover:underline">← Terug naar
                        Dashboard</a>
                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                            Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Leveranciers Overzicht</h2>
                    <p class="text-gray-600 mt-2">Alle actieve leveranciers met hun contactgegevens en leveringsinformatie
                    </p>
                    <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
                </div>
                <a href="{{ route('suppliers.create') }}"
                    class="bg-green text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    + Nieuwe Leverancier
                </a>
            </div>
        </div>

        @if (session('success'))
            <div id="success-alert" class="mb-6 bg-green-100 border-l-4 border-green-500 shadow-md p-4 rounded-lg animate-pulse">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-base font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="error-alert" class="mb-6 bg-red-100 border-l-4 border-red-500 shadow-md p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">Systeemfout</p>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" onclick="document.getElementById('error-alert').remove()" class="inline-flex bg-red-100 rounded-md p-1.5 text-red-500 hover:bg-red-200 focus:outline-none">
                                <span class="sr-only">Sluiten</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-2 pl-10">
                    <div class="text-sm text-red-700">
                        <p>Mogelijke oorzaken:</p>
                        <ul class="list-disc pl-5 mt-1 space-y-1">
                            <li>Er is een probleem met de database verbinding</li>
                            <li>De server is momenteel overbelast</li>
                            <li>Er kan een tijdelijk technisch probleem zijn</li>
                        </ul>
                    </div>
                    <div class="mt-3 flex space-x-3">
                        <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Probeer opnieuw
                        </a>
                        <button onclick="window.location.reload()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Ververs pagina
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if($error)
        <!-- Error Message -->
        <div class="mb-6 bg-red-50 p-4 rounded-lg shadow border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Systeemfout</h3>
                    <div class="mt-1 text-sm text-red-700">
                        {{ $error }}
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Terug naar dashboard
                        </a>
                        <button onclick="window.location.reload()" class="ml-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Probeer opnieuw
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Filter Section -->
        <div class="mb-6 bg-white p-4 rounded-lg shadow border-l-4 border-green">
            <form method="GET" action="{{ route('suppliers.index') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="delivery_date" class="block text-sm font-medium text-gray-700 mb-2">Filter op
                        Leveringsdatum</label>
                    <select id="delivery_date" name="delivery_date"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                        <option value="all" {{ ($deliveryFilter ?? 'all') === 'all' ? 'selected' : '' }}>Alle
                            leveringen</option>
                        @foreach ($allDeliveryOptions as $key => $label)
                            <option value="{{ $key }}"
                                {{ ($deliveryFilter ?? '') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex space-x-2 pt-6">
                    <button type="submit"
                        class="bg-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Filter
                    </button>
                    @if ($deliveryFilter && $deliveryFilter !== 'all')
                        <a href="{{ route('suppliers.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div class="mb-6 bg-white p-4 rounded-lg shadow border-l-4 border-orange">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">
                            @if ($deliveryFilter && $deliveryFilter !== 'all')
                                Gefilterde Leveranciers
                                ({{ $allDeliveryOptions[$deliveryFilter] }})
                            @else
                                Totaal Actieve Leveranciers
                            @endif
                        </h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $suppliers->total() }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-600">
                    Pagina {{ $suppliers->currentPage() }} van {{ $suppliers->lastPage() }}
                    ({{ $suppliers->firstItem() ?? 0 }}-{{ $suppliers->lastItem() ?? 0 }})
                </div>
            </div>
        </div>

        <!-- Suppliers Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-orange">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-orange-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Naam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Adres</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contactpersoon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Telefoon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Volgende Levering</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Opmerkingen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-orange-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $supplier->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $supplier->address }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $supplier->contact_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $supplier->contact_email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $supplier->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if ($supplier->next_delivery)
                                            {{ \Carbon\Carbon::parse($supplier->next_delivery)->format('d-m-Y') }}
                                        @else
                                            <span class="text-gray-400">Niet gepland</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($supplier->comment)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ Str::limit($supplier->comment, 20) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Geen</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('suppliers.show', $supplier->id) }}"
                                            class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-100 transition"
                                            title="Bekijken">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                            class="text-green hover:text-green-700 p-1 rounded hover:bg-green-100 transition"
                                            title="Bewerken">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('suppliers.destroy', $supplier->id) }}"
                                            class="inline delete-supplier-form-{{ $supplier->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('{{ $supplier->id }}', '{{ $supplier->name }}')"
                                                class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-100 transition"
                                                title="Verwijderen">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center bg-red-50">
                                    <div class="flex flex-col items-center p-4 border border-red-200 rounded-lg bg-red-100">
                                        <svg class="w-12 h-12 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-red-700 font-bold text-lg">Geen leveranciers gevonden</p>
                                        <p class="text-red-600 mt-1">Er zijn momenteel geen actieve leveranciers in het systeem
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gradient-to-r from-white to-orange-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($suppliers->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                Vorige
                            </span>
                        @else
                            <a href="{{ $suppliers->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Vorige
                            </a>
                        @endif

                        @if ($suppliers->hasMorePages())
                            <a href="{{ $suppliers->nextPageUrl() }}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Volgende
                            </a>
                        @else
                            <span
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                Volgende
                            </span>
                        @endif
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Toont <span class="font-medium">{{ $suppliers->firstItem() ?? 0 }}</span> tot <span
                                    class="font-medium">{{ $suppliers->lastItem() ?? 0 }}</span> van <span
                                    class="font-medium">{{ $suppliers->total() }}</span> resultaten
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                                {{-- Previous Page Link --}}
                                @if ($suppliers->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $suppliers->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($suppliers->getUrlRange(1, $suppliers->lastPage()) as $page => $url)
                                    @if ($page == $suppliers->currentPage())
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-green text-white text-sm font-medium">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($suppliers->hasMorePages())
                                    <a href="{{ $suppliers->nextPageUrl() }}"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                    </a>
                                @else
                                    <span
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </main>

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight the success message with animation
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                // Make it pulse gently
                successAlert.classList.add('animate-pulse');
                
                // Add green glow effect
                successAlert.style.boxShadow = '0 0 10px rgba(22, 101, 52, 0.5)';
                
                // Gradually fade out after 4 seconds
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 1s, transform 1s';
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 1000);
                }, 4000);
            }
        });

        function confirmDelete(supplierId, supplierName) {
            if (confirm(`Weet je zeker dat je leverancier "${supplierName}" wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.`)) {
                document.querySelector(`.delete-supplier-form-${supplierId}`).submit();
            }
        }
    </script>
</body>

</html>
