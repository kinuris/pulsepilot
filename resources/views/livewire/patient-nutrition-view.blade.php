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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($this->nutritionRecordsPaginated as $record)
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
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if ($isLoading)
                            <div class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-b-transparent border-gray-900/60 mr-2"></div>
                            @endif
                            {{ $record->notes ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>