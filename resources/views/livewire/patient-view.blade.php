<div class="flex bg-gray-50">
    @include('includes.doctor-nav')
    <div class="flex flex-col p-6 items-stretch w-full max-h-screen overflow-auto">
        <div class="flex gap-4">
            <div class="relative flex-1">
                <div class="absolute left-0 top-3.5 pl-2 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live="search" wire:focus="focused()" type="text" class="p-3.5 border pl-10 block w-full rounded-md border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Find Patient">

                @if ($isFocused)
                <div class="absolute z-50 w-full mt-2 bg-white rounded-lg border border-gray-200 shadow-xl">
                    <div class="flex justify-end px-4 pt-2">
                        <button wire:click="unfocused()" class="text-red-500 hover:text-red-700 w-full">
                            <p class="text-left">Close</p>
                        </button>
                    </div>
                    @if(count($this->searchResults) > 0)
                    @foreach($this->searchResults as $result)
                    <div wire:click="setSelectedPatient({{ $result->id }})" class="flex rounded-lg items-center px-4 py-2 hover:bg-gray-50 transition duration-150 ease-in-out cursor-pointer border-b border-gray-100 last:border-b-0">
                        <div class="flex-1">
                            <div class="text-gray-900 font-semibold">{{ $result->name }}</div>
                            <div class="text-sm text-gray-600">patient id: {{ $result->id }}</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewbox="0 0 20 20" fill="currentcolor">
                            <path fill-rule="evenodd" d="m7.293 14.707a1 1 0 010-1.414l10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    @endforeach
                    @else
                    <div class="px-4 py-3 text-gray-600">no matching patients found</div>
                    @endif
                </div>
                @endif
            </div>

            <div class="flex-1">
                @if($this->selectedPatient)
                <div class="bg-white rounded-lg shadow-md border border-gray-100 h-12">
                    <div class="flex justify-between items-center px-6 h-full bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-semibold text-gray-900">{{ $this->selectedPatient->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    ID: {{ $this->selectedPatient->id }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button wire:click="clearSelectedPatient()" class="inline-flex items-center p-1.5 border border-transparent rounded-full text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <button wire:click="$refresh" class="inline-flex items-center p-1.5 ml-2 border border-transparent rounded-full text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white rounded-lg shadow-md border border-gray-100 h-12">
                    <div class="text-center py-1 flex items-center justify-center">
                        <svg class="h-8 w-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">No Patient Selected</h3>
                            <p class="text-xs text-gray-500">Search to select a patient</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($this->selectedPatient)
        <div class="bg-white p-4 rounded-xl shadow-lg w-full mt-6">
            <p class="text-gray-500 tracking-wide font-semibold">PULSEPILOT PATIENT RECORD</p>

            <div class="flex space-x-4 mt-4 border-b border-gray-200">
                <button wire:click="$set('activeTab', 'summary')" class="px-4 py-2 {{ $activeTab === 'summary' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Summary</button>
                <button wire:click="$set('activeTab', 'glucose')" class="px-4 py-2 {{ $activeTab === 'glucose' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Glucose</button>
                <button wire:click="$set('activeTab', 'nutrition')" class="px-4 py-2 {{ $activeTab === 'nutrition' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Nutrition</button>
                <button wire:click="$set('activeTab', 'activity')" class="px-4 py-2 {{ $activeTab === 'activity' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Activity</button>
                <button wire:click="$set('activeTab', 'medicine')" class="px-4 py-2 {{ $activeTab === 'medicine' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Medicine</button>
                <button wire:click="$set('activeTab', 'labResults')" class="px-4 py-2 {{ $activeTab === 'labResults' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Lab Results</button>
                <button wire:click="$set('activeTab', 'medicalHistory')" class="px-4 py-2 {{ $activeTab === 'medicalHistory' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">Medical History</button>
            </div>

            @if ($activeTab === 'summary' && $this->selectedPatient)
            <livewire:patient-summary-view :patient="$this->selectedPatient" />
            @elseif ($activeTab === 'glucose' && $this->selectedPatient)
            <livewire:patient-glucose-view :patient="$this->selectedPatient" />
            @elseif ($activeTab === 'nutrition' && $this->selectedPatient)
            <livewire:patient-nutrition-view :patient="$this->selectedPatient" />
            @elseif ($activeTab === 'activity' && $this->selectedPatient)
            <livewire:patient-activity-view :patient="$this->selectedPatient" />
            @elseif ($activeTab === 'medicine' && $this->selectedPatient)
            <livewire:patient-medicine-view :patient="$this->selectedPatient" />
            @elseif ($activeTab === 'labResults' && $this->selectedPatient)
            <livewire:patient-lab-result-view :patient="$this->selectedPatient" />
            @elseif ($activeTab === 'medicalHistory' && $this->selectedPatient)
            <livewire:patient-history-view :patient="$this->selectedPatient" />
            @endif
        </div>
        @else
        <div class="bg-white p-4 rounded-xl shadow-lg w-full mt-6">
            <div class="text-center py-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Patient Selected</h3>
                <p class="mt-1 text-sm text-gray-500">Please select a patient to view their record</p>
            </div>

        </div>
        @endif
    </div>
</div>