<nav wire:ignore.self class="flex flex-col bg-white shadow-xl min-w-[280px] max-w-[280px] h-screen border-r border-gray-100">
    <a wire:navigate href="{{ route('home') }}" class="px-6 py-4 border-b border-gray-100">
        <div class="appbar">
            <img src="{{ asset('assets/launcher_logo_wlabel.png') }}" alt="Logo" class="h-10 w-auto" />
        </div>
    </a>

    <div class="flex flex-col space-y-1 py-4">
        <a wire:navigate href="{{ route('home') }}">
            <div class="{{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} nav-item flex items-center space-x-3 px-6 py-3 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <p class="font-medium text-base">Dashboard</p>
            </div>
        </a>

        <a wire:navigate href="{{ route('patients') }}">
            <div class="{{ request()->routeIs('patients*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} nav-item flex items-center space-x-3 px-6 py-3 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="font-medium text-base">Patients</p>
            </div>
        </a>

        <a wire:navigate href="{{ route('manage') }}">
            <div class="{{ request()->routeIs('manage') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} nav-item flex items-center space-x-3 px-6 py-3 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <p class="font-medium text-base">Manage Patients</p>
            </div>
        </a>

        <a wire:navigate href="{{ route('chats') }}">
            <div class="{{ request()->routeIs('chats') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} nav-item flex items-center space-x-3 px-6 py-3 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p class="font-medium text-base">Chat</p>
            </div>
        </a>

        <a wire:navigate href="{{ route('calendar') }}">
            <div class="{{ request()->routeIs('calendar') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }} nav-item flex items-center space-x-3 px-6 py-3 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="font-medium text-base">Calendar</p>
            </div>
        </a>

        <button wire:click="logout" type="button" class="w-full">
            <div class="text-gray-700 hover:bg-gray-50 nav-item flex items-center space-x-3 px-6 py-3 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <p class="font-medium text-base">Logout</p>
            </div>
        </button>

        <div class="px-6 mt-4">
            @if (session()->has('message:red'))
            <div class="flex items-center p-4 mb-4 rounded-lg bg-red-50 border border-red-200" role="alert">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-red-700">{{ session('message:red') }}</span>
            </div>
            @endif

            @if (session()->has('message:green'))
            <div class="flex items-center p-4 mb-4 rounded-lg bg-green-50 border border-green-200" role="alert">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium text-green-700">{{ session('message:green') }}</span>
            </div>
            @endif
        </div>
    </div>
</nav>