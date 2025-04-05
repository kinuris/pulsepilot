<div class="flex bg-gray-50">
    @include('includes.doctor-nav')
    <div class="flex flex-col p-6 items-stretch w-full max-h-screen overflow-auto">
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-gray-800">Messages</h1>
                <div class="flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-full">
                    <span class="text-sm font-medium text-blue-700">12 unread</span>
                    <div class="h-2 w-2 bg-blue-600 rounded-full"></div>
                </div>
            </div>

            <div class="flex gap-3 py-3 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                @foreach (Auth::user()->patients() as $patient)
                <div @if($selectedPatientId !==$patient->id) wire:click="setSelectedPatient({{ $patient->id }})" @else wire:click="setSelectedPatient(null)" @endif
                    class="flex-shrink-0 w-64 {{ $selectedPatientId == $patient->id ? 'bg-blue-50 border-2 border-blue-500' : 'bg-white hover:bg-gray-50' }} rounded-lg shadow-sm p-4 cursor-pointer transition-all duration-200 ease-in-out hover:shadow-md">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                            {{ substr($patient->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">{{ $patient->name }}</h3>
                            <div class="flex items-center text-xs">
                                <div class="h-1.5 w-1.5 bg-emerald-500 rounded-full mr-1"></div>
                                <span class="text-emerald-600">Online</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="messageContainer" class="flex-1 overflow-y-auto p-5 mt-1 space-y-4 bg-white rounded-xl shadow border border-gray-100 relative" wire:poll.1s="refreshMessage">
                @if ($selectedPatient)
                <div class="sticky z-50 top-0 w-fit py-2 px-4 bg-white/90 backdrop-blur-sm border-b border-gray-100 rounded-t-xl flex items-center justify-between shadow-sm mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                            {{ substr($selectedPatient->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col ml-3">
                            <span class="text-sm font-medium text-gray-800">{{ $selectedPatient->name }}</span>
                            <span class="text-xs text-emerald-600 flex items-center">
                                <div class="h-1.5 w-1.5 bg-emerald-500 rounded-full mr-1"></div>Active Now
                            </span>
                        </div>
                    </div>
                </div>

                @foreach($messageThread ?? [] as $message)
                <div wire:key="message-{{ $message->id }}"
                    x-data="{ show: false }"
                    x-init="setTimeout(() => show = true, 0)"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="flex {{ $message->sender_type === 'patient' ? 'justify-start' : 'justify-end' }}">
                    <div class="{{ $message->sender_type === 'patient' ? 'bg-gray-100' : 'bg-blue-600' }} rounded-lg p-2.5 max-w-sm shadow-sm">
                        @if($message->message_type === 'text')
                            <p class="{{ $message->sender_type === 'patient' ? 'text-gray-800' : 'text-white' }} text-sm">{{ $message->message }}</p>
                        @elseif($message->message_type === 'image')
                            <div class="mb-2">
                                <a href="{{ asset('storage/attachments/' . $message->path) }}" target="_blank" class="block">
                                    <img src="{{ asset('storage/attachments/' . $message->path) }}" alt="Image" class="rounded-md max-h-48 w-auto object-cover cursor-pointer hover:opacity-90 transition-opacity">
                                </a>
                            </div>
                            @if($message->message)
                                <p class="{{ $message->sender_type === 'patient' ? 'text-gray-800' : 'text-white' }} text-sm">{{ $message->message }}</p>
                            @endif
                        @elseif($message->message_type === 'pdf')
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $message->sender_type === 'patient' ? 'text-red-500' : 'text-white' }} mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <a href="{{ asset('storage/attachments/' . $message->path) }}" target="_blank" class="{{ $message->sender_type === 'patient' ? 'text-blue-600 hover:underline' : 'text-white hover:text-blue-100' }} text-sm font-medium">
                                    View PDF
                                </a>
                            </div>
                            @if($message->message)
                                <p class="{{ $message->sender_type === 'patient' ? 'text-gray-800' : 'text-white' }} text-sm">{{ $message->message }}</p>
                            @endif
                        @endif
                        <span class="{{ $message->sender_type === 'patient' ? 'text-xs text-gray-500' : 'text-xs text-blue-100' }} block mt-1">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach

                @else
                <div wire:transition class="flex flex-col items-center justify-center h-full" wire:key="no-patient">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-gray-500 font-medium">Select a patient to view conversation</p>
                    <p class="text-gray-400 text-sm">Your message history will appear here</p>
                </div>
                @endif
            </div>

            <div class="mt-4 pb-0">
                <form wire:submit.prevent="sendMessage" class="flex gap-2 items-center">
                    <div class="flex-1 relative">
                        <input type="text"
                            wire:model="message"
                            class="w-full rounded-full border border-gray-300 px-5 py-2.5 pr-12 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all duration-200 ease-in-out {{ !$selectedPatientId ? 'bg-gray-50 cursor-not-allowed' : '' }}"
                            placeholder="{{ $selectedPatientId ? 'Type your message...' : 'Select a patient to start chatting' }}"
                            {{ !$selectedPatientId ? 'disabled' : '' }}>
                        <div class="relative">
                            <!-- File upload button -->
                            <label for="fileUpload" class="absolute -top-8 right-3 cursor-pointer text-gray-500 hover:text-blue-600 transition-colors {{ !$selectedPatientId ? 'pointer-events-none opacity-50' : '' }} {{ $attachment ? 'hidden' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <input id="fileUpload" type="file" wire:model="attachment" accept="image/*,.pdf" class="hidden" {{ !$selectedPatientId ? 'disabled' : '' }}>
                            </label>

                            <!-- Attachment preview -->
                            @if($attachment)
                            <div class="absolute right-3 -top-8 flex items-center gap-2">
                                <div class="flex items-center bg-blue-50 rounded-full px-2 py-0.5 text-xs text-blue-700">
                                    @if($attachment instanceof \Illuminate\Http\UploadedFile && str_contains($attachment->getMimeType(), 'image'))
                                    <div class="relative group">
                                        <img src="{{ $attachment->temporaryUrl() }}" class="h-5 w-5 rounded object-cover mr-1 cursor-pointer"
                                            title="Hover to preview">
                                        <!-- Hover preview (shows on hover) -->
                                        <div class="absolute left-0 bottom-8 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 pointer-events-none">
                                            <div class="bg-white p-2 rounded-lg shadow-lg border border-gray-200">
                                                <img src="{{ $attachment->temporaryUrl() }}" class="max-w-[250px] max-h-[250px] rounded">
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    @endif
                                    <span class="truncate max-w-[80px]">{{ $attachment->getClientOriginalName() }}</span>
                                </div>
                                <button type="button" wire:click="$set('attachment', null)" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-full transition-all duration-200 ease-in-out flex items-center gap-1 {{ !$selectedPatientId ? 'bg-gray-300 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }} text-white"
                        {{ !$selectedPatientId ? 'disabled' : '' }}>
                        <span>Send</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@script
<script>
    const messageContainerId = 'messageContainer';
    let chat = null;
    let previousScrollHeight = 0;
    let isInitialized = false;

    function scrollToBottom(behavior = 'smooth') {
        if (!chat) return;

        requestAnimationFrame(() => {
            chat.scrollTop = chat.scrollHeight;
        });
    }

    function handleScroll() {
        if (!chat) return;

        // Check if user is at the top (0px with a small tolerance)
        if (chat.scrollTop === 0) {
            previousScrollHeight = chat.scrollHeight;

            // Dispatch the loadMore event to Livewire
            $wire.dispatch('loadMore');
        }
    }

    function cleanupListeners() {
        if (chat) {
            chat.removeEventListener('scroll', handleScroll);
        }
    }

    // Initialize scroll behavior and event listeners
    function initializeChat() {
        // Clean up previous listeners if already initialized
        if (isInitialized) {
            cleanupListeners();
        }

        // Get fresh reference to the chat container
        chat = document.getElementById(messageContainerId);
        if (!chat) return;

        // Reset variables
        previousScrollHeight = 0;

        // Initial scroll to bottom
        scrollToBottom();

        // Add scroll event listener with a short delay to prevent initial false triggers
        setTimeout(() => {
            chat.addEventListener('scroll', handleScroll);
        }, 1000);

        isInitialized = true;
    }

    // Run init when DOM is ready
    if (document.readyState !== 'loading') {
        initializeChat();
    } else {
        document.addEventListener('DOMContentLoaded', initializeChat);
    }

    // Wire event listeners for Livewire events
    $wire.on('newMessage', () => scrollToBottom());
    $wire.on('toBottom', () => scrollToBottom());
    $wire.on('reinitializeChat', () => initializeChat());

    $wire.on('messagesLoaded', () => {
        if (!chat) return;

        // Maintain scroll position when new messages are loaded at the top
        const newScrollHeight = chat.scrollHeight;
        const heightDifference = newScrollHeight - previousScrollHeight;

        if (heightDifference > 0) {
            chat.scrollTop = heightDifference;
        }
    });
</script>
@endscript