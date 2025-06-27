<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Leverancier Toevoegen - Voedselbank Maaskantje</title>
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
                    <p class="text-sm text-gray-600">Nieuwe Leverancier Toevoegen</p>
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
            <h2 class="text-3xl font-bold text-gray-900">Nieuwe Leverancier Toevoegen</h2>
            <p class="text-gray-600 mt-2">Vul alle verplichte velden in om een nieuwe leverancier aan te maken</p>
            <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
        </div>

        @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('suppliers.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Bedrijfsnaam *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Adres *</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('address') border-red-500 @enderror">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700">Contactpersoon *</label>
                        <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('contact_name') border-red-500 @enderror">
                        @error('contact_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Email Contactpersoon *</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('contact_email') border-red-500 @enderror">
                        @error('contact_email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefoonnummer *</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_delivery" class="block text-sm font-medium text-gray-700">Volgende Levering</label>
                        <input type="date" name="next_delivery" id="next_delivery" value="{{ old('next_delivery') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('next_delivery') border-red-500 @enderror">
                        @error('next_delivery')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Opmerkingen</label>
                        <textarea name="comment" id="comment" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <a href="{{ route('suppliers.index') }}"
                        class="px-4 py-2 bg-gray-300 rounded text-gray-800 hover:bg-gray-400 transition">
                        Annuleren
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green text-white rounded hover:bg-green-700 transition">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
