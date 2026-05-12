@php
    $locale = app()->getLocale();
    $getLocalizedString = function($field) use ($locale) {
        if (empty($field)) return '';
        if (is_array($field)) return $field[$locale] ?? ($field['en'] ?? ($field['so'] ?? 'Unknown'));
        if (is_string($field) && str_starts_with(trim($field), '{')) {
            $decoded = json_decode($field, true);
            return $decoded[$locale] ?? ($decoded['en'] ?? ($decoded['so'] ?? $field));
        }
        return $field;
    };
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar { font-family: inherit; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,.05); border: 1px solid #f3f4f6; padding: 10px; width: 100%; }
    .flatpickr-day.selected { background: #0062B8 !important; border-color: #0062B8 !important; font-weight: bold; }
    .flatpickr-day.flatpickr-disabled { color: #d1d5db !important; text-decoration: line-through; }
</style>

<div class="bg-gray-50 min-h-screen py-12 font-sans">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-[#003B73] tracking-tight mb-3">{{ __('Book an Appointment') }}</h1>
            <p class="text-gray-500 font-medium max-w-xl mx-auto">{{ __('Experience seamless healthcare scheduling. Select your specialist, choose a convenient time, and confirm your visit instantly.') }}</p>
        </div>

        @if($successMessage)
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 p-10 text-center transform transition-all mb-10">
            <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-3">{{ __('Booking Confirmed!') }}</h2>
            <p class="text-emerald-600 font-medium mb-6 bg-emerald-50 py-3 px-4 rounded-xl inline-block">{{ $successMessage }}</p>
            <div>
                <a href="/portal" class="inline-block bg-[#003B73] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#0062B8] transition shadow-lg">{{ __('Access Patient Portal') }}</a>
            </div>
        </div>
        @else

        <form wire:submit.prevent="submitAppointment" class="grid lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-[#0062B8] text-xs">1</span>
                        <label for="doctor_id">{{ __('Select Specialist') }}</label>
                    </h3>
                    <div class="relative">
                        <select id="doctor_id" name="doctor_id" wire:model.live="doctor_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium appearance-none">
                            <option value="">-- {{ __('Choose a Doctor') }} --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">{{ $getLocalizedString($doc->name) }} ({{ $doc->department ? $getLocalizedString($doc->department->name) : 'General' }})</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('doctor_id')<span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>@enderror
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-[#0062B8] text-xs">2</span>
                        {{ __('Patient Information') }}
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="patient_name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">{{ __('Full Name') }}</label>
                            <input type="text" id="patient_name" name="patient_name" wire:model="patient_name" placeholder="{{ __('e.g. Ali Hassan') }}" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
                            @error('patient_name')<span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="patient_phone" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">{{ __('Phone Number') }}</label>
                            <input type="tel" id="patient_phone" name="patient_phone" wire:model="patient_phone" placeholder="090 885 4328" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
                            @error('patient_phone')<span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="notes" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">{{ __('Notes (Optional)') }}</label>
                            <textarea id="notes" name="notes" wire:model="notes" rows="2" placeholder="{{ __('Briefly describe your symptoms...') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-[#0062B8] text-xs">3</span>
                    <label for="appointment_date">{{ __('Schedule Visit') }}</label>
                </h3>

                <div class="grid md:grid-cols-2 gap-8">
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
                                    this.fp.clear(); // Visually reset calendar
                                }
                            });

                            $wire.on('reset-calendar', () => {
                                if(this.fp) this.fp.clear();
                            });
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
                                onChange: (selectedDates, dateStr) => { 
                                    $wire.selectDate(dateStr); 
                                }
                            });
                        }
                    }" wire:ignore class="w-full overflow-hidden">
                        <input x-ref="dp" type="hidden" id="appointment_date" name="appointment_date">
                    </div>

                    <div>
                        <div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-3">
                            <h4 class="font-bold text-gray-800">
                                @if($appointment_date)
                                    {{ \Carbon\Carbon::parse($appointment_date)->format('D, M d, Y') }}
                                @else
                                    {{ __('Select a date') }}
                                @endif
                            </h4>
                            <div wire:loading wire:target="appointment_date,doctor_id">
                                <svg class="animate-spin h-5 w-5 text-[#0062B8]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
                        </div>

                        <div class="h-[260px] overflow-y-auto pr-2 custom-scrollbar relative">
                            @if(!$doctor_id)
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <p class="text-sm text-gray-500 font-medium">{{ __('Please select a specialist to view their availability.') }}</p>
                                </div>
                            @elseif(!$appointment_date)
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-sm text-gray-500 font-medium">{{ __('Pick an available date from the calendar.') }}</p>
                                </div>
                            @elseif(count($available_times) > 0)
                                <div class="grid grid-cols-2 gap-3" wire:loading.class="opacity-50 pointer-events-none">
                                    @foreach($available_times as $time)
                                        <button type="button" wire:click="selectTime('{{ $time }}')" 
                                            class="py-2.5 rounded-xl text-sm font-bold border transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md 
                                            {{ $appointment_time === $time ? 'bg-[#0062B8] border-[#0062B8] text-white shadow-md' : 'bg-white border-gray-200 text-gray-700 hover:border-[#0062B8] hover:text-[#0062B8]' }}">
                                            {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-sm text-gray-500 font-medium">{{ __('Fully booked. No slots available for this date.') }}</p>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" id="appointment_time" name="appointment_time" wire:model="appointment_time" required>
                        @error('appointment_time')<span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-400 max-w-xs">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        {{ __('Your information is secure and encrypted.') }}
                    </p>
                    <button type="submit" class="bg-[#0062B8] text-white px-8 py-3.5 rounded-xl font-bold hover:bg-[#003B73] transition shadow-lg transform hover:-translate-y-1 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submitAppointment">{{ __('Confirm Request') }}</span>
                        <span wire:loading wire:target="submitAppointment">{{ __('Processing...') }}</span>
                        <svg wire:loading.remove wire:target="submitAppointment" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

        </form>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
