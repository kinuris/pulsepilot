<div class="flex flex-col">
    <div class="mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Form</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reminder Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Taken</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $groupedRecords = $this->medicationRecordsPaginated->groupBy(function($record) {
                            return \Carbon\Carbon::parse($record->medication_reminder_date)->format('Y-m-d');
                        });
                    @endphp

                    @foreach($groupedRecords as $date => $records)
                        <tr class="bg-gradient-to-r from-blue-50 to-white">
                            <td colspan="6" class="px-6 py-4 text-sm font-semibold text-gray-800 border-b-2 border-blue-200 shadow-sm">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}</span>
                                </div>
                            </td>
                        </tr>
                        @foreach($records as $record)
                        <tr class="transition-colors duration-200 ease-in-out hover:bg-blue-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->medicine_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->medicine_route }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->medicine_form }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ number_format($record->medicine_dosage, 0) }} ml</td>
                            <td class="px-6 py-4 text-sm font-semibold bg-yellow-50 border-l-4 border-yellow-400">{{ \Carbon\Carbon::parse($record->medication_reminder_date)->format('g:i A') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($record->recorded_time_taken)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full font-medium">
                                        {{ \Carbon\Carbon::parse($record->recorded_time_taken)->format('g:i A') }}
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">
                                        Not taken
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>