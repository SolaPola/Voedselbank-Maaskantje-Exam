@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 text-xl font-semibold">
            Voedselpakketten Overzicht
        </div>
        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('foodpackages.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Nieuw Voedselpakket
            </a>

            @if($foodpackages->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-left">Naam</th>
                                <th class="px-4 py-2 border-b text-left">Aangemaakt op</th>
                                <th class="px-4 py-2 border-b text-left">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($foodpackages as $foodpackage)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b">{{ $foodpackage->clientid }}</td>
                                    <td class="px-4 py-2 border-b">{{ $foodpackage->created_at ? $foodpackage->created_at->format('d-m-Y') : '-' }}</td>
                                    <td class="px-4 py-2 border-b space-x-2">
                                        <a href="{{ route('foodpackages.show', $foodpackage) }}"
                                           class="inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
                                            Bekijken
                                        </a>
                                        <a href="{{ route('foodpackages.edit', $foodpackage) }}"
                                           class="inline-block px-3 py-1 bg-yellow-400 text-white text-xs rounded hover:bg-yellow-500 transition">
                                            Bewerken
                                        </a>
                                        <form action="{{ route('foodpackages.destroy', $foodpackage) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Weet je zeker dat je dit voedselpakket wilt verwijderen?')"
                                                class="inline-block px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition">
                                                Verwijderen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 bg-blue-50 text-blue-800 rounded">
                    Er zijn momenteel geen voedselpakketten beschikbaar.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection