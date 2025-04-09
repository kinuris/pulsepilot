<div class="flex bg-gray-100 min-h-screen">
    @include('includes.doctor-nav')
    <div class="flex-1 p-6 md:p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Account Settings</h1>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-700">Personal Information</h2>
                </div>
                
                <div class="p-6">
                    <form wire:submit.prevent="updateProfile" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" wire:model="name" id="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2" />
                                @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" wire:model="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2" />
                                @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    @if ($profileImage)
                                        <img class="h-16 w-16 rounded-full object-cover" src="{{ $profileImage->temporaryUrl() }}" alt="Profile preview">
                                    @elseif (Auth::user()->profile_image)
                                        <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image">
                                    @else
                                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <input type="file" wire:model="profileImage" id="profile_image" class="hidden" accept="image/*" />
                                    <label for="profile_image" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                        Choose New Photo
                                    </label>
                                    @error('profile_image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-4">Change Password</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" wire:model="password" id="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2" />
                                    @error('password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                    <input type="password" wire:model="password_confirmation" id="password_confirmation" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2" />
                                    @error('password_confirmation') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200" wire:loading.attr="disabled">
                                <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
