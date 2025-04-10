<div class="flex relative">
    @include('includes.doctor-nav')
    <!-- View Appointment Details Modal -->
    <div class="relative z-50">
        <!-- Modal Background Overlay -->
        <div x-show="$wire.viewedAppointment !== null"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>

        <!-- Modal Content -->
        <div x-show="$wire.viewedAppointment !== null"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-10 overflow-y-auto">

            <!-- Added flex container for centering -->
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- This element centers the modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full sm:align-middle">
                    <div class="px-5 pt-5 pb-4 sm:p-6">
                        <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                            <div>
                                <h3 class="text-lg leading-6 font-semibold text-gray-900">Appointment Details</h3>
                                @if(isset($viewedAppointment['status']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $this->getStatusColor(ucwords($viewedAppointment['status'])) }}-100 text-{{ $this->getStatusColor(ucwords($viewedAppointment['status'])) }}-800 mt-1">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-{{ $this->getStatusColor(ucwords($viewedAppointment['status'])) }}-500"></span>
                                        {{ $viewedAppointment['status'] }}
                                    </span>
                                @endif
                            </div>
                            <button wire:click="$set('viewedAppointment', null)" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full p-1">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-5 space-y-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <span class="text-xs font-medium text-gray-500">Patient</span>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ isset($viewedAppointment['patient']) ? $viewedAppointment['patient']['first_name'] . ' ' . ($viewedAppointment['patient']['middle_name'] ? $viewedAppointment['patient']['middle_name'][0] . '.' . ' ' : '') . $viewedAppointment['patient']['last_name'] : '' }}
                                    </p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Date</span>
                                        <p class="mt-1 text-sm font-medium text-gray-900">
                                            {{ isset($viewedAppointment['appointment_date']) ? date('F j, Y', strtotime($viewedAppointment['appointment_date'])) : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Time</span>
                                        <p class="mt-1 text-sm font-medium text-gray-900">
                                            @if(isset($viewedAppointment['appointment_time']))
                                            {{ date('g:i A', strtotime($viewedAppointment['appointment_time'])) }} -
                                            {{ date('g:i A', strtotime($viewedAppointment['appointment_time'] . ' + ' . $viewedAppointment['duration_minutes'] . ' minutes')) }}
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Duration</span>
                                        <p class="mt-1 text-sm font-medium text-gray-900">
                                            {{ isset($viewedAppointment['duration_minutes']) ? $viewedAppointment['duration_minutes'] . ' minutes' : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-xs font-medium text-gray-500">Reason</span>
                                        <p class="mt-1 text-sm font-medium text-gray-900">
                                            {{ isset($viewedAppointment['reason']) ? $viewedAppointment['reason'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-medium text-gray-500">Status</span>
                                    <span class="w-2 h-2 rounded-full inline-block bg-{{ $this->getStatusColor(ucwords($viewedAppointmentStatus)) }}-500"></span>
                                </div>

                                <div class="mt-1">
                                    <select wire:model.live="viewedAppointmentStatus" class="border-gray-300 px-3 py-2 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm w-full bg-white">
                                        <option value="Confirmed" {{ $viewedAppointmentStatus === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="Pending" {{ $viewedAppointmentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Completed" {{ $viewedAppointmentStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Canceled" {{ $viewedAppointmentStatus === 'canceled' ? 'selected' : '' }}>Canceled</option>
                                        <option value="No-Show" {{ $viewedAppointmentStatus === 'no-show' ? 'selected' : '' }}>No-show</option>
                                    </select>
                                </div>

                                @if(($viewedAppointmentStatus !== ($viewedAppointment['status'] ?? '') && $viewedAppointment !== null))
                                <div wire:transition class="mt-1 text-xs text-{{ $this->getStatusColor(ucwords($viewedAppointmentStatus)) }}-600 font-medium flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    {{ ($viewedAppointment['status'] ?? '') }} → {{ $viewedAppointmentStatus }}
                                </div>
                                @endif
                            </div>

                            @if(isset($viewedAppointment['notes']) && $viewedAppointment['notes'])
                            <div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <span class="text-xs font-medium text-gray-500">Notes</span>
                                        <p class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $viewedAppointment['notes'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 rounded-b-lg">
                        <button wire:click="updateAppointmentStatus" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save Changes
                        </button>
                        <button wire:click="$set('viewedAppointment', null)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Schedule Modal -->
    <div x-show="$wire.showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:p-0">
            <div x-show="$wire.showCreateModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"
                aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="$wire.showCreateModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative inline-block px-4 pt-4 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">

                <div class="flex justify-between items-center mb-3 pb-2 border-b">
                    <h3 class="text-lg font-bold text-gray-800">Schedule New Appointment</h3>
                    <button wire:click="$set('showCreateModal', false)" class="text-gray-500 hover:text-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-full p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3 mb-4">
                    <div class="grid grid-cols-3 gap-3">
                        @php
                        $patients = Auth::user()->patients();
                        @endphp
                        <div class="col-span-3 sm:col-span-1">
                            <label for="patient" class="block text-xs font-medium text-gray-700 mb-1">Patient Name</label>
                            <select wire:model="patientId" id="patient" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-1.5 text-sm bg-gray-50">
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">({{ $patient->id }}) {{ $patient->name }}</option>
                                @endforeach
                            </select>
                            @error('patientId') <span class="text-xs text-red-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-3 sm:col-span-1">
                            <label for="date" class="block text-xs font-medium text-gray-700 mb-1">Appointment Date</label>
                            <input wire:model="appointmentDate" wire:change="loadAvailableTimeSlots" type="date" id="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-1.5 text-sm bg-gray-50">
                            @error('appointmentDate') <span class="text-xs text-red-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-3 sm:col-span-1">
                            <label for="duration" class="block text-xs font-medium text-gray-700 mb-1">Duration</label>
                            <select wire:model="durationMinutes" wire:change="loadAvailableTimeSlots" id="duration" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-1.5 text-sm bg-gray-50">
                                <option value="15">15 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">60 minutes</option>
                            </select>
                            @error('durationMinutes') <span class="text-xs text-red-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12 sm:col-span-8">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Available Time Slots</label>
                            <div class="grid grid-cols-4 sm:grid-cols-5 gap-1.5 max-h-36 overflow-y-auto p-1.5 border rounded-md border-gray-200 bg-gray-50">
                                @if(!empty($availableTimeSlots))
                                @foreach($availableTimeSlots as $slot)
                                <button
                                    type="button"
                                    wire:click="selectTimeSlot('{{ $slot['start'] }}', '{{ $slot['end'] }}')"
                                    class="py-1 px-1.5 text-xs border rounded-md shadow-sm transition-colors {{ $appointmentTime == $slot['start'] ? 'bg-blue-100 border-blue-500 text-blue-800 ring-1 ring-blue-300' : 'bg-white hover:bg-gray-50 border-gray-300 hover:border-blue-300' }}">
                                    {{ date('g:i A', strtotime($slot['start'])) }}
                                </button>
                                @endforeach
                                @elseif($appointmentDate)
                                <div class="col-span-full py-3 text-center text-gray-500 text-xs">
                                    <svg class="w-5 h-5 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    No available time slots
                                </div>
                                @else
                                <div class="col-span-full py-3 text-center text-gray-500 text-xs">
                                    <svg class="w-5 h-5 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Select a date
                                </div>
                                @endif
                            </div>
                            @error('appointmentTime') <span class="text-xs text-red-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-4">
                            <label for="reason" class="block text-xs font-medium text-gray-700 mb-1">Reason</label>
                            <select wire:model="appointmentReason" id="reason" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-1.5 text-sm bg-gray-50">
                                <option value="">Select Reason</option>
                                <option value="Checkup">Checkup</option>
                                <option value="Follow-up">Follow-up</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Procedure">Procedure</option>
                                <option value="Emergency">Emergency</option>
                            </select>
                            @error('appointmentReason') <span class="text-xs text-red-600 mt-0.5 block">{{ $message }}</span> @enderror

                            @if($appointmentTime)
                            <div class="mt-2 p-2 bg-blue-50 rounded-md border border-blue-200 text-xs">
                                <span class="font-medium text-blue-700">Selected:</span>
                                <span class="ml-1 text-blue-800">{{ date('g:i A', strtotime($appointmentTime)) }} - {{ date('g:i A', strtotime($appointmentEndTime)) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-xs font-medium text-gray-700 mb-1">Notes</label>
                        <textarea wire:model="appointmentNotes" id="notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-1.5 text-sm bg-gray-50 min-h-16 max-h-24"></textarea>
                        @error('notes') <span class="text-xs text-red-600 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t">
                    <button wire:click="$set('showCreateModal', false)" class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 text-sm">
                        Cancel
                    </button>
                    <button wire:click="createAppointment" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:bg-blue-600" {{ !$appointmentTime ? 'disabled' : '' }}>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Schedule
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-h-screen overflow-auto flex-1 p-6 bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <!-- Calendar Header -->
            <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center gap-4 mb-4 lg:mb-0 w-full lg:w-auto">
                    <h1 class="text-2xl font-bold text-gray-800">Appointment Calendar</h1>
                    <div class="flex bg-gray-100 rounded-lg p-1 gap-1.5 shadow-inner">
                        <button wire:click="setView('day')" class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $view == 'day' ? 'bg-white text-blue-700 shadow' : 'text-gray-600 hover:bg-gray-200' }}">Day</button>
                        <button wire:click="setView('week')" class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $view == 'week' ? 'bg-white text-blue-700 shadow' : 'text-gray-600 hover:bg-gray-200' }}">Week</button>
                        <button wire:click="setView('month')" class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $view == 'month' ? 'bg-white text-blue-700 shadow' : 'text-gray-600 hover:bg-gray-200' }}">Month</button>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full lg:w-auto justify-between lg:justify-end">
                    <button wire:click="$set('showCreateModal', true)" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Schedule
                    </button>
                    <div class="flex items-center">
                        <button wire:click="previousPeriod" class="p-2 rounded-md hover:bg-gray-100 transition-colors" aria-label="Previous period">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800 px-4">
                            @if($view == 'day')
                            {{ \Carbon\Carbon::parse($currentDate)->format('F j, Y') }}
                            @elseif($view == 'week')
                            Week {{ \Carbon\Carbon::parse($currentDate)->weekOfMonth }} of {{ \Carbon\Carbon::parse($currentDate)->format('F Y') }}
                            @elseif($view == 'month')
                            {{ \Carbon\Carbon::parse($currentDate)->format('F Y') }}
                            @endif
                        </h2>
                        <button wire:click="nextPeriod" class="p-2 rounded-md hover:bg-gray-100 transition-colors" aria-label="Next period">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            @if($view == 'day')
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <!-- Day View -->
                <div class="min-h-[120px] p-3 bg-white">
                    @php
                    $schedules = $this->existingSchedules();
                    @endphp
                    <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-3">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-blue-700 bg-blue-50 px-3 py-1 rounded-full mr-2">
                                {{ \Carbon\Carbon::parse($currentDate)->format('l, F j, Y') }}
                            </span>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">{{ $schedules->where('appointment_date', $currentDate)->count() }} appointments scheduled</span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($currentDate)->isSameDay(now()) ? 'Today' : \Carbon\Carbon::parse($currentDate)->startOfDay()->diffForHumans(\Carbon\Carbon::now()->startOfDay()) }}
                        </div>
                    </div>
                    @forelse($schedules->where('appointment_date', $currentDate)->sortBy('appointment_time') as $schedule)
                    <div wire:click="viewAppointment({{ $schedule->id }})" class="mb-2 p-2 rounded hover:bg-gray-50 transition-colors border-l-4 border-{{ $this->getStatusColor(ucwords($schedule->status)) }}-400 flex items-center shadow-sm cursor-pointer">
                        <div class="w-16 text-xs text-gray-600 font-medium">{{ date('g:i A', strtotime($schedule->appointment_time)) }}</div>
                        <div class="flex-1 font-medium">{{ $schedule->patient->name ?? 'Patient' }} <span class="text-xs bg-{{ $this->getStatusColor(ucwords($schedule->status)) }}-100 text-{{ $this->getStatusColor(ucwords($schedule->status)) }}-800 px-2 py-0.5 rounded-full ml-2">{{ $schedule->status }}</span></div>
                        <div class="text-sm text-gray-500">{{ $schedule->reason }}</div>
                    </div>
                    @empty
                    <div class="text-center py-6 text-gray-500">
                        No appointments scheduled for this day
                    </div>
                    @endforelse
                </div>
            </div>
            @elseif($view == 'week')
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                @php
                // Generate days for the week view
                $startOfWeek = Carbon\Carbon::parse($currentDate)->startOfWeek();
                $weekDays = [];
                for ($i = 0; $i < 7; $i++) {
                    $date=$startOfWeek->copy()->addDays($i);
                    $weekDays[] = [
                    'date' => $date->format('Y-m-d'),
                    'name' => $date->format('D'),
                    'display_date' => $date->format('j'),
                    'is_today' => $date->isToday(),
                    'is_month_start' => $date->day === 1,
                    'is_month_end' => $date->day === $date->daysInMonth
                    ];
                    }
                    @endphp
                    <!-- Week Headers -->
                    <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                        @foreach($weekDays as $index => $day)
                        <div class="text-center py-3 font-medium text-gray-600 border-r last:border-r-0 border-gray-200">{{ $day['name'] }}</div>
                        @endforeach
                    </div>

                    <!-- Week View -->
                    <div class="grid grid-cols-7 min-h-[500px]">
                        @php
                        $schedules = $this->existingSchedules();
                        @endphp
                        @foreach($weekDays as $index => $day)
                        <div class="border-r last:border-r-0 border-b border-gray-200 p-2 {{ $day['is_today'] ? 'bg-blue-50' : '' }}">
                            <div class="flex justify-between mb-2">
                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-medium {{ $day['is_today'] ? 'text-blue-700 bg-blue-100 rounded-full px-2' : 'text-gray-600' }}">{{ $day['display_date'] }}</span>
                                    @if($day['is_month_start'])
                                    <span class="text-[10px] uppercase text-green-700 font-semibold">{{ Carbon\Carbon::parse($day['date'])->format('M') }}</span>
                                    @elseif($day['is_month_end'])
                                    <span class="text-[10px] uppercase text-orange-700 font-semibold">{{ Carbon\Carbon::parse($day['date'])->format('M') }}</span>
                                    @endif
                                </div>
                                @php $daySchedulesCount = $schedules->where('appointment_date', $day['date'])->count(); @endphp
                                @if($daySchedulesCount > 0)
                                <span class="text-xs bg-blue-100 text-blue-700 rounded-full px-1.5 py-0.5 text-center min-w-[20px]">{{ $daySchedulesCount }}</span>
                                @endif
                            </div>
                            @foreach($schedules->where('appointment_date', $day['date'])->sortBy('appointment_time')->take(3) as $schedule)
                            <div wire:click="viewAppointment({{ $schedule->id }})" class="mb-2 p-1.5 rounded hover:bg-gray-50 transition-colors border-l-3 border-{{ $this->getStatusColor(ucwords($schedule->status)) }}-400 shadow-sm cursor-pointer group flex items-start gap-1">
                                <div class="flex-1">
                                    <div class="text-xs text-gray-500 group-hover:text-gray-700">{{ date('g:i A', strtotime($schedule->appointment_time)) }}</div>
                                    <div class="font-medium text-sm truncate">{{ $schedule->patient->name ?? 'Patient' }}</div>
                                </div>
                                <div class="w-1.5 h-1.5 rounded-full bg-{{ $this->getStatusColor(ucwords($schedule->status)) }}-500 flex-shrink-0"></div>
                            </div>
                            @endforeach
                            @php $remaining = $schedules->where('appointment_date', $day['date'])->count() - 3; @endphp
                            @if($remaining > 0)
                            <div class="text-xs text-center mt-1 text-blue-600 font-medium">+{{ $remaining }} more</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
            </div>
            @else
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <!-- Day Headers -->
                <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayHeader)
                    <div class="text-center py-3 font-medium text-gray-600 border-r last:border-r-0 border-gray-200">{{ $dayHeader }}</div>
                    @endforeach
                </div>

                <!-- Month View -->
                <div class="grid grid-cols-7 min-h-[600px]">
                    @php
                    $schedules = $this->existingSchedules();

                    // Calculate month days for the calendar view
                    $firstDayOfMonth = Carbon\Carbon::parse($this->currentDate)->firstOfMonth();
                    $lastDayOfMonth = Carbon\Carbon::parse($this->currentDate)->lastOfMonth();
                    $currentMonth = $firstDayOfMonth->month;
                    $currentYear = $firstDayOfMonth->year;

                    // Start from the first day of the week containing the first day of the month
                    $startDay = clone $firstDayOfMonth;
                    $startDay->subDays($firstDayOfMonth->dayOfWeek);

                    // End on the last day of the week containing the last day of the month
                    $endDay = clone $lastDayOfMonth;
                    $endDay->addDays(6 - $lastDayOfMonth->dayOfWeek);

                    $monthDays = [];
                    $day = clone $startDay;

                    while ($day <= $endDay) {
                        $monthDays[]=[ 'date'=> $day->format('Y-m-d'),
                        'day' => $day->format('j'),
                        'in_month' => $day->month === $currentMonth,
                        'is_today' => $day->isToday()
                        ];
                        $day->addDay();
                        }
                        @endphp
                        @foreach($monthDays as $day)
                        <div class="border-r last:border-r-0 border-b border-gray-200 p-2 {{ !$day['in_month'] ? 'bg-gray-50' : ($day['is_today'] ? 'bg-blue-50' : '') }}">
                            @if($day['date'])
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium {{ $day['is_today'] ? 'text-blue-700 bg-blue-100 rounded-full w-6 h-6 flex items-center justify-center' : 'text-gray-600' }}">{{ $day['day'] }}</span>
                                @php
                                $daySchedulesCount = $schedules->where('appointment_date', $day['date'])->count();
                                @endphp
                                @if($daySchedulesCount > 0)
                                <span class="text-xs bg-blue-100 text-blue-700 rounded-full px-1.5 py-0.5 text-center min-w-[20px]">{{ $daySchedulesCount }}</span>
                                @endif
                            </div>
                            @if($day['in_month'])
                            @foreach($schedules->where('appointment_date', '=', $day['date'])->sortBy('appointment_time')->take(2) as $schedule)
                            <div wire:click="viewAppointment({{ $schedule->id }})" class="mb-1.5 p-1.5 rounded-md hover:bg-gray-50 transition-colors border-l-3 border-{{ $this->getStatusColor(ucwords($schedule->status)) }}-400 shadow-sm cursor-pointer bg-white flex items-start gap-1">
                                <div class="flex-1">
                                    <div class="text-[10px] text-gray-500 font-medium">{{ date('g:i', strtotime($schedule->appointment_time)) }} - {{ date('g:ia', strtotime($schedule->appointment_time . ' + ' . $schedule->duration_minutes . ' minutes')) }}</div>
                                    <div class="font-medium text-xs truncate text-gray-800">{{ $schedule->patient->name ?? 'Patient' }}</div>
                                </div>
                                <div class="w-1.5 h-1.5 rounded-full bg-{{ $this->getStatusColor(ucwords($schedule->status)) }}-500 flex-shrink-0"></div>
                            </div>
                            @endforeach
                            @php
                            $remaining = $schedules->where('appointment_date', $day['date'])->count() - 2;
                            @endphp
                            @if($remaining > 0)
                            <div class="text-xs text-center mt-1 text-blue-600 font-medium">+{{ $remaining }} more</div>
                            @endif
                            @endif
                            @endif
                        </div>
                        @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>