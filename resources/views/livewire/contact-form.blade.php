<div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
    <h2 class="text-2xl font-bold text-[#003B73] mb-6">{{ __('Send us a message') }}</h2>
    
    @if ($successMessage)
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 font-bold flex items-center gap-3">
            <x-heroicon-s-check-circle class="w-6 h-6" />
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit.prevent="submitForm">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 font-bold">{{ __('Name') }}</label>
            <input type="text" wire:model="name" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#0062B8] focus:border-[#0062B8] @error('name') border-red-500 @enderror" placeholder="{{ __('Your Name') }}">
            @error('name') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 font-bold">{{ __('Email Address') }}</label>
            <input type="email" wire:model="email" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#0062B8] focus:border-[#0062B8] @error('email') border-red-500 @enderror" placeholder="email@example.com">
            @error('email') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-2 font-bold">{{ __('Your Message') }}</label>
            <textarea rows="4" wire:model="message" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#0062B8] focus:border-[#0062B8] @error('message') border-red-500 @enderror" placeholder="{{ __('Write your thoughts...') }}"></textarea>
            @error('message') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" class="bg-[#003B73] hover:bg-[#0062B8] text-white font-black py-4 px-6 rounded-xl w-full transition shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2">
            <span wire:loading.remove>{{ __('Send Message') }}</span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                {{ __('Sending...') }}
            </span>
        </button>
    </form>
</div>
