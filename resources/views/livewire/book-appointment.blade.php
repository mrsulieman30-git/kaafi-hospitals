@php
    $getLocalizedString = function($field) {
        if (empty($field)) return '';
        if (is_array($field)) return $field['en'] ?? ($field['so'] ?? 'Unknown');
        if (is_string($field) && str_starts_with(trim($field), '{')) {
            $decoded = json_decode($field, true);
            return $decoded['en'] ?? ($decoded['so'] ?? $field);
        }
        return $field;
    };
@endphp

<div class="bg-gray-50 min-h-screen py-16 font-sans">
    <div class="container mx-auto px-4 max-w-3xl">
        
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-[#003B73] p-8 text-center text-white">
                <h1 class="text-3xl font-black tracking-tight mb-2">Book an Appointment</h1>
                <p class="text-blue-200 font-medium">Fill out the form below and we will confirm your visit.</p>
            </div>

            <div class="p-8 md:p-12">
                @if($successMessage)
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-r-xl mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <x-heroicon-s-check-circle class="w-6 h-6 text-emerald-500" />
                            <h3 class="font-black text-emerald-800 text-lg">Booking Successful!</h3>
                        </div>
                        <p class="text-emerald-700 font-medium">{{ $successMessage }}</p>
                    </div>
                @endif

                <form wire:submit.prevent="submitAppointment" class="space-y-6">
                    
                    <!-- Select Doctor -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Select Specialist</label>
                        <select wire:model="doctor_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
                            <option value="">-- Choose a Doctor --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">{{ $getLocalizedString($doc->name) }} ({{ $doc->department ? $getLocalizedString($doc->department->name) : 'General' }})</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date & Time Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Preferred Date</label>
                            <input type="date" wire:model="appointment_date" required min="{{ date('Y-m-d') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
                            @error('appointment_date') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Preferred Time</label>
                            <input type="time" wire:model="appointment_time" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
                            @error('appointment_time') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Patient Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Patient Full Name</label>
                            <input type="text" wire:model="patient_name" placeholder="John Doe" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
                            @error('patient_name') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" wire:model="patient_phone" placeholder="090 885 4328" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
                            @error('patient_phone') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#0062B8] text-white font-black text-lg py-4 rounded-xl shadow-lg hover:bg-[#003B73] hover:shadow-xl transition-all transform hover:-translate-y-1">
                            Confirm Appointment Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
