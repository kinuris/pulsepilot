<div>
    <div wire:poll.30s="cacheOnline"></div>
    @php
    $chatAlerts = collect(Cache::get('msgalert-keys-' . Auth::user()->id))->map(function($key) {
    return Cache::get($key);
    })->filter();
    @endphp

    @php
    $labAlerts = collect(Cache::get('labalert-keys-' . Auth::user()->id, []))->map(function($key) {
    return Cache::get($key);
    })->filter();
    @endphp

    <!-- Main polling div to update all content -->
    <div wire:poll.2s></div>
    
    <!-- Lab Notifications Panel -->
    @if($labAlerts->isNotEmpty())
    <div class="space-y-3 mb-4">
        <h4 class="text-sm font-semibold text-gray-700 px-1">Lab Notifications</h4>
        @foreach($labAlerts as $labAlert)
        <div wire:click="handleLabAlert('{{ $labAlert['key'] }}')" 
             class="block w-full text-left bg-white shadow hover:shadow-lg border-l-4 border-green-500 p-3 rounded-md text-xs cursor-pointer hover:bg-green-50 transition-all duration-200 ease-in-out">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="font-medium text-gray-800 mb-1">{{ $labAlert['lab_submission']->labRequest->type ?? 'Lab Request' }}</div>
                    <div class="text-gray-600 text-2xs">
                        <span class="inline-flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $labAlert['lab_submission']->labRequest->patient->name ?? 'N/A' }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $labAlert['lab_submission']->labRequest->priority_level == 'Urgent' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $labAlert['lab_submission']->labRequest->priority_level ?? 'Normal' }}
                    </span>
                    <div class="text-gray-500 text-2xs mt-1">
                        {{ \Carbon\Carbon::parse($labAlert['created_at'])->diffForHumans() }}
                    </div>
                </div>
            </div>
            <p class="text-gray-700 mt-2 font-medium">{{ $labAlert['type'] }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Chat Notifications Panel -->
    @if($chatAlerts->isNotEmpty())
    <div class="space-y-2">
        @forelse($chatAlerts as $chatAlert)
        <button wire:click="handleChatAlert('{{ $chatAlert['key'] }}')" class="block w-full text-left bg-white shadow-sm border-l-4 border-blue-500 p-2 rounded text-xs cursor-pointer hover:bg-blue-50 hover:shadow-md transition duration-200">
            <div class="flex justify-between">
                <span class="font-medium">{{ $chatAlert['from']->name ?? 'Patient' }}</span>
                <span class="text-gray-500">{{ \Carbon\Carbon::parse($chatAlert['created_at'])->diffForHumans() }}</span>
            </div>
            <p class="text-gray-700">{{ $chatAlert['message'] }}</p>
        </button>
        @empty
        <div class="bg-white shadow-sm p-2 rounded text-center text-gray-500 text-xs">
            <p>No notifications</p>
        </div>
        @endforelse
    </div>
    @endif
</div>