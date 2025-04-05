<div class="min-h-screen bg-gradient-to-br from-[#819ae4] to-[#3b5986] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full bg-white rounded-xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('/assets/launcher_logo_wlabel.png') }}" alt="Logo" class="h-16 mx-auto mb-4" />
            <h1 class="text-2xl font-semibold text-[#294249]">Create Account</h1>
            <p class="text-gray-500 text-sm mt-2">Please fill in your details to sign up</p>
        </div>

        @if (session()->has('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-600 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" wire:submit="register" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input
                        wire:model="name"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Enter your full name"
                        class="appearance-none block w-full px-4 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7aa0ab] focus:border-transparent" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input
                        wire:model="email"
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Enter your email"
                        class="appearance-none block w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7aa0ab] focus:border-transparent" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        wire:model="password"
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Create a password"
                        class="appearance-none block w-full px-4 py-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7aa0ab] focus:border-transparent" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input
                        wire:model="passwordConfirmation"
                        type="password"
                        name="passwordConfirmation"
                        id="passwordConfirmation"
                        placeholder="Confirm your password"
                        class="appearance-none block w-full px-4 py-3 border @error('passwordConfirmation') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7aa0ab] focus:border-transparent" />
                    @error('passwordConfirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label for="registrationKey" class="block text-sm font-medium text-gray-700 mb-1">Registration Key</label>
                    <input
                        wire:model="registrationKey"
                        type="text"
                        name="registrationKey"
                        id="registrationKey"
                        placeholder="Enter your registration key"
                        class="appearance-none block w-full px-4 py-3 border @error('registrationKey') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7aa0ab] focus:border-transparent" />
                    @error('registrationKey')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="/login" wire:navigate class="text-sm text-[#294249] hover:text-[#7aa0ab] transition-colors">
                    Already have an account?
                </a>
            </div>

            <button
                type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-white bg-[#294249] hover:bg-[#7aa0ab] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7aa0ab] transition-all duration-200 text-sm font-medium">
                Create Account
            </button>
        </form>
    </div>
</div>
