<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, Employee!</h3>
                    <p class="mb-4">Manage daily operations and assist families.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-orange-800">Family Management</h4>
                            <p class="text-orange-600">Register and manage family information</p>
                        </div>
                        <div class="bg-teal-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-teal-800">Package Distribution</h4>
                            <p class="text-teal-600">Create and distribute food packages</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
