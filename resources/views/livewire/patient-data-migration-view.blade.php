<div class="flex dark:bg-gray-900 dark:text-gray-100">
    <!-- This is a sidebar -->
    <livewire:layout.admin-nav />

    <!-- This is a spacer -->
    <div class="w-64 hidden md:block"></div>

    <div class="flex-1 mt-16 sm:mt-0 px-3 sm:px-6 py-4 sm:py-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-4 sm:mb-8 dark:text-gray-50">Manage Patient Data</h1>

            <div class="bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8 dark:bg-gray-700">
                <div class="flex flex-col mb-4">
                    <h2 class="text-xl font-semibold text-gray-200 mb-4 dark:text-gray-200">Patient Records</h2>
                    <div class="flex space-x-2 w-full">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live="search" type="text" placeholder="Search patients..."
                                class="border border-gray-700 bg-gray-700 rounded-md pl-10 pr-4 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500 text-gray-200 placeholder-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-400">
                        </div>
                    </div>
                </div>

                <div class="my-3">
                    {{-- $patients->links() --}}
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden sm:block overflow-x-auto border border-gray-700 rounded-lg dark:border-gray-600">
                    <table class="min-w-full divide-y divide-gray-700 dark:divide-gray-600">
                        <thead class="bg-gray-900 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                                        </svg>
                                        Recovery ID
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        Contact Number
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Province
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Last Online</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700 dark:bg-gray-700 dark:divide-gray-600">
                            @forelse($patients as $patient)
                            <tr class="transition-colors duration-150 hover:bg-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-sm text-gray-300 dark:text-gray-200">{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <span id="recovery-id-{{ $patient->id }}">{{ $patient->recovery_id }}</span>
                                        <button
                                            onclick="copyToClipboard('recovery-id-{{ $patient->id }}')"
                                            class="ml-2 text-gray-400 hover:text-gray-200 transition"
                                            title="Copy to clipboard">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 dark:text-gray-300">{{ $patient->contact_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 dark:text-gray-300">{{ $patient->province }}</td>
                                <td wire:poll.30s class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 dark:text-gray-300">
                                    @if($patient->isOnline())
                                    <span class="inline-flex items-center rounded-full bg-green-600 px-2.5 py-0.5 text-xs font-medium text-white">
                                        <span class="flex h-2 w-2 mr-1.5">
                                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                        Online now
                                    </span>
                                    @elseif($patient->lastOnline() != null)
                                    <span class="inline-flex items-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($patient->lastOnline())->diffForHumans() }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m-3.536-3.536a5 5 0 010-7.07m-3.182 3.182a1 1 0 110 1.415" />
                                        </svg>
                                        Never connected
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                    <div x-data="{ showDeleteModal: false, patientToDelete: null }">
                                        <button @click="showDeleteModal = true; patientToDelete = {{ $patient->id }}" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-red-400 hover:text-red-300 hover:bg-red-900/20 transition-colors dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div x-show="showDeleteModal"
                                            x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 z-50 overflow-y-auto"
                                            aria-labelledby="modal-title"
                                            role="dialog"
                                            aria-modal="true">
                                            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                <!-- Background overlay -->
                                                <div x-show="showDeleteModal"
                                                    @click="showDeleteModal = false"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"></div>

                                                <!-- Modal panel -->
                                                <div x-show="showDeleteModal"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-init="$wire.on('patientDeleted', () => { showDeleteModal = false; })"
                                                    class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-gray-800 rounded-lg shadow-xl sm:my-12">
                                                    <div class="sm:flex sm:items-start">
                                                        <!-- Warning icon -->
                                                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-900 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="w-6 h-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>

                                                        <!-- Modal content -->
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg font-medium leading-6 text-gray-200">Delete Patient Record</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-400">Are you sure you want to delete this patient record?<br> This action cannot be undone.</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Action buttons -->
                                                    <div class="flex flex-col-reverse mt-5 space-y-3 space-y-reverse sm:flex-row sm:space-y-0 sm:space-x-3">
                                                        <button @click="showDeleteModal = false"
                                                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-gray-200 transition-colors duration-150 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm">
                                                            Cancel
                                                        </button>
                                                        <button
                                                            wire:click="deletePatient(patientToDelete)"
                                                            class="inline-flex justify-center px-4 py-2 text-white bg-red-700 rounded-md hover:bg-red-600 focus:outline-none"
                                                            wire:loading.attr="disabled">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            <span wire:loading.remove>Delete</span>
                                                            <span wire:loading>Processing...</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-400 dark:text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p>No patient records found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <script>
                    function copyToClipboard(elementId) {
                        const text = document.getElementById(elementId).innerText;
                        navigator.clipboard.writeText(text).then(() => {
                            // Show a brief flash of success
                            const button = document.querySelector(`#${elementId}`).nextElementSibling;
                            const originalColor = button.classList.contains('text-gray-400') ? 'text-gray-400' : 'text-gray-200';

                            button.classList.remove(originalColor);
                            button.classList.add('text-green-400');

                            setTimeout(() => {
                                button.classList.remove('text-green-400');
                                button.classList.add(originalColor);
                            }, 1000);
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</div>