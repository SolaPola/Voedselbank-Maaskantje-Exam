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
@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Voedselpakket Details</h2>
                <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
            </div>
            <a href="{{ route('foodpackages.index') }}"
                class="bg-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                ← Terug naar overzicht
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden border-t-4 border-orange">
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-gray-500 font-semibold mb-1">Naam cliënt</div>
                    <div class="text-lg text-gray-900">{{ $foodpackage->client->name ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-semibold mb-1">Soort voedselpakket</div>
                    <div class="text-lg text-gray-900">{{ $foodpackage->soort_voedselpakket ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-semibold mb-1">Gezinssamenstelling</div>
                    <div class="text-lg text-gray-900">{{ $foodpackage->gezinssamenstelling ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-semibold mb-1">Uitgegeven op</div>
                    <div class="text-lg text-gray-900">
                        {{ $foodpackage->issued_at ? \Carbon\Carbon::parse($foodpackage->issued_at)->format('d-m-Y') : '-' }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-semibold mb-1">Opmerking</div>
                    <div class="text-lg text-gray-900">{{ $foodpackage->comment ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-semibold mb-1">Actief</div>
                    <div class="text-lg">
                        @if($foodpackage->isactive)
                            <span class="text-green-600 font-bold">Ja</span>
                        @else
                            <span class="text-red-600 font-bold">Nee</span>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-semibold mb-1">Aangemaakt op</div>
                    <div class="text-lg text-gray-900">
                        {{ $foodpackage->created_at ? $foodpackage->created_at->format('d-m-Y H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
