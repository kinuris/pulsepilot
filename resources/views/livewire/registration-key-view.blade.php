<div class="relative flex bg-gray-900 min-h-screen text-gray-200">
    <!-- This is a sidebar -->
    <livewire:layout.admin-nav />

    <!-- This is a spacer -->
    <div class="w-64 hidden sm:block"></div>

    <!-- Notification Modal -->
    <div
        x-data="{ show: false, message: '', key: '' }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        x-init="$wire.on('copyKey', (keyValue) => { 
            navigator.clipboard.writeText(keyValue).then(() => {
                show = true; 
                key = keyValue;
                message = 'Registration key copied to clipboard:'; 
                setTimeout(() => show = false, 3000);
            }).catch(err => {
                console.error('Failed to copy key: ', err);
                show = true;
                key = keyValue;
                message = 'Unable to copy automatically. Please select and copy manually:';
                setTimeout(() => show = false, 5000);
            });
        })"
        class="fixed top-6 inset-x-0 z-50 flex justify-center"
        style="display: none;">
        <div class="bg-gray-800 border border-gray-700 text-gray-200 px-6 py-4 rounded-md shadow-xl max-w-lg flex flex-col">
            <div class="flex items-center space-x-3 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                </svg>
                <span x-text="message" class="font-medium"></span>
            </div>
            <div class="mt-1 bg-gray-700 px-3 py-2 rounded font-mono text-sm text-indigo-300 break-all select-all" x-text="key"></div>
        </div>
    </div>

    <div class="flex-1 mt-16 sm:mt-0 px-3 sm:px-6 py-4 sm:py-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-4 sm:mb-8">Manage Registration Keys</h1>

            <div class="bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8">
                <div class="flex flex-col mb-4">
                    <h2 class="text-xl font-semibold text-gray-200 mb-4">Registration Keys</h2>
                    <div class="flex flex-col space-y-2 w-full">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live="search" type="text" placeholder="Search keys..."
                                class="border border-gray-700 bg-gray-700 rounded-md pl-10 pr-4 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500 text-gray-200 placeholder-gray-400">
                        </div>
                        <select wire:model.live="status" class="border border-gray-700 bg-gray-700 rounded-md px-4 py-2 text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all">All Status</option>
                            <option value="unused">Unused</option>
                            <option value="used">Used</option>
                        </select>
                    </div>
                </div>

                <div class="my-3">
                    {{ $keys->links() }}
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden sm:block overflow-x-auto border border-gray-700 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Key</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Used By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @forelse($keys as $key)
                            <tr class="hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap font-mono text-sm group relative cursor-default">
                                    <span class="opacity-100 group-hover:opacity-0 transition-opacity duration-200">
                                        {{ substr($key->key_string, 0, 4) . 
                                           preg_replace('/[a-zA-Z0-9]/', '•', substr($key->key_string, 4, -4)) . 
                                           substr($key->key_string, -4) }}
                                    </span>
                                    <span class="absolute left-6 top-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-indigo-400">
                                        {{ $key->key_string }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $key->usage ? 'bg-red-900 text-red-200' : 'bg-green-900 text-green-200' }}">
                                        {{ $key->usage ? 'Used' : 'Unused' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $key->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $key->usage->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button wire:click="copyKey('{{ $key->key_string }}')" class="inline-flex items-center text-indigo-400 hover:text-indigo-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Copy
                                    </button>
                                    @if(!$key->usage)
                                    <button wire:click="deleteKey({{ $key->id }})" class="ml-3 inline-flex items-center text-red-400 hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">No registration keys found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card Layout (shown only on mobile) -->
                <div class="sm:hidden space-y-4">
                    @forelse($keys as $key)
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-mono text-sm mb-2 relative group">
                                <span>
                                    {{ substr($key->key_string, 0, 4) . 
                                       preg_replace('/[a-zA-Z0-9]/', '•', substr($key->key_string, 4, -4)) . 
                                       substr($key->key_string, -4) }}
                                </span>
                            </div>
                            <span class="px-3 py-1 text-xs leading-5 font-semibold rounded-full {{ $key->usage ? 'bg-red-900 text-red-200' : 'bg-green-900 text-green-200' }}">
                                {{ $key->usage ? 'Used' : 'Unused' }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">
                            <div class="flex justify-between">
                                <span>Created:</span>
                                <span>{{ $key->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span>Used By:</span>
                                <span>{{ $key->user->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="mt-3 flex space-x-3 justify-end">
                            <button wire:click="copyKey('{{ $key->key_string }}')" class="inline-flex items-center text-indigo-400 hover:text-indigo-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Copy
                            </button>
                            @if(!$key->usage)
                            <button wire:click="deleteKey({{ $key->id }})" class="inline-flex items-center text-red-400 hover:text-red-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-400">No registration keys found</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-md p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-200 mb-4 sm:mb-6">Generate Registration Keys</h2>

                <div class="mb-4 sm:mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Number of Keys</label>
                    <input wire:model="numberOfKeys" type="number" min="1" max="100"
                        class="border border-gray-700 bg-gray-700 rounded-md w-full px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-200">
                    @error('numberOfKeys') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-center sm:justify-end">
                    <button wire:click="generateKeys" class="w-full sm:w-auto inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 sm:py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <span wire:loading.remove wire:target="generateKeys">Generate Keys</span>
                        <span wire:loading wire:target="generateKeys" class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </div>

            @if(session()->has('message'))
            <div class="mt-4 sm:mt-6 bg-green-900 border-l-4 border-green-600 p-3 sm:p-4 rounded shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-200">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session()->has('error'))
            <div class="mt-4 sm:mt-6 bg-red-900 border-l-4 border-red-600 p-3 sm:p-4 rounded shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-200">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>