<div>
    <!-- Sidebar for desktop -->
    <aside class="fixed inset-y-0 left-0 bg-gray-800 w-64 shadow-lg hidden md:block">
        <div class="flex items-center justify-center h-16 border-b border-gray-700">
            <span class="text-white font-bold text-xl">Admin Panel</span>
        </div>
        <nav class="mt-5">
            <div class="px-2 space-y-1">
                <a wire:navigate href="{{ route('admin.home') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.home*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-sm font-medium">Home</span>
                </a>
                <a wire:navigate href="{{ route('admin.registration-keys') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.registration-keys*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <span class="text-sm font-medium">Registration Keys</span>
                </a>
                <a wire:navigate href="{{ route('admin.doctor-accounts') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.doctor-accounts*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-sm font-medium">Doctor Accounts</span>
                </a>
                <a wire:navigate href="{{ route('admin.patient-data') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.patient-data*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-sm font-medium">Patient Data</span>
                </a>
            </div>
        </nav>
        <div class="absolute bottom-0 w-full border-t border-gray-700 p-4">
            <a wire:click="logout" href="javascript:void(0)" class="group flex items-center text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-4 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-sm font-medium">Logout</span>
            </a>
        </div>
    </aside>

    <!-- Mobile menu toggle and sidebar -->
    <div class="md:hidden">
        <div x-data="{ open: false }">
            <!-- Hamburger button -->
            <button @click="open = !open" class="fixed top-4 left-4 z-20 bg-gray-800 text-white p-2 rounded-md shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Overlay -->
            <div x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-10 bg-black bg-opacity-50"
                @click="open = false"></div>

            <!-- Mobile sidebar -->
            <aside x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed inset-y-0 left-0 bg-gray-800 w-64 z-30 shadow-xl transform">

                <div class="flex items-center justify-between h-16 border-b border-gray-700 px-4">
                    <span class="text-white font-bold text-xl">Admin Panel</span>
                    <button @click="open = false" class="text-gray-300 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="mt-5">
                    <div class="px-2 space-y-1">
                        <a wire:navigate @click="open = false" href="{{ route('admin.home') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.home*') ? 'bg-gray-700 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="text-sm font-medium">Home</span>
                        </a>
                        <a wire:navigate @click="open = false" href="{{ route('admin.registration-keys') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.registration-keys*') ? 'bg-gray-700 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            <span class="text-sm font-medium">Registration Keys</span>
                        </a>
                        <a wire:navigate @click="open = false" href="{{ route('admin.doctor-accounts') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.doctor-accounts*') ? 'bg-gray-700 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium">Doctor Accounts</span>
                        </a>
                        <a wire:navigate @click="open = false" href="{{ route('admin.patient-data') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.patient-data*') ? 'bg-gray-700 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="text-sm font-medium">Patient Data</span>
                        </a>
                    </div>
                </nav>

                <div class="absolute bottom-0 w-full border-t border-gray-700 p-4">
                    <a wire:click="logout" @click="open = false" href="javascript:void(0)" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-sm font-medium">Logout</span>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>