<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leverancier Details - Voedselbank Maaskantje</title>
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
                    <p class="text-sm text-gray-600">Leverancier Details</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('suppliers.index') }}" class="text-green hover:underline">← Terug naar
                        Leveranciers</a>
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
                    <h2 class="text-3xl font-bold text-gray-900">{{ $supplier->name }}</h2>
                    <p class="text-gray-600 mt-2">Details en leveringsgeschiedenis</p>
                    <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                        class="bg-green text-white px-6 py-2 rounded-lg hover:bg-green-700 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Bewerken
                    </a>
                    <form method="POST" action="{{ route('suppliers.destroy', $supplier->id) }}" 
                          id="deleteSupplierForm" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                onclick="showDeleteModal()"
                                class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Supplier Details -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="border-b border-gray-200">
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-orange-50">
                    <h3 class="text-lg font-medium text-gray-900">Leverancier Informatie</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Naam</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $supplier->name }}</dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Adres</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $supplier->address }}</dd>
                            </div>

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Contactpersoon</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $supplier->contact_name }}</dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="mailto:{{ $supplier->contact_email }}" class="text-blue-600 hover:underline">
                                        {{ $supplier->contact_email }}
                                    </a>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Telefoon</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="tel:{{ $supplier->phone }}" class="text-blue-600 hover:underline">
                                        {{ $supplier->phone }}
                                    </a>
                                </dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Volgende levering</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if ($supplier->next_delivery)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ \Carbon\Carbon::parse($supplier->next_delivery)->format('d-m-Y') }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            ({{ \Carbon\Carbon::parse($supplier->next_delivery)->diffForHumans() }})
                                        </span>
                                    @else
                                        <span class="text-gray-500">Niet gepland</span>
                                    @endif
                                </dd>
                            </div>

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Toegevoegd op</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ \Carbon\Carbon::parse($supplier->created_at)->format('d-m-Y H:i') }}
                                </dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-md mb-2">
                                <dt class="text-sm font-medium text-gray-500">Laatst bijgewerkt</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ \Carbon\Carbon::parse($supplier->updated_at)->format('d-m-Y H:i') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Opmerkingen -->
                <div class="mt-6 bg-gray-50 px-4 py-5 rounded-md">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Opmerkingen</h4>
                    <div class="mt-1 text-sm text-gray-900">
                        @if ($supplier->comment)
                            <p>{{ $supplier->comment }}</p>
                        @else
                            <p class="text-gray-500 italic">Geen opmerkingen beschikbaar</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Leveringsgeschiedenis -->
        <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="border-b border-gray-200">
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-orange-50">
                    <h3 class="text-lg font-medium text-gray-900">Leveringsgeschiedenis</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Datum</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aantal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Opmerkingen</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if($supplier->deliveries && $supplier->deliveries->count() > 0)
                            @foreach($supplier->deliveries as $delivery)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($delivery->delivery_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $delivery->product ? $delivery->product->name : 'Onbekend product' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $delivery->amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $delivery->comment ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Geen leveringen gevonden voor deze leverancier
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Contact Actions -->
        <div class="mt-8 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
            <a href="tel:{{ $supplier->phone }}"
                class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                    </path>
                </svg>
                Bellen
            </a>
            <a href="{{ route('suppliers.index') }}"
                class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Terug naar overzicht
            </a>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Leverancier Verwijderen</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Weet je zeker dat je <span id="supplierName" class="font-semibold">{{ $supplier->name }}</span> wilt verwijderen?
                        Deze actie kan niet ongedaan worden gemaakt.
                    </p>
                </div>
                <div class="flex items-center justify-center gap-4 mt-4">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 transition">
                        Annuleren
                    </button>
                    <form id="deleteForm" method="POST" action="{{ route('suppliers.destroy', $supplier->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 transition">
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</body>

</html>
            document.getElementById('clientName').textContent = clientName;
            document.getElementById('deleteForm').action = `/admin/clients/${clientId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</body>

</html>
