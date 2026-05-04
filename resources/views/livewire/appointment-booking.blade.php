<div>
    @if($step < 4)
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Steps 1 & 2 Left Column -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Step 1: Select Doctor -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 {{ $step !== 1 ? 'opacity-60 grayscale' : '' }}">
                <h3 class="text-lg font-bold text-kaafi-navy mb-4">1. Select Doctor</h3>
                <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2">
                    @foreach($doctors as $doc)
                    <div wire:click="selectDoctor({{ $doc->id }})" class="cursor-pointer border rounded-lg p-3 flex items-center {{ $doctor_id === $doc->id ? 'border-kaafi-blue bg-blue-50 ring-1 ring-kaafi-blue' : 'border-gray-200 hover:border-blue-300' }}">
                        <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden mr-3">
                            <img src="https://i.pravatar.cc/100?img={{ $doc->id + 10 }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">{{ $doc->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $doc->title }}</p>
                        </div>
                        @if($doctor_id === $doc->id)
                        <div class="ml-auto text-kaafi-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @error('doctor_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Step 2: Patient Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 {{ $step !== 2 ? 'opacity-60 grayscale' : '' }}">
                <h3 class="text-lg font-bold text-kaafi-navy mb-4">2. Patient Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Patient Name *</label>
                        <input type="text" wire:model="patient_name" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" placeholder="Enter patient name" {{ $step !== 2 ? 'disabled' : '' }}>
                        @error('patient_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Mobile Number *</label>
                            <input type="text" wire:model="patient_phone" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" placeholder="Enter mobile number" {{ $step !== 2 ? 'disabled' : '' }}>
                            @error('patient_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" wire:model="patient_email" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" placeholder="Enter email address" {{ $step !== 2 ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Department *</label>
                        <select wire:model="department_id" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" {{ $step !== 2 ? 'disabled' : '' }}>
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Additional Notes (Optional)</label>
                        <textarea wire:model="notes" rows="2" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" placeholder="Type your message" {{ $step !== 2 ? 'disabled' : '' }}></textarea>
                    </div>
                    
                    @if($step === 1)
                        <button wire:click="nextStep" class="w-full bg-kaafi-navy text-white py-3 rounded-md font-medium mt-4 hover:bg-gray-800 transition">Continue to Details</button>
                    @elseif($step === 2)
                        <div class="flex space-x-3 mt-4">
                            <button wire:click="prevStep" class="flex-1 bg-gray-100 text-gray-800 py-3 rounded-md font-medium hover:bg-gray-200 transition">Back</button>
                            <button wire:click="nextStep" class="flex-1 bg-kaafi-navy text-white py-3 rounded-md font-medium hover:bg-gray-800 transition">Continue to Schedule</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Step 3: Select Date & Time Right Column -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-full {{ $step !== 3 ? 'opacity-60 grayscale' : '' }}">
                <h3 class="text-lg font-bold text-kaafi-navy mb-6">3. Select Date & Time</h3>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Calendar -->
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <button class="text-gray-400 hover:text-kaafi-blue">&lt;</button>
                            <span class="font-bold text-gray-800">{{ date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) }}</span>
                            <button class="text-gray-400 hover:text-kaafi-blue">&gt;</button>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 mb-2">
                            <div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div><div>SUN</div>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-sm">
                            @for($i = 0; $i < ($firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1); $i++)
                                <div class="p-2 text-gray-300"></div>
                            @endfor
                            
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php 
                                    $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                                    $isPast = $dateStr < date('Y-m-d');
                                    $isSelected = $selectedDate === $dateStr;
                                @endphp
                                <div wire:click="{{ !$isPast && $step === 3 ? "selectDate('$dateStr')" : "" }}" 
                                     class="p-2 rounded-full cursor-pointer relative {{ $isPast ? 'text-gray-300' : 'hover:bg-blue-50' }} {{ $isSelected ? 'bg-kaafi-navy text-white hover:bg-kaafi-navy' : 'text-gray-700' }}">
                                    {{ $day }}
                                    @if(!$isPast && $day % 3 === 0)
                                        <div class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 rounded-full {{ $isSelected ? 'bg-white' : 'bg-kaafi-blue' }}"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Time Slots -->
                    <div>
                        <h4 class="font-bold text-gray-800 mb-4">
                            @if($selectedDate)
                                {{ date('l, d M Y', strtotime($selectedDate)) }}
                            @else
                                Select a date to see slots
                            @endif
                        </h4>
                        
                        @if($selectedDate)
                        <div class="grid grid-cols-2 gap-3 max-h-[300px] overflow-y-auto pr-2">
                            @foreach($availableSlots as $slot)
                            <button wire:click="selectTime('{{ $slot }}')" class="border rounded-md py-2 text-sm text-center font-medium transition {{ $selectedTime === $slot ? 'bg-kaafi-navy border-kaafi-navy text-white' : 'border-gray-300 text-gray-700 hover:border-kaafi-blue hover:text-kaafi-blue' }}" {{ $step !== 3 ? 'disabled' : '' }}>
                                {{ $slot }}
                            </button>
                            @endforeach
                        </div>
                        @error('selectedTime') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        @else
                        <div class="flex items-center justify-center h-48 border-2 border-dashed border-gray-200 rounded-lg text-gray-400">
                            Please select a date from the calendar
                        </div>
                        @endif
                        
                        @if($step === 3)
                        <div class="mt-6 flex space-x-3">
                            <button wire:click="prevStep" class="flex-1 bg-gray-100 text-gray-800 py-3 rounded-md font-medium hover:bg-gray-200 transition">Back</button>
                            <button wire:click="nextStep" class="flex-1 bg-kaafi-green text-white py-3 rounded-md font-medium hover:bg-green-600 transition shadow-md">Confirm Booking</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Step 4: Confirmation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center max-w-3xl mx-auto">
        <div class="w-20 h-20 bg-green-100 text-kaafi-green rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h2 class="text-3xl font-bold text-kaafi-navy mb-4">Appointment Request Sent!</h2>
        <p class="text-lg text-gray-600 mb-8">Thank you, {{ $patient_name }}. Your appointment request for {{ date('l, d M Y', strtotime($selectedDate)) }} at {{ $selectedTime }} has been received.</p>
        
        <div class="bg-gray-50 rounded-lg p-6 text-left mb-8 max-w-md mx-auto border border-gray-200">
            <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Appointment Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Patient:</span> <span class="font-medium text-gray-900">{{ $patient_name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Phone:</span> <span class="font-medium text-gray-900">{{ $patient_phone }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Date & Time:</span> <span class="font-medium text-gray-900">{{ date('d M Y', strtotime($selectedDate)) }}, {{ $selectedTime }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status:</span> <span class="font-medium text-yellow-600">Pending Confirmation</span></div>
            </div>
        </div>
        
        <p class="text-gray-500 mb-8">Our reception team will contact you shortly to confirm your appointment. No online payment is required.</p>
        
        <a href="/" class="bg-kaafi-navy text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition">Return to Homepage</a>
    </div>
    @endif
</div>