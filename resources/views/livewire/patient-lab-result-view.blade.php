<div class="flex flex-col relative">
    <div x-show="$wire.createModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="$wire.createModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"
                aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="$wire.createModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block px-6 pt-5 pb-6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-8">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button wire:click="$set('createModal', false)" type="button" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition duration-150">
                        <span class="sr-only">Close</span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Create Laboratory Test Request</h3>
                        <p class="mt-1 text-sm text-gray-500">Complete the form below to request laboratory tests for this patient. <span class="text-red-500 font-medium">Fields marked with * are required.</span></p>

                        <div class="mt-6">
                            @if ($errors->any())
                            <div class="p-4 mb-4 border border-red-200 rounded-md bg-red-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <form wire:submit.prevent="submitLabRequest" class="space-y-6">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <label for="lab_test_type" class="block text-sm font-medium text-gray-700 mb-1">Laboratory Test Type <span class="text-red-500">*</span></label>
                                        <select id="lab_test_type" wire:model.defer="testType" class="block w-full py-2 px-3 border-gray-300 rounded-md shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm @error('testType') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                                            <option value="">Select Test Type</option>
                                            <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
                                            <option value="Blood Chemistry">Blood Chemistry</option>
                                            <option value="Urinalysis">Urinalysis</option>
                                            <option value="Imaging/Radiology">Imaging/Radiology</option>
                                            <option value="Microbiology Culture">Microbiology Culture</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('testType')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <label for="test_priority" class="block text-sm font-medium text-gray-700 mb-1">Priority Level <span class="text-red-500">*</span></label>
                                        <select id="test_priority" wire:model.defer="priorityLevel" class="block w-full py-2 px-3 border-gray-300 rounded-md shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm @error('priorityLevel') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                                            <option value="">Select Priority</option>
                                            <option value="Routine">Routine</option>
                                            <option value="Urgent">Urgent</option>
                                            <option value="Stat (Immediate)">STAT (Immediate)</option>
                                        </select>
                                        @error('priorityLevel')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Clinical Indication <span class="text-red-500">*</span></label>
                                    <textarea id="reason" rows="3" wire:model.defer="clinicalIndication" class="block w-full py-2 px-3 border-gray-300 rounded-md shadow-sm focus:ring-blue-600 max-h-20 min-h-20 focus:border-blue-600 sm:text-sm @error('clinicalIndication') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Explain the clinical reason for requesting these tests..." required></textarea>
                                    @error('clinicalIndication')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center h-5">
                                        <input id="fasting" wire:model.defer="fastingRequired" type="checkbox" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-600 @error('fastingRequired') border-red-300 @enderror">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="fasting" class="font-medium text-gray-700">Fasting Required</label>
                                        <p class="text-gray-500">Check if patient needs to fast prior to sample collection.</p>
                                        @error('fastingRequired')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="pt-4 mt-6 border-t border-gray-200">
                                    <div class="flex justify-end space-x-4">
                                        <button wire:click="$set('createModal', false)" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                            Cancel
                                        </button>
                                        <button type="submit" class="inline-flex justify-center px-5 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                            Submit Request
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="$wire.labRequestId" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="$wire.labRequestId"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"
                aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="$wire.labRequestId"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative inline-block px-6 pt-5 pb-6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-8">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button wire:click="closeLabResult" type="button" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition duration-150">
                        <span class="sr-only">Close</span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Laboratory Test Results</h3>
                        <p class="mt-1 text-sm text-gray-500">Viewing the results of the selected laboratory test.</p>

                        <div class="mt-6">
                            @if($this->labResult)
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Test Information</h4>
                                    <dl class="grid grid-cols-1 gap-y-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Test Type</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($this->labResult->type) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Priority Level</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($this->labRequest->priority_level) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Fasting Required</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $this->labRequest->fasting_required ? 'Yes' : 'No' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Patient Details</h4>
                                    <dl class="grid grid-cols-1 gap-y-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $this->labRequest->patient->name ?? 'Unknown' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Patient ID</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $this->labRequest->patient->id ?? 'N/A' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Clinical Indication</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $this->labRequest->clinical_indication }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Test Results</h4>

                                @if($this->labResult)
                                <div class="mt-1 text-sm text-gray-900">
                                    @if($this->labResult->type == 'image')
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $this->labResult->file_path) }}" alt="Medical Imaging Result" class="w-full rounded-md shadow-sm">
                                        <a href="{{ asset('storage/' . $this->labResult->file_path) }}" 
                                           download="{{ basename($this->labResult->file_path) }}"
                                           class="absolute top-2 right-2 inline-flex items-center px-3 py-1.5 bg-white bg-opacity-90 hover:bg-opacity-100 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 hover:text-gray-900 transition-colors">
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                    @else
                                    <div class="space-y-2">
                                        @if($this->labResult->file_path)
                                            <div class="border rounded-md p-3 bg-white">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-sm font-medium text-gray-700">
                                                        File: {{ basename($this->labResult->file_path) }}
                                                    </span>
                                                    <a href="{{ asset('storage/' . $this->labResult->file_path) }}" 
                                                       target="_blank" 
                                                       class="text-sm text-blue-600 hover:text-blue-800">
                                                        View Full Size
                                                    </a>
                                                </div>
                                                
                                                @if(Str::endsWith(strtolower($this->labResult->file_path), ['.pdf']))
                                                    <div class="bg-gray-100 rounded p-3 text-center">
                                                        <svg class="w-10 h-10 mx-auto text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <a href="{{ asset('storage/' . $this->labResult->file_path) }}" class="mt-2 inline-block text-blue-600 hover:underline" target="_blank">
                                                            Download PDF File
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="overflow-hidden">
                                                        <a href="{{ asset('storage/' . $this->labResult->file_path) }}" target="_blank">
                                                            <embed src="{{ asset('storage/' . $this->labResult->file_path) }}" 
                                                                  class="w-full h-64 border rounded">
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <div class="prose prose-sm">
                                            <pre class="text-sm bg-gray-50 p-3 rounded overflow-auto max-h-48">{{ $this->labResult->result_text ?? 'No text results available' }}</pre>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @else
                                <div class="rounded-md bg-yellow-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800">Results Pending</h3>
                                            <div class="mt-2 text-sm text-yellow-700">
                                                <p>The laboratory results for this test have not been submitted yet. Please check back later.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="pt-4 mt-6 border-t border-gray-200">
                                <div class="flex justify-end space-x-4">
                                    <button wire:click="closeLabResult" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                        Close
                                    </button>
                                    @if($this->labResult->labSubmission)
                                    <button wire:click="printLabResult({{ $this->labResult->id }})" type="button" class="inline-flex justify-center px-5 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                        Print Results
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="rounded-md bg-yellow-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">No Lab Result Selected</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>There was an error loading the laboratory result. Please try again.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 mt-6 border-t border-gray-200">
                                <div class="flex justify-end">
                                    <button wire:click="closeLabResult" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                        Close
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="flex justify-end mb-4">
            <button
                type="button"
                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm"
                wire:click="$set('createModal', true)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Lab Request
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow overflow-hidden">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Test Type</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Priority</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fasting</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Requested</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @php
                    $labResults = App\Models\LabRequest::query()
                    ->where('user_id', '=', Auth::user()->id)
                    ->where('patient_id', '=', $patient->id)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function($result) {
                    return $result->created_at->format('Y-m-d');
                    });
                    @endphp

                    @forelse($labResults as $date => $results)
                    <tr>
                        <td colspan="6" class="px-6 py-3 bg-gray-50 font-medium text-sm text-gray-800">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                            </div>
                        </td>
                    </tr>
                    @foreach($results as $labResult)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <div class="flex items-center">
                                @if($labResult->type == 'blood')
                                <span class="flex-shrink-0 w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                @elseif($labResult->type == 'chemistry')
                                <span class="flex-shrink-0 w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                @elseif($labResult->type == 'urine')
                                <span class="flex-shrink-0 w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                @elseif($labResult->type == 'imaging')
                                <span class="flex-shrink-0 w-2 h-2 rounded-full bg-purple-500 mr-2"></span>
                                @elseif($labResult->type == 'culture')
                                <span class="flex-shrink-0 w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                @else
                                <span class="flex-shrink-0 w-2 h-2 rounded-full bg-gray-500 mr-2"></span>
                                @endif
                                {{ ucfirst($labResult->type) ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($labResult->priority_level == 'stat')
                            <span class="px-2 py-1 text-xs rounded bg-red-50 text-red-700 font-medium">STAT</span>
                            @elseif($labResult->priority_level == 'urgent')
                            <span class="px-2 py-1 text-xs rounded bg-orange-50 text-orange-700 font-medium">Urgent</span>
                            @else
                            <span class="px-2 py-1 text-xs rounded bg-blue-50 text-blue-700 font-medium">Routine</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($labResult->fasting_required)
                            <span class="text-blue-600">Required</span>
                            @else
                            <span class="text-gray-500">Not Required</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="font-medium">{{ $labResult->patient->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $labResult->patient->id ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div>{{ $labResult->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $labResult->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($labResult->labSubmission)
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 inline-flex place-items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="mr-1 h-3 w-3 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Completed
                                </span>
                                <button wire:click="$set('labRequestId', {{ $labResult->id }})" class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 transition-colors duration-150 flex items-center">
                                    <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </button>
                            </div>
                            @else
                            <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <svg class="mr-1 h-3 w-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Pending
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 bg-gray-50">
                            <div class="flex flex-col items-center">
                                <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="font-medium">No laboratory results found</p>
                                <p class="text-sm text-gray-400 mt-1">Laboratory test requests will appear here once created</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>