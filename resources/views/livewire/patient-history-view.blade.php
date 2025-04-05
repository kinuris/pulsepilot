<div class="flex flex-col relative">
    <!-- View Immunization History Modal -->
    <div class="relative z-50">
        <!-- Modal Background Overlay -->
        <div x-show="$wire.selectedImmunization !== null"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>

        <!-- Modal Content -->
        <div x-show="$wire.selectedImmunization !== null"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full border border-gray-100">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span x-text="$wire.editImmunization ? 'Edit Immunization' : 'Immunization Details'"></span>
                        </h3>
                        <button type="button" @if($selectedImmunization !== null && $editImmunization) wire:click="$set('editImmunization', false)" @elseif($selectedImmunization !== null) wire:click="$set('selectedImmunization', null)" @endif class="text-gray-500 hover:text-gray-700 focus:outline-none transition-colors">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div x-show="!$wire.editImmunization" class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Vaccine Name</h4>
                                <p class="text-gray-800 font-medium">{{ isset($selectedImmunization['vaccine_name']) ? $selectedImmunization['vaccine_name'] : 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Administration Date</h4>
                                <p class="text-gray-800 font-medium">{{ isset($selectedImmunization['administration_date']) && $selectedImmunization['administration_date'] ? date('M d, Y', strtotime($selectedImmunization['administration_date'])) : 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Dose Number</h4>
                                <p class="text-gray-800 font-medium">{{ isset($selectedImmunization['dose_number']) ? $selectedImmunization['dose_number'] : 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Manufacturer</h4>
                                <p class="text-gray-800 font-medium">{{ isset($selectedImmunization['manufacturer']) ? $selectedImmunization['manufacturer'] : 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner col-span-2">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Additional Notes</h4>
                                <p class="text-gray-800">{{ isset($selectedImmunization['notes']) && $selectedImmunization['notes'] ? $selectedImmunization['notes'] : 'No additional notes available.' }}</p>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('selectedImmunization', null)" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Close
                            </button>
                            <button type="button" wire:click="$set('editImmunization', true)" class="inline-flex justify-center items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </button>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <form x-show="$wire.editImmunization" wire:submit.prevent="updateImmunization" class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_vaccine_name" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Vaccine Name <span class="text-red-600">*</span>
                                </label>
                                <input type="text" wire:model="selectedImmunization.vaccine_name" id="edit_vaccine_name"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('selectedImmunization.vaccine_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_administration_date" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Administration Date <span class="text-red-600">*</span>
                                </label>
                                <input type="date" wire:model="selectedImmunization.administration_date" id="edit_administration_date"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('selectedImmunization.administration_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_dose_number" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Dose Number
                                </label>
                                <input type="number" wire:model="selectedImmunization.dose_number" id="edit_dose_number"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('selectedImmunization.dose_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_manufacturer" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Manufacturer
                                </label>
                                <input type="text" wire:model="selectedImmunization.manufacturer" id="edit_manufacturer"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('selectedImmunization.manufacturer') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner col-span-2">
                                <label for="edit_notes" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Additional Notes
                                </label>
                                <textarea wire:model="selectedImmunization.notes" id="edit_notes" rows="4"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"></textarea>
                                @error('selectedImmunization.notes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 italic">
                            <span class="text-red-600">*</span> Required fields
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('editImmunization', false)" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Past Condition Modal -->
    <div class="relative z-50">
        <!-- Modal Background Overlay -->
        <div x-show="$wire.selectedPastCondition !== null"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>

        <!-- Modal Content -->
        <div x-show="$wire.selectedPastCondition !== null"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full border border-gray-100">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span x-text="$wire.editPastCondition ? 'Edit Medical History' : 'Medical History Details'"></span>
                        </h3>
                        <button type="button" @if($selectedPastCondition !== null && $editPastCondition) wire:click="$set('editPastCondition', false)" @elseif($selectedPastCondition !== null) wire:click="$set('selectedPastCondition', null)" @endif class="text-gray-500 hover:text-gray-700 focus:outline-none transition-colors">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body - View Mode -->
                    <div x-show="!$wire.editPastCondition" class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Condition Name</h4>
                                <p class="text-gray-800 font-medium">{{ isset($selectedPastCondition['condition_name']) ? $selectedPastCondition['condition_name'] : 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Condition Type</h4>
                                <p class="text-gray-800 font-medium">{{ isset($selectedPastCondition['condition_type']) ? $selectedPastCondition['condition_type'] : 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Diagnosis Date</h4>
                                <p class="text-gray-800 font-medium">{{ isset($selectedPastCondition['diagnosis_date']) && $selectedPastCondition['diagnosis_date'] ? date('M d, Y', strtotime($selectedPastCondition['diagnosis_date'])) : 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Current Status</h4>
                                <p class="text-gray-800 font-medium">
                                    @if(isset($selectedPastCondition['status']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $selectedPastCondition['status'] === 'Resolved' ? 'bg-green-100 text-green-800' : 
                                        ($selectedPastCondition['status'] === 'Ongoing' ? 'bg-yellow-100 text-yellow-800' : 
                                            'bg-blue-100 text-blue-800') }}">
                                        {{ $selectedPastCondition['status'] }}
                                    </span>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner col-span-2">
                                <h4 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">Clinical Notes</h4>
                                <p class="text-gray-800">{{ isset($selectedPastCondition['notes']) && $selectedPastCondition['notes'] ? $selectedPastCondition['notes'] : 'No additional notes available.' }}</p>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('selectedPastCondition', null)" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Close
                            </button>
                            <button type="button" wire:click="$set('editPastCondition', true)" class="inline-flex justify-center items-center px-5 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </button>
                        </div>
                    </div>
                    
                    <!-- Edit Form -->
                    <form x-show="$wire.editPastCondition" wire:submit.prevent="updatePastCondition" class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_condition_name" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Condition Name <span class="text-red-600">*</span>
                                </label>
                                <input type="text" wire:model="selectedPastCondition.condition_name" id="edit_condition_name"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('selectedPastCondition.condition_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_condition_type" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Condition Type <span class="text-red-600">*</span>
                                </label>
                                <select wire:model="selectedPastCondition.condition_type" id="edit_condition_type"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                    <option value="">Select condition type</option>
                                    <option value="Chronic Disease">Chronic Disease</option>
                                    <option value="Infection">Infection</option>
                                    <option value="Surgery">Surgery</option>
                                    <option value="Hospitalization">Hospitalization</option>
                                    <option value="Injury">Injury</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('selectedPastCondition.condition_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_diagnosis_date" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Diagnosis Date <span class="text-red-600">*</span>
                                </label>
                                <input type="date" wire:model="selectedPastCondition.diagnosis_date" id="edit_diagnosis_date"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('selectedPastCondition.diagnosis_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="edit_status" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Current Status <span class="text-red-600">*</span>
                                </label>
                                <select wire:model="selectedPastCondition.status" id="edit_status"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                    <option value="">Select status</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Resolved">Resolved</option>
                                    <option value="Managed">Managed</option>
                                    <option value="In Treatment">In Treatment</option>
                                </select>
                                @error('selectedPastCondition.status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner col-span-2">
                                <label for="edit_notes" class="block text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">
                                    Clinical Notes
                                </label>
                                <textarea wire:model="selectedPastCondition.notes" id="edit_notes" rows="4"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out"></textarea>
                                @error('selectedPastCondition.notes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 italic">
                            <span class="text-red-600">*</span> Required fields
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('editPastCondition', false)" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center items-center px-5 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Past Condition Modal -->
    <div class="relative z-50">
        <!-- Modal Background Overlay -->
        <div x-show="$wire.creatingPastCondition"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>

        <!-- Modal Content -->
        <div x-show="$wire.creatingPastCondition"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full border border-gray-100">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Add Medical History Record
                        </h3>
                        <button type="button" wire:click="$set('creatingPastCondition', false)" class="text-gray-500 hover:text-gray-700 focus:outline-none transition-colors">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form wire:submit.prevent="savePastCondition" class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="condition_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Condition Name <span class="text-red-600">*</span>
                                </label>
                                <input type="text" wire:model="pastCondition.condition_name" id="condition_name"
                                    placeholder="Enter condition name"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('pastCondition.condition_name') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="condition_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Condition Type <span class="text-red-600">*</span>
                                </label>
                                <select wire:model="pastCondition.condition_type" id="condition_type"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                    <option value="">Select condition type</option>
                                    <option value="Chronic Disease">Chronic Disease</option>
                                    <option value="Infection">Infection</option>
                                    <option value="Surgery">Surgery</option>
                                    <option value="Hospitalization">Hospitalization</option>
                                    <option value="Injury">Injury</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('pastCondition.condition_type') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="diagnosis_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Diagnosis Date <span class="text-red-600">*</span>
                                </label>
                                <input type="date" wire:model="pastCondition.diagnosis_date" id="diagnosis_date"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('pastCondition.diagnosis_date') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Status <span class="text-red-600">*</span>
                                </label>
                                <select wire:model="pastCondition.status" id="status"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                                    <option value="">Select status</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Resolved">Resolved</option>
                                    <option value="Managed">Managed</option>
                                    <option value="In Treatment">In Treatment</option>
                                </select>
                                @error('pastCondition.status') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Clinical Notes</label>
                                <textarea wire:model="pastCondition.notes" id="notes" rows="4"
                                    placeholder="Enter treatment details, complications, or additional notes"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out"></textarea>
                                @error('pastCondition.notes') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 italic">
                            <span class="text-red-600">*</span> Required fields
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('creatingPastCondition', false)" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center items-center px-5 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Immunization History Modal -->
    <div class="relative z-50">
        <!-- Modal Background Overlay -->
        <div x-show="$wire.creatingImmunization"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>

        <!-- Modal Content -->
        <div x-show="$wire.creatingImmunization"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full border border-gray-100">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Add Immunization Record
                        </h3>
                        <button type="button" wire:click="$set('creatingImmunization', false)" class="text-gray-500 hover:text-gray-700 focus:outline-none transition-colors">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form wire:submit.prevent="saveImmunization" class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="vaccine_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vaccine Name <span class="text-red-600">*</span>
                                </label>
                                <input type="text" wire:model="immunization.vaccine_name" id="vaccine_name"
                                    placeholder="Enter vaccine name"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('immunization.vaccine_name') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="administration_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Administration Date <span class="text-red-600">*</span>
                                </label>
                                <input type="date" wire:model="immunization.administration_date" id="administration_date"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('immunization.administration_date') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="dose_number" class="block text-sm font-medium text-gray-700 mb-2">Dose Number</label>
                                <input type="number" wire:model="immunization.dose_number" id="dose_number"
                                    placeholder="Enter dose number (e.g. 1, 2, 3)"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('immunization.dose_number') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                                <label for="manufacturer" class="block text-sm font-medium text-gray-700 mb-2">Manufacturer</label>
                                <input type="text" wire:model="immunization.manufacturer" id="manufacturer"
                                    placeholder="Enter vaccine manufacturer"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out">
                                @error('immunization.manufacturer') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg shadow-inner col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                                <textarea wire:model="immunization.notes" id="notes" rows="4"
                                    placeholder="Enter any reactions, batch number or additional information"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"></textarea>
                                @error('immunization.notes') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 italic">
                            <span class="text-red-600">*</span> Required fields
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('creatingImmunization', false)" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="flex justify-end space-x-4 mb-4">
            <button type="button" wire:click="$set('creatingImmunization', true)" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Immunization History
            </button>

            <button type="button" wire:click="$set('creatingPastCondition', true)" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-medium rounded-md shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Past Condition
            </button>
        </div>

        <div class="overflow-x-auto">
            <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Patient</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date Created</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                        $merged = $patient->pastConditions()
                            ->get()
                            ->concat($patient->immunizations()->get())
                            ->sortByDesc('created_at');
                        @endphp

                        @forelse ($merged as $record)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($record->type() == 'Past Condition')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            {{ $record->type() }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            {{ $record->type() }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 flex items-center">
                                        @if($record->type() == 'Past Condition')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        @endif
                                        {{ $record->name() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 text-gray-700">
                                                {{ substr($record->patient->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $record->patient->name }}</div>
                                            <div class="text-xs text-gray-500">Patient ID: {{ $record->patient->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $record->created_at->format('M d, Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button" @if($record->type() === 'Past Condition') wire:click="$set('selectedPastCondition', {{ $record }})" @else wire:click="$set('selectedImmunization', {{ $record }})" @endif class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 italic">
                                    No medical history records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>