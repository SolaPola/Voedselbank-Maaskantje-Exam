<nav class="mt-5">
    <ul class="space-y-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-base font-normal {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700' }} rounded-lg">
                <svg class="w-6 h-6 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="ml-3">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('suppliers.index') }}" class="flex items-center p-2 text-base font-normal {{ request()->routeIs('suppliers.index') ? 'bg-gray-700 text-white' : 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700' }} rounded-lg">
                <svg class="w-6 h-6 {{ request()->routeIs('suppliers.index') ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="ml-3">Leveranciers</span>
            </a>
        </li>
        <!-- Add more navigation items as needed -->
    </ul>
</nav>
