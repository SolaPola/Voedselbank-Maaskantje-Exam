<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliënt Bewerken - Voedselbank Maaskantje</title>
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
                    <p class="text-sm text-gray-600">Cliënt Bewerken</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('clients.index') }}" class="text-green hover:underline">← Terug naar Overzicht</a>
                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                            Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Cliënt Bewerken</h2>
            <p class="text-gray-600 mt-2">Wijzig de gegevens van {{ $client->name }}</p>
            <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow border-t-4 border-orange">
            <form method="POST" action="{{ route('clients.update', $client->id) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Naam *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adres *</label>
                    <textarea id="address" name="address" rows="2" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">{{ old('address', $client->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postcode *</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefoon *</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $client->phone) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="preference" class="block text-sm font-medium text-gray-700 mb-2">Voedingsvoorkeuren</label>
                    <select id="preference" name="preference"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                        <option value="">Geen speciale wensen</option>
                        <option value="Vegetarisch" {{ old('preference', $client->preference) == 'Vegetarisch' ? 'selected' : '' }}>Vegetarisch</option>
                        <option value="Veganistisch" {{ old('preference', $client->preference) == 'Veganistisch' ? 'selected' : '' }}>Veganistisch</option>
                        <option value="Halal" {{ old('preference', $client->preference) == 'Halal' ? 'selected' : '' }}>Halal</option>
                        <option value="Glutenvrij" {{ old('preference', $client->preference) == 'Glutenvrij' ? 'selected' : '' }}>Glutenvrij</option>
                        <option value="Lactosevrij" {{ old('preference', $client->preference) == 'Lactosevrij' ? 'selected' : '' }}>Lactosevrij</option>
                        <option value="Diabetisch" {{ old('preference', $client->preference) == 'Diabetisch' ? 'selected' : '' }}>Diabetisch</option>
                    </select>
                    @error('preference')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Gezinssamenstelling</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="adults" class="block text-sm font-medium text-gray-700 mb-2">Volwassenen *</label>
                            <input type="number" id="adults" name="adults" value="{{ old('adults', $client->adults) }}" min="0" max="20" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                            @error('adults')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="children" class="block text-sm font-medium text-gray-700 mb-2">Kinderen *</label>
                            <input type="number" id="children" name="children" value="{{ old('children', $client->children) }}" min="0" max="20" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                            @error('children')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="babies" class="block text-sm font-medium text-gray-700 mb-2">Baby's *</label>
                            <input type="number" id="babies" name="babies" value="{{ old('babies', $client->babies) }}" min="0" max="10" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                            @error('babies')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Opmerkingen</label>
                    <textarea id="comment" name="comment" rows="3" placeholder="Aanvullende informatie over de cliënt..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">{{ old('comment', $client->comment) }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-6 border-t">
                    <div class="flex space-x-3">
                        <a href="{{ route('clients.index') }}" 
                            class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                            Annuleren
                        </a>
                        <a href="{{ route('clients.show', $client->id) }}" 
                            class="px-6 py-3 border border-blue-300 rounded-md text-blue-700 hover:bg-blue-50 transition">
                            Bekijken
                        </a>
                    </div>
                    <button type="submit" 
                        class="px-6 py-3 bg-green text-white rounded-md hover:bg-green-700 transition">
                        Wijzigingen Opslaan
                    </button>
                </div>
            </form>
        </div>

        <!-- Client Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm text-blue-800">
                        <strong>Cliënt ID:</strong> {{ $client->id }} | 
                        <strong>Aangemaakt:</strong> {{ $client->created_at->format('d-m-Y H:i') }} |
                        <strong>Laatst gewijzigd:</strong> {{ $client->updated_at->format('d-m-Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
