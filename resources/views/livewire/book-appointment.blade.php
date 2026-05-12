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
    .flatpickr-calendar{font-family:inherit;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,.1);border:1px solid #f3f4f6}
    .flatpickr-day.selected{background:#0062B8!important;border-color:#0062B8!important}
    .flatpickr-day.flatpickr-disabled{color:#d1d5db!important;text-decoration:line-through}
</style>
<div class="bg-gray-50 min-h-screen py-16 font-sans">
 <div class="container mx-auto px-4 max-w-3xl">
  <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
   <div class="bg-[#003B73] p-8 text-center text-white">
    <h1 class="text-3xl font-black tracking-tight mb-2">{{ __('Book an Appointment') }}</h1>
    <p class="text-blue-200 font-medium">{{ __('Fill out the form below and we will confirm your visit.') }}</p>
   </div>
   <div class="p-8 md:p-12">
    @if($successMessage)
    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-r-xl mb-8">
     <div class="flex items-center gap-3 mb-2">
      <x-heroicon-s-check-circle class="w-6 h-6 text-emerald-500" />
      <h3 class="font-black text-emerald-800 text-lg">{{ __('Booking Successful!') }}</h3>
     </div>
     <p class="text-emerald-700 font-medium">{{ $successMessage }}</p>
    </div>
    @endif
    <form wire:submit.prevent="submitAppointment" class="space-y-6">
     <div>
      <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Select Specialist') }}</label>
      <select wire:model.live="doctor_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
       <option value="">-- {{ __('Choose a Doctor') }} --</option>
       @foreach($doctors as $doc)
       <option value="{{ $doc->id }}" @selected($doc->id == $doctor_id)>{{ $getLocalizedString($doc->name) }} ({{ $doc->department ? $getLocalizedString($doc->department->name) : 'General' }})</option>
       @endforeach
      </select>
      @error('doctor_id')<span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span>@enderror
     </div>
     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div x-data="{
        fp: null,
        allowedDays: @js($allowed_days),
        init() {
          this.build();
          Livewire.on('allowed-days-updated', (data) => {
            this.allowedDays = Array.isArray(data) ? (Array.isArray(data[0]) ? data[0] : data) : [];
            if(this.fp) this.fp.destroy();
            this.$nextTick(() => this.build());
          });
        },
        build() {
          const self = this;
          this.fp = flatpickr(this.$refs.dp, {
            minDate:'today',
            dateFormat:'Y-m-d',
            disable:[ function(date){
              if(!self.allowedDays||self.allowedDays.length===0) return true;
              const n=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
              return !self.allowedDays.includes(n[date.getDay()]);
            }],
            onChange(s,dateStr){ $wire.selectDate(dateStr); }
          });
        }
      }" wire:ignore>
       <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Preferred Date') }}</label>
       <input x-ref="dp" type="text" readonly placeholder="{{ __('Click to select a working date...') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium cursor-pointer">
       @error('appointment_date')<span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span>@enderror
      </div>
      <div>
       <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Preferred Time') }}</label>
       <div class="relative">
        <select wire:model.live="appointment_time" wire:key="ts-{{ $doctor_id }}-{{ $appointment_date }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium disabled:opacity-50 disabled:cursor-not-allowed" {{ empty($available_times) ? 'disabled' : '' }}>
         <option value="">-- {{ __('Choose a Time') }} --</option>
         @foreach($available_times as $time)
         <option value="{{ $time }}">{{ \Carbon\Carbon::parse($time)->format('h:i A') }}</option>
         @endforeach
        </select>
        <div wire:loading wire:target="appointment_date,doctor_id" class="absolute inset-y-0 right-10 flex items-center">
         <svg class="animate-spin h-5 w-5 text-[#0062B8]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
       </div>
       @if(empty($available_times) && $doctor_id && $appointment_date)
       <span class="text-amber-600 text-xs font-bold mt-1 block">{{ __('No available time slots. Please select another date.') }}</span>
       @elseif(!$doctor_id)
       <span class="text-gray-500 text-xs font-medium mt-1 block">{{ __('Select a doctor and date to view times.') }}</span>
       @elseif(!$appointment_date)
       <span class="text-gray-500 text-xs font-medium mt-1 block">{{ __('Select a date first to view available times.') }}</span>
       @endif
       @error('appointment_time')<span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span>@enderror
      </div>
     </div>
     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
       <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Patient Full Name') }}</label>
       <input type="text" wire:model="patient_name" placeholder="{{ __('John Doe') }}" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
       @error('patient_name')<span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span>@enderror
      </div>
      <div>
       <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Phone Number') }}</label>
       <input type="tel" wire:model="patient_phone" placeholder="090 885 4328" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] transition-all font-medium">
       @error('patient_phone')<span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span>@enderror
      </div>
     </div>
     <div class="pt-4">
      <button type="submit" class="w-full bg-[#0062B8] text-white font-black text-lg py-4 rounded-xl shadow-lg hover:bg-[#003B73] hover:shadow-xl transition-all transform hover:-translate-y-1">{{ __('Confirm Appointment Request') }}</button>
     </div>
    </form>
   </div>
  </div>
 </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
