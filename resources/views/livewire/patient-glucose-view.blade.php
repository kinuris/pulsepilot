<div class="flex flex-col">
    <!-- Unit Toggle -->
    <div class="my-4 flex">
        <div class="inline-flex rounded-lg shadow-sm">
            <button wire:click="$set('unit', 'mmol')"
                class="px-5 py-2.5 text-sm font-medium transition-colors duration-200 {{ $unit === 'mmol' ? 'bg-blue-600 text-white' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }} rounded-l-lg border border-gray-200">
                mmol/L
            </button>
            <button wire:click="$set('unit', 'mgdl')"
                class="px-5 py-2.5 text-sm font-medium transition-colors duration-200 {{ $unit === 'mgdl' ? 'bg-blue-600 text-white' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }} rounded-r-lg border border-gray-200">
                mg/dL
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Latest Reading Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="ml-3 text-lg font-semibold text-gray-800">Latest Reading</h3>
                        <div class="ml-3 text-xs text-gray-500">
                            {{ $this->latestRecord->recorded_at ? Carbon\Carbon::parse($this->latestRecord->recorded_at)->format('F j, Y \a\t g:i A') : 'No record' }}
                        </div>
                    </div>
                </div>
                <p class="text-3xl font-bold text-blue-600">
                    {{ $unit === 'mgdl' ? number_format(($this->latestRecord->glucose_level ?? 0) * 18, 1) : $this->latestRecord->glucose_level ?? 'N/A' }}
                    <span class="text-base font-medium text-gray-500">{{ $unit === 'mmol' ? 'mmol/L' : 'mg/dL' }}</span>
                </p>
            </div>
        </div>

        <!-- Week Average Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Week Average</h3>
                </div>
                @php($builder = $this->glucoseRecords->where('recorded_at', '>', now()->subDays(7)))
                @if ($builder->count() > 0)
                <p class="text-3xl font-bold text-green-600">
                    {{ $unit === 'mgdl' ? number_format(($builder->avg('glucose_level') ?? 0) * 18, 1) : number_format($this->glucoseRecords->where('recorded_at', '>', now()->subDays(7))->avg('glucose_level') ?? 0, 1) }}
                    <span class="text-base font-medium text-gray-500">{{ $unit === 'mmol' ? 'mmol/L' : 'mg/dL' }}</span>
                </p>
                @else
                <p class="text-2xl font-bold text-green-600">
                    No records this week
                </p>
                @endif
            </div>
        </div>

        <!-- Last Updated Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-purple-50 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Last Updated</h3>
                </div>
                <p class="text-3xl font-bold text-purple-600">
                    {{ Carbon\Carbon::parse($this->latestRecord->recorded_at)->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>

    <!-- Glucose Records Table -->
    <div class="mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glucose Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($this->glucoseRecordsPaginated as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ date_create($record->recorded_at)->format('M d, Y g:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $unit === 'mgdl' ? number_format($record->glucose_level * 18, 1) : number_format($record->glucose_level, 1) }}
                            {{ $unit === 'mmol' ? 'mmol/L' : 'mg/dL' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $record->notes ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>