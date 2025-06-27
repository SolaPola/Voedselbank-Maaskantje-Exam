<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselpakketten Overzicht</title>
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
                    <p class="text-sm text-gray-600">Voedselpakketten Overzicht</p>
                </div>
                <a href="/" class="text-green hover:underline">← Terug naar Dashboard</a>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Voedselpakketten Overzicht</h2>
                    <p class="text-gray-600 mt-2">Alle voedselpakketten met hun gegevens</p>
                    <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
                </div>
                <a href="{{ route('foodpackages.create') }}"
                    class="bg-green text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    + Nieuw Voedselpakket
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($foodpackages->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-orange">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-orange-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Soort Voedselpakket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gezinssamenstelling</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aangemaakt op</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($foodpackages as $foodpackage)
                                <tr class="hover:bg-orange-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $foodpackage->client->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $foodpackage->soort_voedselpakket ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $foodpackage->gezinssamenstelling ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $foodpackage->created_at ? $foodpackage->created_at->format('d-m-Y') : '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('foodpackages.show', $foodpackage) }}"
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
                                            <button type="button"
                                                onclick="openDeleteModal({{ $foodpackage->id }}, '{{ $foodpackage->client->name ?? '-' }}')"
                                                class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-100 transition"
                                                title="Verwijderen">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination (if needed) --}}
                {{-- <div class="bg-gradient-to-r from-white to-orange-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $foodpackages->links() }}
                </div> --}}
            </div>
        @else
            <div class="p-4 bg-blue-50 text-blue-800 rounded">
                Er zijn momenteel geen voedselpakketten beschikbaar.
            </div>
        @endif

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
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Voedselpakket Verwijderen</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Weet je zeker dat je <span id="foodpackageName" class="font-semibold"></span> wilt verwijderen?
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
            function openDeleteModal(foodpackageId, foodpackageName) {
                document.getElementById('foodpackageName').textContent = foodpackageName;
                document.getElementById('deleteForm').action = '/foodpackages/' + foodpackageId;
                document.getElementById('deleteModal').classList.remove('hidden');
            }
            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                }
            });
        </script>
    </main>
</body>
</html>