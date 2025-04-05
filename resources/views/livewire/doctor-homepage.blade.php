<div class="flex bg-gray-50 min-h-screen">
    @include('includes.doctor-nav')
    <div class="flex-1 container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4 p-6 bg-white rounded-xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Patients Directory
                </h1>
                <p class="text-gray-600 mt-2 ml-11">View, manage and monitor comprehensive patient health records</p>
            </div>
            <div>
                <a href="/manage" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Patient
                </a>
            </div>
        </div>

        <!-- Main Content -->
        @if(empty($patients) || count($patients) === 0)
        <div class="bg-white rounded-xl shadow-md p-10 text-center max-w-2xl mx-auto border border-gray-200">
            <div class="bg-blue-50 rounded-full p-5 w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-800 mb-3">No Patient Records Found</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Your patient directory is currently empty. Add your first patient to begin tracking medical records and appointments.</p>
            <a href="/manage" wire:navigate class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Patient
            </a>
        </div>
        @else
        <!-- Stats Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Patients</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ count($patients) }}</p>
                    </div>
                </div>
            </div>
            <!-- Additional stat cards can be added here -->
        </div>

        <!-- Patients Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($patients as $patient)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 overflow-hidden group cursor-pointer"
                wire:click="viewPatient({{ $patient->id }})">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="bg-blue-100 rounded-full p-3 group-hover:bg-blue-200 transition-colors duration-300">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">{{ $patient->name }}</h2>
                            <div class="flex items-center mt-1">
                                <span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-md font-medium">ID: {{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3 border-t border-gray-100 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm font-medium">Age</span>
                            <span class="text-gray-700 font-semibold">{{ $patient->age }} years</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm font-medium">Gender</span>
                            <span class="text-gray-700 font-semibold">{{ ucwords($patient->sex) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm font-medium">Last Visit</span>
                            <span class="text-gray-700 font-semibold">{{ isset($patient->last_visit) ? $patient->last_visit->format('M d, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="mt-5 text-right">
                        <span class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-300">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>