<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leveranciers Overzicht') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">Alle Leveranciers</h3>
                        <a href="#" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Nieuwe Leverancier
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border-b text-left">Naam</th>
                                    <th class="py-2 px-4 border-b text-left">Adres</th>
                                    <th class="py-2 px-4 border-b text-left">Contactpersoon</th>
                                    <th class="py-2 px-4 border-b text-left">Email</th>
                                    <th class="py-2 px-4 border-b text-left">Telefoon</th>
                                    <th class="py-2 px-4 border-b text-left">Volgende Levering</th>
                                    <th class="py-2 px-4 border-b text-left">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $supplier->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $supplier->address }}</td>
                                    <td class="py-2 px-4 border-b">{{ $supplier->contact_name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $supplier->contact_email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $supplier->phone }}</td>
                                    <td class="py-2 px-4 border-b">{{ $supplier->next_delivery ? date('d-m-Y', strtotime($supplier->next_delivery)) : 'Niet gepland' }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex space-x-2">
                                            <a href="#" class="text-blue-500 hover:underline">Details</a>
                                            <a href="#" class="text-green-500 hover:underline">Bewerken</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if(count($suppliers) === 0)
                                <tr>
                                    <td colspan="7" class="py-4 px-4 text-center text-gray-500">Geen leveranciers gevonden</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
