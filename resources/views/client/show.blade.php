<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliënt Details - Voedselbank Maaskantje</title>
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
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-green">Voedselbank Maaskantje</h1>
                    <p class="text-sm text-gray-600">Cliënt Details</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('clients.index') }}" class="text-green hover:underline">← Terug naar Overzicht</a>
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

    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">{{ $client->name }}</h2>
            <p class="text-gray-600 mt-2">Cliënt details en informatie</p>
            <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- relevent information --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow border-t-4 border-green p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Persoonlijke Gegevens</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Naam</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $client->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $client->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Telefoon</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $client->phone }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Postcode</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $client->postal_code }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500">Adres</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $client->address }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow border-t-4 border-blue-500 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Gezinssamenstelling</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $client->adults }}</p>
                            <p class="text-sm text-gray-500">Volwassenen</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green">{{ $client->children }}</p>
                            <p class="text-sm text-gray-500">Kinderen</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-purple-600">{{ $client->babies }}</p>
                            <p class="text-sm text-gray-500">Baby's</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-sm text-gray-600">
                            <strong>Totaal gezinsleden:</strong>
                            {{ $client->adults + $client->children + $client->babies }}
                        </p>
                    </div>
                </div>

                @if ($client->comment)
                    <div class="bg-white rounded-lg shadow border-t-4 border-yellow-500 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Opmerkingen</h3>
                        <p class="text-sm text-gray-700">{{ $client->comment }}</p>
                    </div>
                @endif
            </div>


            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Acties</h3>
                    <div class="space-y-3">
                        <a href="{{ route('clients.edit', $client->id) }}"
                            class="block w-full text-center px-4 py-2 bg-green text-white rounded-lg hover:bg-green-700 transition">
                            Bewerken
                        </a>
                        <button type="button" 
                                onclick="openDeleteModal({{ $client->id }}, '{{ $client->name }}')"
                                class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Verwijderen
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Voedingsvoorkeur</h3>
                    @if ($client->preference)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $client->preference }}
                        </span>
                    @else
                        <span class="text-gray-400">Geen speciale wensen</span>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informatie</h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Aangemaakt:</strong> {{ $client->created_at->format('d-m-Y') }}</p>
                        <p><strong>Laatst gewijzigd:</strong> {{ $client->updated_at->format('d-m-Y') }}</p>
                        <p><strong>Status:</strong>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Actief
                            </span>
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Vorige Leveringen</h3>
                    @if($client->foodPackages->count() > 0)
                        <div class="space-y-4">
                            @foreach($client->foodPackages->sortByDesc('created_at') as $package)
                                <div class="border-l-4 border-green p-3 bg-gray-50 rounded">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">{{ $package->created_at->format('d-m-Y') }}</span>
                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded-full">
                                            {{ $package->packageItems->count() }} items
                                        </span>
                                    </div>
                                    @if($package->packageItems->count() > 0)
                                        <div class="mt-2 text-sm text-gray-600">
                                            <p class="font-medium text-xs text-gray-500 mb-1">Producten:</p>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($package->packageItems->take(3) as $item)
                                                    <span class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                        {{ $item->product_name }}
                                                    </span>
                                                @endforeach
                                                @if($package->packageItems->count() > 3)
                                                    <span class="text-xs text-gray-500">+{{ $package->packageItems->count() - 3 }} meer</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">Geen vorige leveringen gevonden.</p>
                    @endif
                </div>
            </div>
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
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Cliënt Verwijderen</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Weet je zeker dat je <span id="clientName" class="font-semibold"></span> wilt verwijderen?
                        Deze actie kan niet ongedaan worden gemaakt.
                    </p>
                </div>
                <div class="flex items-center justify-center gap-4 mt-4">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 transition">
                        Annuleren
                    </button>
                    <form id="deleteForm" method="POST" action="" class="inline">
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
        function openDeleteModal(clientId, clientName) {
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
