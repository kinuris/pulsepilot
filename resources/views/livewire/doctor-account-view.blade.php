<div class="flex dark:bg-gray-900 dark:text-gray-100">
    <!-- This is a sidebar -->
    <livewire:layout.admin-nav />

    <!-- This is a spacer -->
    <div class="w-64 hidden md:block"></div>

    <div class="flex-1 mt-16 sm:mt-0 px-3 sm:px-6 py-4 sm:py-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-4 sm:mb-8 dark:text-gray-50">Manage Doctor Accounts</h1>

            <div class="bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8 dark:bg-gray-700">
                <div class="flex flex-col mb-4">
                    <h2 class="text-xl font-semibold text-gray-200 mb-4 dark:text-gray-200">Doctor Accounts</h2>
                    <div class="flex space-x-2 w-full">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live="search" type="text" placeholder="Search accounts..."
                                class="border border-gray-700 bg-gray-700 rounded-md pl-10 pr-4 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500 text-gray-200 placeholder-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-400">
                        </div>
                        <div class="w-1/5">
                            <select wire:model.live="filter" class="border border-gray-700 bg-gray-700 rounded-md pl-4 pr-4 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500 text-gray-200 placeholder-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-400">
                                <option value="all">All Doctors</option>
                                <option value="suspended">Suspended</option>
                                <option value="active">Active</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="my-3">
                    {{-- $doctors->links() --}}
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden sm:block overflow-x-auto border border-gray-700 rounded-lg dark:border-gray-600">
                    <table class="min-w-full divide-y divide-gray-700 dark:divide-gray-600">
                        <thead class="bg-gray-900 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Status</th>
                                <th class="px-6 py-3 text-end text-xs font-medium text-gray-400 uppercase tracking-wider dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700 dark:bg-gray-700 dark:divide-gray-600">
                            @forelse($doctors as $doctor)
                            <tr class="hover:bg-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 dark:text-gray-300 flex items-center">
                                    @if($doctor->profile_image)
                                    <img src="{{ asset('storage/' . $doctor->profile_image) }}" alt="Doctor Profile Image" class="h-8 w-8 rounded-full object-cover mr-2">
                                    @else
                                    <div class="h-10 w-10 rounded-full bg-gray-500 dark:bg-gray-600 mr-2"></div>
                                    @endif
                                    {{ $doctor->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 dark:text-gray-300">{{ $doctor->email }}</td>
                                <td wire:poll.30s class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $doctor->isOnline() ? 'bg-green-900 text-green-200 dark:bg-green-800 dark:text-green-200' : 'bg-red-900 text-red-200 dark:bg-red-800 dark:text-red-200' }}">
                                        {{ $doctor->isOnline() ? 'Online' : 'Offline' }}
                                    </span>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $doctor->suspended ? 'bg-orange-900 text-orange-200 dark:bg-orange-800 dark:text-orange-200' : 'bg-green-900 text-green-200 dark:bg-green-800 dark:text-green-200' }}">
                                        {{ $doctor->suspended ? 'Suspended' : 'Active' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex justify-end text-sm">
                                    @if (!$doctor->suspended)
                                    <div x-data="{ showSuspendModal: false, doctorToSuspend: null }">
                                        <button @click="showSuspendModal = true; doctorToSuspend = {{ $doctor->id }}" class="inline-flex items-center text-orange-400 hover:text-orange-300 dark:text-orange-400 dark:hover:text-orange-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Suspend
                                        </button>

                                        <!-- Suspend Confirmation Modal -->
                                        <div x-show="showSuspendModal"
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
                                                <div x-show="showSuspendModal"
                                                    @click="showSuspendModal = false"
                                                    class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"></div>

                                                <div x-show="showSuspendModal"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-gray-800 rounded-lg shadow-xl sm:my-12">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-orange-900 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="w-6 h-6 text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>

                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg font-medium leading-6 text-gray-200">Suspend Doctor Account</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-400">Are you sure you want to suspend this doctor account?<br>They will not be able to access the system until unsuspended.</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col-reverse mt-5 space-y-3 space-y-reverse sm:flex-row sm:space-y-0 sm:space-x-3">
                                                        <button @click="showSuspendModal = false"
                                                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-gray-200 transition-colors duration-150 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm">
                                                            Cancel
                                                        </button>
                                                        <button @click="showSuspendModal = false"
                                                            wire:click="suspendDoctor(doctorToSuspend)"
                                                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-white transition-colors duration-150 bg-orange-700 border border-transparent rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:text-sm">
                                                            Suspend Account
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div x-data="{ showActivateModal: false, doctorToActivate: null }">
                                        <button @click="showActivateModal = true; doctorToActivate = {{ $doctor->id }}" class="inline-flex items-center text-green-400 hover:text-green-300 dark:text-green-400 dark:hover:text-green-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Activate
                                        </button>

                                        <div x-show="showActivateModal"
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
                                                <div x-show="showActivateModal"
                                                    @click="showActivateModal = false"
                                                    class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"></div>

                                                <div x-show="showActivateModal"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-gray-800 rounded-lg shadow-xl sm:my-12">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-900 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="w-6 h-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>

                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg font-medium leading-6 text-gray-200">Activate Doctor Account</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-400">Are you sure you want to activate this doctor account?<br>They will regain access to the system.</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col-reverse mt-5 space-y-3 space-y-reverse sm:flex-row sm:space-y-0 sm:space-x-3">
                                                        <button @click="showActivateModal = false"
                                                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-gray-200 transition-colors duration-150 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm">
                                                            Cancel
                                                        </button>
                                                        <button @click="showActivateModal = false"
                                                            wire:click="activateDoctor(doctorToActivate)"
                                                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                                                            Activate Account
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div x-data="{ showDeleteModal: false, doctorToDelete: null }">
                                        <button @click="showDeleteModal = true; doctorToDelete = {{ $doctor->id }}" class="ml-3 inline-flex items-center text-red-400 hover:text-red-300 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                                            <h3 class="text-lg font-medium leading-6 text-gray-200">Delete Doctor Account</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-400">Are you sure you want to delete this doctor account?<br> This action cannot be undone.</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Action buttons -->
                                                    <div class="flex flex-col-reverse mt-5 space-y-3 space-y-reverse sm:flex-row sm:space-y-0 sm:space-x-3">
                                                        <button @click="showDeleteModal = false"
                                                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-gray-200 transition-colors duration-150 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm">
                                                            Cancel
                                                        </button>
                                                        <button @click="showDeleteModal = false"
                                                            wire:click="deleteDoctor(doctorToDelete)"
                                                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-white transition-colors duration-150 bg-red-700 border border-transparent rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                                                            Delete Account
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500">No doctor accounts found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>