@php
    $locale = app()->getLocale();
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap');
    
    .booking-container { font-family: 'Outfit', sans-serif; }
    .flatpickr-calendar { font-family: 'Outfit', sans-serif; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; padding: 15px; width: 100% !important; max-width: 380px; }
    .flatpickr-day.selected { background: #0062B8 !important; border-color: #0062B8 !important; border-radius: 50%; font-weight: 700; }
    .flatpickr-day.today { border-color: #0062B8; color: #0062B8; font-weight: 700; }
    .flatpickr-day:hover { background: #f1f5f9; border-color: transparent; border-radius: 50%; }
    .flatpickr-months .flatpickr-month { height: 40px; }
    .flatpickr-current-month { font-weight: 700; font-size: 1.1rem; }
    .flatpickr-weekday { font-weight: 600; color: #94a3b8; }
    
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

    .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    .step-number { background: #e0f2fe; color: #0062B8; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 12px; font-weight: 800; }
    
    .doctor-card-selected { border-color: #0062B8; background-color: #F0F9FF; }
</style>

<div class="booking-container bg-[#F8FAFC] min-h-screen">
    {{-- Header Section --}}
    <div class="bg-white border-b border-gray-100 py-6 mb-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-[#003B73] tracking-tight">{{ __('Book an Appointment') }}</h1>
                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                        <a href="/" class="hover:text-[#0062B8] transition">{{ __('Home') }}</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="font-semibold text-[#0062B8]">{{ __('Book an Appointment') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm font-medium text-gray-500 bg-gray-50 px-4 py-2 rounded-full">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ __('Your information is secure & private') }}
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-7xl pb-16">
        @if($successMessage)
            <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-500">
                <div class="bg-gradient-to-br from-[#0062B8] to-[#003B73] p-12 text-center text-white">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-3xl font-black mb-4">{{ __('Appointment Confirmed!') }}</h2>
                    <p class="text-blue-100 text-lg font-medium opacity-90">{{ $successMessage }}</p>
                </div>
                <div class="p-8 text-center bg-gray-50 border-t border-gray-100">
                    <a href="/portal" class="inline-flex items-center gap-2 bg-[#0062B8] text-white px-10 py-4 rounded-2xl font-black hover:bg-[#003B73] transition shadow-lg transform hover:-translate-y-1">
                        {{ __('Go to Patient Portal') }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        @else
            <form wire:submit.prevent="submitAppointment" class="grid lg:grid-cols-12 gap-8 items-start">
                
                {{-- Left Column: Doctor & Patient Details (1/3 approx) --}}
                <div class="lg:col-span-5 space-y-8">
                    {{-- 1. Select Doctor --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="step-number">1</span>
                            <h2 class="text-xl font-bold text-[#003B73]">{{ __('Select Doctor') }}</h2>
                        </div>

                        <div x-data="{ open: false }" class="relative">
                            <div @click="open = !open" :class="open ? 'border-[#0062B8]' : 'border-gray-100'" class="cursor-pointer border-2 rounded-2xl p-5 hover:border-[#0062B8]/30 transition-all bg-gray-50/50 flex items-center gap-4 group">
                                @if($selectedDoctor)
                                    <div class="w-16 h-16 rounded-full border-2 border-white shadow-sm overflow-hidden flex-shrink-0">
                                        <img src="{{ $selectedDoctor->display_image }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 leading-tight group-hover:text-[#0062B8] transition-colors">{{ $selectedDoctor->localized_name }}</h3>
                                        <p class="text-sm text-gray-500 font-medium">{{ $selectedDoctor->localized_title }}</p>
                                        <div class="flex items-center gap-2 mt-1 text-[10px] text-blue-600 font-bold uppercase tracking-wider">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @php
                                                $schedules = $selectedDoctor->schedules()->where('is_active', true)->get();
                                                $days = $schedules->pluck('day_of_week')->flatten()->unique();
                                                $daysStr = $days->take(3)->map(fn($d) => substr($d, 0, 3))->implode(', ');
                                                
                                                // Get time range if possible
                                                $firstShift = $schedules->first();
                                                $timeRange = $firstShift ? \Carbon\Carbon::parse($firstShift->start_time)->format('g A') . ' - ' . \Carbon\Carbon::parse($firstShift->end_time)->format('g A') : '';
                                            @endphp
                                            {{ $daysStr }}{{ $days->count() > 3 ? '...' : '' }}
                                            @if($timeRange) | {{ $timeRange }} @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0 text-[#0062B8]">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-gray-400 font-medium">{{ __('Choose a specialist...') }}</span>
                                    </div>
                                @endif
                                <svg class="w-5 h-5 text-gray-400 transform transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>

                            {{-- Custom Dropdown --}}
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="absolute z-50 mt-3 w-full bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden max-h-80 overflow-y-auto custom-scrollbar">
                                <div class="p-3 bg-gray-50 border-b border-gray-100">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-2">{{ __('Available Doctors') }}</p>
                                </div>
                                @foreach($doctors as $doc)
                                    <div wire:key="doc-{{ $doc->id }}" 
                                        @click="open = false"
                                        wire:click="selectDoctor({{ $doc->id }})" 
                                        class="p-4 flex items-center gap-4 hover:bg-blue-50/50 cursor-pointer border-b border-gray-50 last:border-0 transition group">
                                        <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-transparent group-hover:border-[#0062B8]/20 transition-all">
                                            <img src="{{ $doc->display_image }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900 text-sm group-hover:text-[#0062B8] transition-colors">{{ $doc->localized_name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $doc->localized_title }}</p>
                                        </div>
                                        @if($doctor_id == $doc->id)
                                            <div class="text-[#0062B8]">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" id="doctor_id_hidden" value="{{ $doctor_id }}">
                        @error('doctor_id')<span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>@enderror
                    </div>

                    {{-- 2. Patient Details --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="step-number">2</span>
                            <h2 class="text-xl font-bold text-[#003B73]">{{ __('Patient Details') }}</h2>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.1em] mb-2">{{ __('Patient Name') }} <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                                    </span>
                                    <input type="text" wire:model="patient_name" placeholder="{{ __('Enter patient name') }}" class="w-full bg-gray-50 border-2 border-gray-50 rounded-2xl pl-11 pr-4 py-3.5 focus:bg-white focus:border-[#0062B8]/30 focus:ring-0 transition-all font-semibold text-gray-900 placeholder:text-gray-300">
                                </div>
                                @error('patient_name')<span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.1em] mb-2">{{ __('Mobile Number') }} <span class="text-red-400">*</span></label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"/></svg>
                                        </span>
                                        <input type="tel" wire:model="patient_phone" placeholder="090 000 0000" class="w-full bg-gray-50 border-2 border-gray-50 rounded-2xl pl-11 pr-4 py-3.5 focus:bg-white focus:border-[#0062B8]/30 focus:ring-0 transition-all font-semibold text-gray-900">
                                    </div>
                                    @error('patient_phone')<span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.1em] mb-2">{{ __('Email Address') }}</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"/></svg>
                                        </span>
                                        <input type="email" wire:model="patient_email" placeholder="example@email.com" class="w-full bg-gray-50 border-2 border-gray-50 rounded-2xl pl-11 pr-4 py-3.5 focus:bg-white focus:border-[#0062B8]/30 focus:ring-0 transition-all font-semibold text-gray-900">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.1em] mb-2">{{ __('Department') }} <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <select wire:model="department_id" class="w-full bg-gray-50 border-2 border-gray-50 rounded-2xl px-4 py-3.5 focus:bg-white focus:border-[#0062B8]/30 focus:ring-0 transition-all font-semibold text-gray-900 appearance-none">
                                        <option value="">-- {{ __('Select Department') }} --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->getLocalizedNameAttribute() }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                                @error('department_id')<span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.1em] mb-2">{{ __('Additional Notes (Optional)') }}</label>
                                <textarea wire:model="notes" rows="3" placeholder="{{ __('Type your message (optional)') }}" class="w-full bg-gray-50 border-2 border-gray-50 rounded-2xl px-4 py-3.5 focus:bg-white focus:border-[#0062B8]/30 focus:ring-0 transition-all font-semibold text-gray-900"></textarea>
                            </div>

                            <button type="button" @click="document.getElementById('schedule-section').scrollIntoView({behavior: 'smooth'})" class="w-full bg-[#003B73] text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-[#0062B8] transition-all shadow-xl shadow-blue-900/10 flex items-center justify-center gap-3 mt-4 group">
                                <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round"/></svg>
                                {{ __('Continue to Select Date & Time') }}
                            </button>
                            <p class="text-[10px] text-gray-400 text-center font-bold uppercase tracking-wider mt-2">* {{ __('Mandatory Fields') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Date & Time Selection (2/3 approx) --}}
                <div id="schedule-section" class="lg:col-span-7 bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sm:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="step-number">3</span>
                        <h2 class="text-xl font-bold text-[#003B73]">{{ __('Select Date & Time') }}</h2>
                    </div>

                    <div class="grid md:grid-cols-2 gap-10">
                        {{-- Calendar Section --}}
                        <div class="space-y-6">
                            <div x-data="{
                                fp: null,
                                allowedDays: @js($allowed_days),
                                init() {
                                    this.build();
                                    $wire.on('update-allowed-days', ({ days }) => {
                                        this.allowedDays = days || [];
                                        if(this.fp) {
                                            this.fp.set('disable', [
                                                (date) => {
                                                    if(!this.allowedDays || this.allowedDays.length === 0) return true;
                                                    const n = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                                                    return !this.allowedDays.includes(n[date.getDay()]);
                                                }
                                            ]);
                                            this.fp.clear();
                                        }
                                    });
                                    $wire.on('reset-calendar', () => { if(this.fp) this.fp.clear(); });
                                },
                                build() {
                                    this.fp = flatpickr(this.$refs.dp, {
                                        inline: true,
                                        minDate: 'today',
                                        dateFormat: 'Y-m-d',
                                        disable: [
                                            (date) => {
                                                if(!this.allowedDays || this.allowedDays.length === 0) return true;
                                                const n = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                                                return !this.allowedDays.includes(n[date.getDay()]);
                                            }
                                        ],
                                        onChange: (selectedDates, dateStr) => { $wire.selectDate(dateStr); }
                                    });
                                }
                            }" wire:ignore class="w-full flex justify-center md:block">
                                <input x-ref="dp" type="hidden" id="appointment_date">
                            </div>
                        </div>

                        {{-- Time Slots Section --}}
                        <div class="flex flex-col h-full">
                            <div class="mb-6 flex items-center justify-between border-b border-gray-100 pb-4">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">
                                        @if($appointment_date)
                                            {{ \Carbon\Carbon::parse($appointment_date)->format('l, d M Y') }}
                                        @else
                                            {{ __('Choose a Date') }}
                                        @endif
                                    </h4>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1 flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" stroke-linecap="round"/></svg>
                                        {{ __('Available Slots') }} 
                                        @if($selectedDoctor)
                                            <span class="text-blue-500">({{ $daysStr }})</span>
                                        @endif
                                    </p>
                                </div>
                                <div wire:loading wire:target="appointment_date,doctor_id">
                                    <svg class="animate-spin h-6 w-6 text-[#0062B8]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                            </div>

                            <div class="flex-1 min-h-[320px] max-h-[400px] overflow-y-auto pr-3 custom-scrollbar">
                                @if(!$doctor_id)
                                    <div class="flex flex-col items-center justify-center h-full text-center p-8 bg-gray-50/50 rounded-3xl border-2 border-dashed border-gray-100">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                                            <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                                        </div>
                                        <p class="text-sm text-gray-500 font-bold leading-relaxed">{{ __('Please select a specialist first to see their schedule.') }}</p>
                                    </div>
                                @elseif(!$appointment_date)
                                    <div class="flex flex-col items-center justify-center h-full text-center p-8 bg-gray-50/50 rounded-3xl border-2 border-dashed border-gray-100">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                                            <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                                        </div>
                                        <p class="text-sm text-gray-500 font-bold leading-relaxed">{{ __('Pick an available date from the calendar to view time slots.') }}</p>
                                    </div>
                                @elseif(count($available_times) > 0)
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 xl:grid-cols-3 gap-3">
                                        @foreach($available_times as $time)
                                            <button type="button" wire:click="selectTime('{{ $time }}')" 
                                                class="group relative py-3 rounded-2xl text-xs font-black border transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl
                                                {{ $appointment_time === $time ? 'bg-[#003B73] border-[#003B73] text-white shadow-blue-900/20' : 'bg-white border-gray-100 text-gray-600 hover:border-[#0062B8]/30 hover:text-[#0062B8]' }}">
                                                {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                                                @if($appointment_time === $time)
                                                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                                                    </span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-center p-8 bg-red-50/30 rounded-3xl border-2 border-dashed border-red-100">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                                            <svg class="w-8 h-8 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                                        </div>
                                        <p class="text-sm text-gray-500 font-bold leading-relaxed">{{ __('No slots available for this date.') }}<br><span class="text-red-400 font-black">{{ __('Try another day') }}</span></p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-50 flex items-center gap-4">
                                <div class="flex-1 bg-blue-50 px-5 py-3 rounded-2xl flex items-center gap-3">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5"/></svg>
                                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">{{ __('Note: Appointment duration is 30 minutes.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-4 bg-gray-50 px-6 py-4 rounded-3xl">
                            <div class="p-2 bg-white rounded-xl shadow-sm text-emerald-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2"/></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-black text-gray-900 uppercase tracking-widest">{{ __('Security Guaranteed') }}</h5>
                                <p class="text-[10px] text-gray-400 font-bold">{{ __('Your data is encrypted and HIPAA compliant.') }}</p>
                            </div>
                        </div>
                        <button type="submit" class="bg-[#0062B8] text-white px-12 py-5 rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-[#003B73] transition-all shadow-2xl shadow-blue-900/20 transform hover:-translate-y-1 flex items-center gap-4 disabled:opacity-50 disabled:cursor-not-allowed group" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitAppointment">{{ __('Confirm Booking') }}</span>
                            <span wire:loading wire:target="submitAppointment">{{ __('Processing...') }}</span>
                            <svg wire:loading.remove wire:target="submitAppointment" class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Feature Highlights --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">
                @foreach([
                    ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Easy Scheduling', 'desc' => 'Book appointments in just a few clicks'],
                    ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'title' => 'Expert Doctors', 'desc' => 'Consult with our experienced specialists'],
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Secure & Private', 'desc' => 'Your information is 100% confidential'],
                    ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title' => '24/7 Support', 'desc' => "We're here to help you anytime, anywhere"]
                ] as $item)
                    <div class="bg-white/60 backdrop-blur-sm border border-white/50 p-6 rounded-3xl flex items-center gap-5 hover:bg-white transition-all hover:shadow-xl group">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-[#0062B8] group-hover:bg-[#0062B8] group-hover:text-white transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="{{ $item['icon'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-gray-900 text-sm tracking-tight">{{ __($item['title']) }}</h4>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">{{ __($item['desc']) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
