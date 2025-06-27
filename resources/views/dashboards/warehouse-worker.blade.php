<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazijnmedewerker Dashboard - Voedselbank Maaskantje</title>
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
                    <h1 class="text-2xl font-bold text-blue-600">Voedselbank Maaskantje</h1>
                    <p class="text-sm text-gray-600">Magazijnmedewerker Dashboard</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welkom, {{ Auth::user()->name }}</span>
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
        <!-- Welcome Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Magazijn Overzicht</h2>
            <p class="text-gray-600">Beheer voorraad en distributie van voedselpakketten</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Voorraad Items</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $inventoryItems }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Wachtende Leveringen</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingDeliveries }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Vandaag Voltooid</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $completedToday }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Voorraadbeheer</h3>
                <div class="space-y-3">
                    <a href="{{ route('products.index') }}"
                        class="block w-full text-left px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        📦 Voorraad Bekijken
                    </a>
                    <a href="#"
                        class="block w-full text-left px-4 py-3 bg-green text-white rounded-lg hover:bg-green-700 transition duration-200">
                        ➕ Nieuwe Voorraad Toevoegen
                    </a>
                    <a href="#"
                        class="block w-full text-left px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                        ⚠️ Verlopen Items Controleren
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Distributie</h3>
                <div class="space-y-3">
                    <a href="#"
                        class="block w-full text-left px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                        📋 Voedselpakketten Voorbereiden
                    </a>
                    <a href="#"
                        class="block w-full text-left px-4 py-3 bg-orange text-white rounded-lg hover:bg-orange-700 transition duration-200">
                        🚚 Levering Plannen
                    </a>
                    <a href="#"
                        class="block w-full text-left px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                        📊 Distributie Rapport
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recente Magazijn Activiteit</h3>
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-2 h-2 bg-green rounded-full mr-3"></div>
                    <p class="text-sm text-gray-700">15 voedselpakketten voorbereid</p>
                    <span class="ml-auto text-xs text-gray-500">2 uur geleden</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                    <p class="text-sm text-gray-700">Nieuwe voorraad toegevoegd: Rijst 50kg</p>
                    <span class="ml-auto text-xs text-gray-500">4 uur geleden</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-2 h-2 bg-orange rounded-full mr-3"></div>
                    <p class="text-sm text-gray-700">Levering gepland voor morgen</p>
                    <span class="ml-auto text-xs text-gray-500">6 uur geleden</span>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
