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
                    <div wire:click="selectDoctor({{ $doc->id }})" class="cursor-pointer border rounded-lg p-3 flex items-center transition {{ $doctor_id === $doc->id ? 'border-kaafi-blue bg-blue-50 ring-1 ring-kaafi-blue' : 'border-gray-200 hover:border-blue-300' }}">
                        <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden mr-3">
                            <img src="{{ $doc->image ? asset('storage/' . $doc->image) : 'https://ui-avatars.com/api/?name='.urlencode($doc->name) }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">{{ $doc->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $doc->department->name ?? 'General' }}</p>
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 {{ $step !== 2 ? 'opacity-60 grayscale pointer-events-none' : '' }}">
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
                            <input type="text" wire:model="patient_phone" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" placeholder="09088..." {{ $step !== 2 ? 'disabled' : '' }}>
                            @error('patient_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" wire:model="patient_email" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" placeholder="Optional" {{ $step !== 2 ? 'disabled' : '' }}>
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
                        <label class="block text-xs font-medium text-gray-700 mb-1">Additional Notes</label>
                        <textarea wire:model="notes" rows="2" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-kaafi-blue bg-transparent" placeholder="Symptoms or requests..." {{ $step !== 2 ? 'disabled' : '' }}></textarea>
                    </div>
                    
                    @if($step === 2)
                        <div class="flex space-x-3 mt-4">
                            <button wire:click="prevStep" class="flex-1 bg-gray-100 text-gray-800 py-3 rounded-md font-medium hover:bg-gray-200 transition">Back</button>
                            <button wire:click="nextStep" class="flex-1 bg-[#003B73] text-white py-3 rounded-md font-medium hover:bg-[#0062B8] transition">Continue to Schedule</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Step 3: Select Date & Time Right Column -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-full {{ $step !== 3 ? 'opacity-60 grayscale pointer-events-none' : '' }}">
                <h3 class="text-lg font-bold text-kaafi-navy mb-6">3. Select Date & Time</h3>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Calendar -->
                    <div class="border rounded-lg p-4 bg-gray-50/50">
                        <div class="flex justify-between items-center mb-4">
                            <button wire:click="prevMonth" class="text-gray-400 hover:text-[#0062B8] p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                            <span class="font-bold text-gray-800">{{ \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1)->format('F Y') }}</span>
                            <button wire:click="nextMonth" class="text-gray-400 hover:text-[#0062B8] p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 mb-2">
                            <div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div><div>SUN</div>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-sm">
                            <!-- Empty Days Offset -->
                            @for($i = 0; $i < ($firstDayOfWeek - 1); $i++)
                                <div class="p-2"></div>
                            @endfor
                            
                            <!-- Actual Days -->
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php 
                                    $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                                    $isPast = $dateStr < date('Y-m-d');
                                    $isSelected = $selectedDate === $dateStr;
                                @endphp
                                <div wire:click="{{ !$isPast ? "selectDate('$dateStr')" : "" }}" 
                                     class="p-2 rounded-lg cursor-pointer font-medium transition-colors {{ $isPast ? 'text-gray-300 cursor-not-allowed' : 'hover:bg-blue-100 text-gray-700' }} {{ $isSelected ? 'bg-[#003B73] text-white hover:bg-[#003B73]' : '' }}">
                                    {{ $day }}
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Time Slots -->
                    <div>
                        <h4 class="font-bold text-gray-800 mb-4 pb-2 border-b">
                            @if($selectedDate)
                                {{ \Carbon\Carbon::parse($selectedDate)->format('l, d M Y') }}
                            @else
                                Select a date
                            @endif
                        </h4>
                        
                        @if($selectedDate)
                            @if(count($availableSlots) > 0)
                                <div class="grid grid-cols-2 gap-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($availableSlots as $slot)
                                    <button wire:click="selectTime('{{ $slot }}')" class="border rounded-lg py-2 text-sm text-center font-bold transition {{ $selectedTime === $slot ? 'bg-[#0062B8] border-[#0062B8] text-white shadow-md' : 'border-gray-200 text-gray-700 hover:border-[#0062B8] hover:text-[#0062B8]' }}">
                                        {{ $slot }}
                                    </button>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-10 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-sm text-gray-500">No available slots for this date.<br>Please select another day.</p>
                                </div>
                            @endif
                            @error('selectedTime') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        @else
                            <div class="flex items-center justify-center h-48 border-2 border-dashed border-gray-200 rounded-xl text-gray-400 bg-gray-50">
                                Pick a date from the calendar
                            </div>
                        @endif
                        
                        @if($step === 3)
                        <div class="mt-8 flex space-x-3">
                            <button wire:click="prevStep" class="flex-1 bg-gray-100 text-gray-800 py-3 rounded-lg font-bold hover:bg-gray-200 transition">Back</button>
                            <button wire:click="nextStep" class="flex-[2] bg-[#28A745] text-white py-3 rounded-lg font-bold hover:bg-green-600 transition shadow-lg shadow-green-500/30 {{ !$selectedTime ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !$selectedTime ? 'disabled' : '' }}>
                                Confirm Appointment
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Step 4: Confirmation -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-12 text-center max-w-2xl mx-auto transform transition-all hover:scale-[1.02]">
        <div class="w-24 h-24 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h2 class="text-3xl font-black text-[#003B73] mb-4">Request Confirmed!</h2>
        <p class="text-lg text-gray-600 mb-8">Thank you, <span class="font-bold">{{ $patient_name }}</span>. Your appointment request has been securely sent to our reception desk.</p>
        
        <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8 border border-gray-100">
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center"><span class="text-gray-500">Date & Time:</span> <span class="font-bold text-gray-900 text-base">{{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}, {{ $selectedTime }}</span></div>
                <div class="flex justify-between items-center"><span class="text-gray-500">Doctor:</span> <span class="font-bold text-[#0062B8]">{{ App\Models\Doctor::find($doctor_id)->name ?? 'General' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-gray-500">Status:</span> <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full font-bold text-xs uppercase tracking-wider">Pending Review</span></div>
            </div>
        </div>
        
        <p class="text-sm text-gray-500 mb-8">You can log into the Patient Portal anytime using your phone number to check your status.</p>
        
        <a href="/portal" class="inline-block bg-[#003B73] text-white px-8 py-4 rounded-xl font-bold hover:bg-[#0062B8] transition shadow-lg">Access Patient Portal</a>
    </div>
    @endif
</div>