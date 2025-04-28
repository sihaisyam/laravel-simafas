<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Rental Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="rentalTransactionForm({{ Js::from([
        'transaction' => $transaction,
        'facilities' => $facilities,
        'existingDetails' => $transaction->rentalDetails->map(function($detail) {
            return [
                'id' => $detail->id,
                'facility_id' => $detail->facility_id,
                'duration' => $detail->durasi_jam,
                'start_date' => $detail->tanggal_mulai->format('Y-m-d\TH:i'),
                'end_date' => $detail->tanggal_selesai->format('Y-m-d\TH:i'),
                'catatan_tambahan' => $detail->catatan_tambahan,
                'subtotal' => $detail->harga_per_jam * $detail->durasi_jam
            ];
        })
    ]) }})">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('rental-transactions.update', $transaction->id) }}" @submit.prevent="submitForm">
                        @csrf
                        @method('PUT')

                        <!-- Customer Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Customer Name -->
                            <div>
                                <x-input-label for="name" :value="__('Customer Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                                    x-model="formData.name" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" 
                                    x-model="formData.phone" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Rental Details Section -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('Rental Facilities') }}
                            </h3>

                            <!-- Facility Addition Form -->
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end mb-4">
                                <!-- Facility Selection -->
                                <div>
                                    <x-input-label for="facility_id" :value="__('Facility')" />
                                    <select id="facility_id" x-model="newFacility.facility_id" 
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                        <option value="">Select Facility</option>
                                        <template x-for="facility in facilitiesData" :key="facility.id">
                                            <option :value="facility.id" :data-price="facility.hourly_rate"
                                                x-text="`${facility.name} (Rp${formatNumber(facility.hourly_rate)}/hour)`">
                                            </option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Duration (Hours) -->
                                <div>
                                    <x-input-label for="duration" :value="__('Hours')" />
                                    <x-text-input type="number" x-model="newFacility.duration" min="1" value="1" 
                                        class="block mt-1 w-full" />
                                </div>

                                <!-- Start Date -->
                                <div>
                                    <x-input-label for="start_date" :value="__('Start Date')" />
                                    <x-text-input type="datetime-local" x-model="newFacility.start_date" 
                                        class="block mt-1 w-full" />
                                </div>

                                <!-- End Date -->
                                <div>
                                    <x-input-label for="end_date" :value="__('End Date')" />
                                    <x-text-input type="datetime-local" x-model="newFacility.end_date" 
                                        class="block mt-1 w-full" />
                                </div>

                                <!-- Additional Notes -->
                                <div>
                                    <x-input-label for="notes" :value="__('Notes')" />
                                    <x-text-input type="text" x-model="newFacility.catatan_tambahan" 
                                        class="block mt-1 w-full" placeholder="Optional notes" />
                                </div>

                                <!-- Add Button -->
                                <div>
                                    <button type="button" @click="addFacility" 
                                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Facilities Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Facility</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Start</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">End</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Notes</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <template x-for="(facility, index) in formData.facilities" :key="index">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span x-text="getFacilityName(facility.facility_id)"></span>
                                                    <input type="hidden" x-bind:name="`facilities[${index}][id]`" x-model="facility.id">
                                                    <input type="hidden" x-bind:name="`facilities[${index}][facility_id]`" x-model="facility.facility_id">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span x-text="facility.duration"></span> hours
                                                    <input type="hidden" x-bind:name="`facilities[${index}][durasi_jam]`" x-model="facility.duration">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span x-text="facility.start_date"></span>
                                                    <input type="hidden" x-bind:name="`facilities[${index}][tanggal_mulai]`" x-model="facility.start_date">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span x-text="facility.end_date"></span>
                                                    <input type="hidden" x-bind:name="`facilities[${index}][tanggal_selesai]`" x-model="facility.end_date">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span x-text="facility.catatan_tambahan || '-'"></span>
                                                    <input type="hidden" x-bind:name="`facilities[${index}][catatan_tambahan]`" x-model="facility.catatan_tambahan">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap" x-text="'Rp' + formatNumber(facility.subtotal)"></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <button type="button" @click="removeFacility(index)" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                        Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                        <tr x-show="formData.facilities.length === 0">
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                No facilities added yet
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total Cost -->
                            <div class="mt-4 flex justify-end">
                                <div class="w-64">
                                    <x-input-label for="total_biaya" :value="__('Total Cost')" />
                                    <x-text-input id="total_biaya" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" 
                                        type="text" name="total_biaya" x-model="'Rp' + formatNumber(totalCost)" readonly />
                                    <x-input-error :messages="$errors->get('total_biaya')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-danger-link-button class="ms-4" :href="route('rental-transactions.index')">
                                {{ __('Cancel') }}
                            </x-danger-link-button>
                            <x-primary-button class="ms-4" type="submit">
                                {{ __('Update Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function rentalTransactionForm(data = null) {
            return {
                facilitiesData: data ? data.facilities : [],
                
                formData: {
                    name: data?.transaction?.name || '',
                    phone: data?.transaction?.phone || '',
                    facilities: data?.existingDetails ? data.existingDetails.map(detail => ({
                        id: detail.id,
                        facility_id: detail.facility_id,
                        duration: detail.duration,
                        start_date: detail.start_date,
                        end_date: detail.end_date,
                        catatan_tambahan: detail.catatan_tambahan,
                        subtotal: detail.subtotal
                    })) : []
                },
                
                newFacility: {
                    facility_id: '',
                    duration: 1,
                    start_date: '',
                    end_date: '',
                    catatan_tambahan: '',
                    subtotal: 0
                },
                
                get totalCost() {
                    return this.formData.facilities.reduce((sum, facility) => sum + facility.subtotal, 0);
                },
                
                getFacilityName(id) {
                    const facility = this.facilitiesData.find(f => f.id == id);
                    return facility ? facility.name : '';
                },
                
                getFacilityPrice(id) {
                    const facility = this.facilitiesData.find(f => f.id == id);
                    return facility ? facility.hourly_rate : 0;
                },
                
                formatNumber(amount) {
                    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                },
                
                addFacility() {
                    if (!this.newFacility.facility_id || !this.newFacility.start_date || !this.newFacility.end_date) {
                        alert('Please fill all required facility fields');
                        return;
                    }
                    
                    const price = this.getFacilityPrice(this.newFacility.facility_id);
                    this.formData.facilities.push({
                        id: null, // New facility won't have an ID
                        facility_id: this.newFacility.facility_id,
                        duration: parseInt(this.newFacility.duration),
                        start_date: this.newFacility.start_date,
                        end_date: this.newFacility.end_date,
                        catatan_tambahan: this.newFacility.catatan_tambahan,
                        subtotal: price * parseInt(this.newFacility.duration)
                    });
                    
                    // Reset new facility form
                    this.newFacility = {
                        facility_id: '',
                        duration: 1,
                        start_date: '',
                        end_date: '',
                        catatan_tambahan: '',
                        subtotal: 0
                    };
                },
                
                removeFacility(index) {
                    this.formData.facilities.splice(index, 1);
                },
                
                submitForm() {
                    // Set the total_biaya value before submitting
                    document.querySelector('input[name="total_biaya"]').value = this.totalCost;
                    this.$el.submit();
                }
            }
        }
    </script>
</x-app-layout>