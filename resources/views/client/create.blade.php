<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Cliënt - Voedselbank Maaskantje</title>
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
                    <p class="text-sm text-gray-600">Nieuwe Cliënt Toevoegen</p>
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
            <h2 class="text-3xl font-bold text-gray-900">Nieuwe Cliënt Toevoegen</h2>
            <p class="text-gray-600 mt-2">Vul alle benodigde gegevens in voor de nieuwe cliënt</p>
            <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
        </div>

        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->has('family_size'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ $errors->first('family_size') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow border-t-4 border-orange">
            <form method="POST" action="{{ route('clients.store') }}" class="p-6 space-y-6" novalidate>
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Naam *
                            <span class="text-xs text-gray-500">(alleen letters, spaties, -, . en ')</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            maxlength="255" pattern="[a-zA-Z\s\-\.']+"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                            <span class="text-xs text-gray-500">(moet geldig en uniek zijn)</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            maxlength="255"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adres *
                        <span class="text-xs text-gray-500">(minimaal 5 karakters)</span>
                    </label>
                    <textarea id="address" name="address" rows="2" required maxlength="500"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Postcode *
                            <span class="text-xs text-gray-500">(bijv. 1234 AB)</span>
                        </label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                            required pattern="[1-9][0-9]{3}\s?[A-Za-z]{2}" placeholder="1234 AB"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('postal_code') border-red-500 @enderror">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Telefoon *
                            <span class="text-xs text-gray-500">(Nederlands nummer)</span>
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                            pattern="(\+31|0)[1-9][0-9\-\s]{8,10}" placeholder="06-12345678"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="preference"
                        class="block text-sm font-medium text-gray-700 mb-2">Voedingsvoorkeuren</label>
                    <select id="preference" name="preference"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent">
                        <option value="">Geen speciale wensen</option>
                        <option value="Vegetarisch" {{ old('preference') == 'Vegetarisch' ? 'selected' : '' }}>
                            Vegetarisch</option>
                        <option value="Veganistisch" {{ old('preference') == 'Veganistisch' ? 'selected' : '' }}>
                            Veganistisch</option>
                        <option value="Halal" {{ old('preference') == 'Halal' ? 'selected' : '' }}>Halal</option>
                        <option value="Glutenvrij" {{ old('preference') == 'Glutenvrij' ? 'selected' : '' }}>Glutenvrij
                        </option>
                        <option value="Lactosevrij" {{ old('preference') == 'Lactosevrij' ? 'selected' : '' }}>
                            Lactosevrij</option>
                        <option value="Diabetisch" {{ old('preference') == 'Diabetisch' ? 'selected' : '' }}>Diabetisch
                        </option>
                    </select>
                    @error('preference')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Gezinssamenstelling
                        <span class="text-xs text-gray-500">(maximaal 30 personen totaal)</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="adults" class="block text-sm font-medium text-gray-700 mb-2">
                                Volwassenen *
                                <span class="text-xs text-gray-500">(min. 1)</span>
                            </label>
                            <input type="number" id="adults" name="adults" value="{{ old('adults', 1) }}"
                                min="1" max="20" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('adults') border-red-500 @enderror">
                            @error('adults')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="children" class="block text-sm font-medium text-gray-700 mb-2">
                                Kinderen *
                                <span class="text-xs text-gray-500">(0-20)</span>
                            </label>
                            <input type="number" id="children" name="children" value="{{ old('children', 0) }}"
                                min="0" max="20" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('children') border-red-500 @enderror">
                            @error('children')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="babies" class="block text-sm font-medium text-gray-700 mb-2">
                                Baby's *
                                <span class="text-xs text-gray-500">(0-10)</span>
                            </label>
                            <input type="number" id="babies" name="babies" value="{{ old('babies', 0) }}"
                                min="0" max="10" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('babies') border-red-500 @enderror">
                            @error('babies')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        Opmerkingen
                        <span class="text-xs text-gray-500">(max. 1000 karakters)</span>
                    </label>
                    <textarea id="comment" name="comment" rows="3" maxlength="1000"
                        placeholder="Aanvullende informatie over de cliënt..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green focus:border-transparent @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <span id="comment-count">{{ strlen(old('comment', '')) }}</span>/1000 karakters
                    </p>
                </div>

                <div class="flex items-center justify-between pt-6 border-t">
                    <a href="{{ route('clients.index') }}"
                        class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Annuleren
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-green text-white rounded-md hover:bg-green-700 transition">
                        Cliënt Toevoegen
                    </button>
                </div>
            </form>
        </div>

        <script>
            // Character counter for comment field
            document.getElementById('comment').addEventListener('input', function() {
                const count = this.value.length;
                document.getElementById('comment-count').textContent = count;

                if (count > 1000) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            // Real-time validation feedback
            document.getElementById('postal_code').addEventListener('input', function() {
                const pattern = /^[1-9][0-9]{3}\s?[A-Za-z]{2}$/;
                if (this.value && !pattern.test(this.value)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            document.getElementById('phone').addEventListener('input', function() {
                const pattern = /^(\+31|0)[1-9][0-9\-\s]{8,10}$/;
                if (this.value && !pattern.test(this.value)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
        </script>
    </main>
</body>

</html>
