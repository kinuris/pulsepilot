<div class="flex flex-col">
    <!-- Diet Records Table -->
    <div class="mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Food Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meal Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center">
                            AI Notes
                            <div class="inline-flex items-center ml-1">
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 4.75 7.5 4.75a12.742 12.742 0 00-2.269 9.92l-1.44-1.44m14.216 9.858l-1.287-1.287M3.02 8.967l.725-.725M5.191 3.686l.845.845M9.82 16.782a11.434 11.434 0 01-1.676-5.05m11.942 1.62l-1.44-1.443M6.354 19.856l-1.287-1.286"></path>
                                </svg>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                    $groupedRecords = $this->nutritionRecordsPaginated->groupBy(function($record) {
                    return date('Y-m-d', strtotime($record->recorded_at));
                    });
                    @endphp

                    @foreach($groupedRecords as $date => $records)
                    <tr class="bg-gradient-to-r from-blue-50 to-white">
                        <td colspan="4" class="px-6 py-4 text-sm font-semibold text-gray-800 border-b-2 border-blue-200 shadow-sm">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}</span>
                            </div>
                        </td>
                    </tr>
                    @foreach($records as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ date_create($record->recorded_at)->format('M d, Y g:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $record->foods_csv) as $food)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs">{{ trim($food) }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $record->day_description }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-48 min-w-48 overflow-hidden" x-data="{ aiNotes: '', loading: false, showModal: false }" x-init="
                                loading = true;
                                $wire.genAINotes(@js($record)).then(result => {
                                    aiNotes = result;
                                    loading = false;
                                });
                            ">
                            <template x-if="loading">
                                <div class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 mr-3 text-blue-500" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading...
                                </div>
                            </template>
                            <template x-if="!loading">
                                <div class="relative">
                                    <!-- Truncated view with read more button -->
                                    <div class="mb-1 text-gray-700">
                                        <p class="line-clamp-1 text-sm" x-text="aiNotes"></p>
                                        <button 
                                            @click="showModal = true" 
                                            class="text-xs text-blue-600 hover:text-blue-800 font-medium flex items-center mt-1 transition-colors duration-200">
                                            <span>Read more</span>
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Modal for full notes -->
                                    <div x-show="showModal" 
                                         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" 
                                         x-transition 
                                         style="display: none;">
                                        <div @click.away="showModal = false" 
                                             class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[80vh] overflow-y-auto p-6">
                                            <div class="flex justify-between items-center mb-4">
                                                <h3 class="text-lg font-semibold text-gray-900">Nutrition Notes</h3>
                                                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-gray-700 text-sm prose prose-sm" x-html="marked.parse(aiNotes || '')"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@script
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endscript