<div class="flex dark:bg-gray-900 dark:text-gray-100">
    <!-- This is a sidebar -->
    <livewire:layout.admin-nav />

    <!-- This is a spacer -->
    <div class="w-64 hidden md:block"></div>

    <div class="flex-1 mt-16 sm:mt-0 px-3 sm:px-6 py-4 sm:py-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-4 sm:mb-8 dark:text-gray-50">Admin Dashboard</h1>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Current Online Patients Card -->
                <div class="bg-gray-800 rounded-lg shadow-md p-5 dark:bg-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-gray-200 dark:text-gray-200">Current Online Patients</h2>
                        <div class="p-2 bg-blue-900/30 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div wire:poll.30s>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-white">{{ $onlinePatients->count() }}</span>
                            <span class="ml-2 text-sm text-gray-400">{{ $onlinePatients->count() == 1 ? 'patient' : 'patients' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Current Online Doctors Card -->
                <div class="bg-gray-800 rounded-lg shadow-md p-5 dark:bg-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-gray-200 dark:text-gray-200">Current Online Doctors</h2>
                        <div class="p-2 bg-green-900/30 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                    <div wire:poll.30s>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-white">{{ $onlineDoctors->count() }}</span>
                            <span class="ml-2 text-sm text-gray-400">{{ $onlineDoctors->count() == 1 ? 'doctor' : 'doctors' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Key Usage (24h) Card -->
                <div class="bg-gray-800 rounded-lg shadow-md p-5 dark:bg-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-gray-200 dark:text-gray-200">Key Usage (24h)</h2>
                        <div class="p-2 bg-purple-900/30 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                    </div>
                    <div wire:poll.60s>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-white">{{ $keyUsage24h->count() }}</span>
                            <span class="ml-2 text-sm text-gray-400">{{ $keyUsage24h->count() == 1 ? 'usage' : 'uses' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Key Usages Section -->
            <div class="bg-gray-800 rounded-lg shadow-md p-5 mb-8 dark:bg-gray-700">
                <h2 class="text-xl font-semibold text-gray-200 mb-4 dark:text-gray-200">Recent Key Usages</h2>
                <div class="overflow-x-auto border border-gray-700 rounded-lg dark:border-gray-600">
                    <table class="min-w-full divide-y divide-gray-700 dark:divide-gray-600">
                        <thead class="bg-gray-900 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Key ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700 dark:bg-gray-700 dark:divide-gray-600">
                            @forelse($keyUsage24h ?? [] as $keyUsage)
                            <tr class="transition-colors duration-150 hover:bg-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 dark:text-gray-200">{{ $keyUsage->registration_key_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 dark:text-gray-200">{{ $keyUsage->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 dark:text-gray-300">{{ $keyUsage->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-400 dark:text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p>No recent key usages</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
