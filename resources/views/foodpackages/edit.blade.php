<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselpakket Bewerken</title>
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
                    <p class="text-sm text-gray-600">Voedselpakket Bewerken</p>
                </div>
                <a href="{{ route('foodpackages.index') }}" class="text-green hover:underline">← Terug naar overzicht</a>
            </div>
        </div>
    </header>
    <main>
        <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Voedselpakket Bewerken</h2>
                <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
            </div>
            <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-orange">
                <form method="POST" action="{{ route('foodpackages.update', $foodpackage) }}" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Naam cliënt</label>
                            <input type="text" name="client_name" value="{{ old('client_name', $foodpackage->client->name ?? '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green"
                                disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Soort voedselpakket</label>
                            <input type="text" name="soort_voedselpakket" value="{{ old('soort_voedselpakket', $foodpackage->soort_voedselpakket) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Gezinssamenstelling</label>
                            <input type="text" name="gezinssamenstelling" value="{{ old('gezinssamenstelling', $foodpackage->gezinssamenstelling) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Uitgegeven op</label>
                            <input type="date" name="issued_at" value="{{ old('issued_at', $foodpackage->issued_at ? \Carbon\Carbon::parse($foodpackage->issued_at)->format('Y-m-d') : '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Opmerking</label>
                            <input type="text" name="comment" value="{{ old('comment', $foodpackage->comment) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Actief</label>
                            <select name="isactive" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green">
                                <option value="1" {{ old('isactive', $foodpackage->isactive) ? 'selected' : '' }}>Ja</option>
                                <option value="0" {{ old('isactive', $foodpackage->isactive) ? '' : 'selected' }}>Nee</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Aangemaakt op</label>
                            <input type="text" value="{{ $foodpackage->created_at ? $foodpackage->created_at->format('d-m-Y H:i') : '-' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-100" disabled>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-8">
                        <button type="submit"
                            class="bg-orange text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition font-semibold">
                            Opslaan
                        </button>
                        <a href="{{ route('foodpackages.show', $foodpackage) }}"
                            class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                            Annuleren
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
</body>
</html>
