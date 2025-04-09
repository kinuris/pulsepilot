<div>
    <div class="flex flex-col">
        <!-- Records Table -->
        <div class="mt-6">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $groupedRecords = $this->activityRecordsPaginated->groupBy(function($record) {
                                return date('Y-m-d', strtotime($record->created_at));
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
                            @foreach($records as $activity)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ date_create($activity->created_at)->format('M d, Y g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ ucwords($activity->type) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $activity->duration }} minutes
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        x{{ $activity->frequency }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
