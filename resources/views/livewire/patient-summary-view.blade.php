<div>
    <div class="p-8 bg-gray-50">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Patient Summary</h2>

        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 hover:bg-gray-50 rounded-md transition duration-150 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <p class="text-gray-600 text-xs uppercase tracking-wider mb-1">Name</p>
                        <p class="text-gray-900 font-medium">{{ $patient->name }}</p>
                    </div>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded-md transition duration-150 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <p class="text-gray-600 text-xs uppercase tracking-wider mb-1">Date of Birth</p>
                        <p class="text-gray-900 font-medium">{{ date('F j, Y', strtotime($patient->birthdate)) }}</p>
                    </div>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded-md transition duration-150 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <div>
                        <p class="text-gray-600 text-xs uppercase tracking-wider mb-1">Contact Number</p>
                        <p class="text-gray-900 font-medium">{{ $patient->contact_number }}</p>
                    </div>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded-md transition duration-150 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-gray-600 text-xs uppercase tracking-wider mb-1">Age</p>
                        <p class="text-gray-900 font-medium">{{ $patient->age }}</p>
                    </div>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded-md transition duration-150 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <p class="text-gray-600 text-xs uppercase tracking-wider mb-1">Sex</p>
                        <p class="text-gray-900 font-medium">{{ ucwords($patient->sex) }}</p>
                    </div>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded-md transition duration-150 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <div>
                        <p class="text-gray-600 text-xs uppercase tracking-wider mb-1">Address</p>
                        <p class="text-gray-900 font-medium">{{ $patient->address }}</p>
                    </div>
                </div>
                <div class="p-3 hover:bg-gray-50 rounded-md transition duration-150 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-3m3 3v-3m3 3v-3m3 3v-3m3 3v-3M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <p class="text-gray-600 text-xs uppercase tracking-wider mb-1">Latest BMI Record</p>
                        @php($latestBmi = $patient->bmiRecords()->get()->sortBy('recorded_at', descending: true)->first())
                        <p class="text-gray-900 font-medium">
                            @if($latestBmi)
                                {{ number_format($latestBmi->bmi_value, 2) }} kg/m² ({{ date('F j, Y', strtotime($latestBmi->recorded_at)) }})
                            @else
                                No BMI record found.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>