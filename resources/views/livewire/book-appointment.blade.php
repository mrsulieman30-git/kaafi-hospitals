<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-4">{{ __('Book Appointment') }}</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ __('Providing world-class healthcare with a personalized touch. Select a specialist to begin.') }}
            </p>
        </div>

        @if($successMessage)
            <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm animate-bounce">
                <div class="flex items-center">
                    <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold">{{ $successMessage }}</span>
                </div>
            </div>
        @endif

        <!-- Step Indicator -->
        <div class="mb-12">
            <div class="flex items-center justify-between max-w-3xl mx-auto relative">
                <!-- Line -->
                <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 -translate-y-1/2 z-0"></div>
                <div class="absolute left-0 top-1/2 h-1 bg-blue-600 -translate-y-1/2 z-0 transition-all duration-500" style="width: {{ ($currentStep - 1) * 33.33 }}%"></div>

                @foreach([1, 2, 4] as $step)
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300 {{ $currentStep >= $step ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-200 text-gray-500' }}">
                            @if($currentStep > $step)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $loop->index + 1 }}
                            @endif
                        </div>
                        <span class="text-xs mt-2 font-medium {{ $currentStep >= $step ? 'text-blue-700' : 'text-gray-400' }}">
                            {{ $step == 1 ? __('Doctor') : ($step == 2 ? __('Date & Time') : __('Information')) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Step 1: Doctor Selection -->
        @if($currentStep == 1)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 animate-fade-in">
                @foreach($this->doctors as $doctor)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100 group">
                        <div class="relative h-64">
                            <img src="{{ $doctor->display_image }}" alt="{{ $doctor->localized_name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <button wire:click="selectDoctor({{ $doctor->id }})" class="w-full py-3 bg-white text-blue-900 font-bold rounded-xl shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    {{ __('Select') }}
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full uppercase tracking-wider">
                                    {{ $doctor->department ? $doctor->department->localized_name : __('Specialist') }}
                                </span>
                                <div class="flex items-center text-yellow-500">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    <span class="ml-1 text-sm font-bold text-gray-700">{{ number_format($doctor->rating, 1) }}</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 mb-1">{{ $doctor->localized_name }}</h3>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $doctor->localized_title }}</p>
                            <button wire:click="selectDoctor({{ $doctor->id }})" class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md md:hidden">
                                {{ __('Select') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Step 2: Date Selection -->
        @if($currentStep == 2)
            <div class="max-w-4xl mx-auto animate-fade-in">
                <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                    <div class="flex items-center mb-8">
                        <button wire:click="goToStep(1)" class="p-2 bg-gray-100 rounded-full text-gray-600 hover:bg-blue-600 hover:text-white transition-all mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <div>
                            <h2 class="text-2xl font-extrabold text-blue-900">{{ __('Select Date') }}</h2>
                            <p class="text-gray-500">{{ __('Booking with') }}: <span class="font-bold text-blue-600">{{ $this->selectedDoctor->localized_name }}</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
                        @foreach($this->availableDates as $date)
                            <button wire:click="selectDate('{{ $date['date'] }}')" 
                                class="flex flex-col items-center p-4 rounded-2xl border-2 transition-all duration-300 {{ $selectedDate == $date['date'] ? 'border-blue-600 bg-blue-50 shadow-inner' : 'border-gray-100 bg-gray-50 hover:border-blue-300 hover:bg-white' }}">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-tighter">{{ $date['month'] }}</span>
                                <span class="text-3xl font-black text-blue-900 my-1">{{ $date['day'] }}</span>
                                <span class="text-xs font-medium text-gray-500">{{ $date['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 4: Patient Info Form -->
        @if($currentStep == 4)
            <div class="max-w-3xl mx-auto animate-fade-in">
                <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
                    <div class="flex items-center mb-8">
                        <button wire:click="goToStep(2)" class="p-2 bg-gray-100 rounded-full text-gray-600 hover:bg-blue-600 hover:text-white transition-all mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <h2 class="text-3xl font-black text-blue-900">{{ __('Patient Information') }}</h2>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Full Name') }}</label>
                            <input type="text" wire:model="patient_name" placeholder="{{ __('e.g. Ahmed Ali') }}" class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:border-blue-600 focus:bg-white focus:outline-none transition-all text-lg font-medium">
                            @error('patient_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Phone Number') }}</label>
                                <input type="tel" wire:model="patient_phone" placeholder="61XXXXXXX" class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:border-blue-600 focus:bg-white focus:outline-none transition-all text-lg font-medium">
                                @error('patient_phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Email (Optional)') }}</label>
                                <input type="email" wire:model="patient_email" placeholder="example@mail.com" class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:border-blue-600 focus:bg-white focus:outline-none transition-all text-lg font-medium">
                                @error('patient_email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Notes / Symptoms') }}</label>
                            <textarea wire:model="notes" rows="3" placeholder="{{ __('Briefly describe the reason for your visit...') }}" class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:border-blue-600 focus:bg-white focus:outline-none transition-all text-lg font-medium"></textarea>
                        </div>

                        <button wire:click="proceedToSummary" class="w-full py-5 bg-blue-600 text-white text-xl font-black rounded-2xl hover:bg-blue-700 transition-all shadow-xl transform hover:-translate-y-1 active:translate-y-0">
                            {{ __('Confirm Appointment') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Time Selection Modal -->
        @if($showTimeModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('showTimeModal', false)"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full animate-pop-in">
                        <div class="bg-white px-8 pt-8 pb-4">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-black text-blue-900">{{ __('Select Time') }}</h3>
                                <button wire:click="$set('showTimeModal', false)" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <p class="text-gray-500 mb-6">
                                {{ __('Available slots for') }} <span class="font-bold text-blue-600">{{ Carbon::parse($selectedDate)->format('M d, Y') }}</span>
                            </p>

                            @if(count($this->availableTimes) > 0)
                                <div class="grid grid-cols-3 gap-3 mb-8">
                                    @foreach($this->availableTimes as $time)
                                        <button wire:click="selectTime('{{ $time }}')" 
                                            class="py-3 px-4 rounded-xl border-2 border-gray-100 bg-gray-50 text-blue-900 font-bold hover:border-blue-600 hover:bg-blue-50 transition-all">
                                            {{ $time }}
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-500 font-medium">{{ __('No available time slots. Please select another date.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Final Summary Modal -->
        @if($showSummaryModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('showSummaryModal', false)"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full animate-pop-in">
                        <div class="p-10">
                            <h3 class="text-3xl font-black text-blue-900 mb-8 border-b-2 border-gray-100 pb-4">{{ __('Appointment Summary') }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">{{ __('Doctor') }}</h4>
                                    <div class="flex items-center">
                                        <img src="{{ $this->selectedDoctor->display_image }}" class="w-16 h-16 rounded-full object-cover border-4 border-blue-100 mr-4">
                                        <div>
                                            <p class="font-bold text-blue-900">{{ $this->selectedDoctor->localized_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $this->selectedDoctor->department->localized_name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">{{ __('Date & Time') }}</h4>
                                    <div class="p-4 bg-blue-50 rounded-2xl border-2 border-blue-100">
                                        <p class="font-black text-blue-900 text-lg">{{ Carbon::parse($selectedDate)->format('l, M d') }}</p>
                                        <p class="font-bold text-blue-600">{{ $selectedTime }}</p>
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">{{ __('Patient Details') }}</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <p class="text-gray-600"><span class="font-bold text-gray-900">{{ __('Name') }}:</span> {{ $patient_name }}</p>
                                        <p class="text-gray-600"><span class="font-bold text-gray-900">{{ __('Phone') }}:</span> {{ $patient_phone }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <button wire:click="$set('showSummaryModal', false)" class="flex-1 py-4 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition-all">
                                    {{ __('Edit Details') }}
                                </button>
                                <button wire:click="confirmAppointment" class="flex-1 py-4 bg-green-600 text-white font-black rounded-2xl hover:bg-green-700 transition-all shadow-lg">
                                    {{ __('Confirm & Submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <style>
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        .animate-pop-in { animation: popIn 0.3s cubic-bezier(0.26, 0.53, 0.74, 1.48); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes popIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        .tracking-tighter { letter-spacing: -0.05em; }
    </style>
</div>
