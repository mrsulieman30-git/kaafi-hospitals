<div class="fixed bottom-[3px] right-[3px] sm:bottom-[3px] sm:right-[3px] z-[9999] font-sans flex items-end justify-end" 
     x-data="{ isOpen: false }"
     @open-ai-chat.window="isOpen = true"
     @open-ai-chat-context.window="isOpen = true; $wire.startContextDiscussion($event.detail.type, $event.detail.id)">

    <!-- Morphing Balloon Container (The Mask) -->
    @php $settings = \App\Models\SiteSetting::first(); @endphp
    <div
        class="relative overflow-hidden transition-all duration-[600ms] ease-[cubic-bezier(0.23,1,0.32,1)] shadow-[0_10px_40px_rgba(0,59,115,0.3)] origin-bottom-right"
        :class="isOpen
            ? 'w-[350px] sm:w-[400px] h-[600px] max-h-[calc(100vh-6px)] bg-white rounded-[2rem] rounded-br-[12px] border border-gray-100'
            : 'w-16 h-16 bg-[#003B73] rounded-full border-2 border-white/20 hover:scale-105 active:scale-95 cursor-pointer'"
        style="will-change: width, height, border-radius, background-color;"
    >

        <!-- Closed State Avatar (Fades out dynamically) -->
        <div
            @click="isOpen = true"
            class="absolute inset-0 flex items-center justify-center transition-all duration-300 z-50"
            :class="isOpen ? 'opacity-0 scale-75 pointer-events-none' : 'opacity-100 scale-100 delay-300'"
        >
            <!-- Online Ping Indicator -->
            <span class="absolute -top-1 -right-1 flex h-4 w-4" x-show="!isOpen">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-[#003B73]"></span>
            </span>

            @if($settings && $settings->chatbot_avatar_path)
                <img src="{{ asset('storage/' . $settings->chatbot_avatar_path) }}" class="w-full h-full object-cover rounded-full">
            @else
                <x-heroicon-o-chat-bubble-left-ellipsis class="w-8 h-8 text-white group-hover:animate-pulse" />
            @endif
        </div>

        <!-- Opened State Chat Window (Fixed size, revealed by the expanding mask) -->
        <div
            class="absolute bottom-0 right-0 w-[350px] sm:w-[400px] h-[600px] max-h-[calc(100vh-6px)] flex flex-col transition-opacity duration-500 z-40"
            :class="isOpen ? 'opacity-100 delay-[250ms]' : 'opacity-0 pointer-events-none'"
        >
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#003B73] to-[#0062B8] p-5 flex justify-between items-center text-white z-10 rounded-t-[2rem] shrink-0">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-full border border-white/20 flex items-center justify-center shadow-inner overflow-hidden">
                            @if($settings && $settings->chatbot_avatar_path)
                                <img src="{{ asset('storage/' . $settings->chatbot_avatar_path) }}" class="w-full h-full object-cover">
                            @else
                                <x-heroicon-o-sparkles class="w-6 h-6 text-white" />
                            @endif
                        </div>
                        <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-400 border-2 border-[#004A8B] rounded-full"></div>
                    </div>
                    <div>
                        <h3 class="font-black text-lg leading-tight tracking-tight">{{ __('KAAFI Assistant') }}</h3>
                        <p class="text-xs text-blue-200 font-medium">{{ __('Smart Scheduling & Support') }}</p>
                    </div>
                </div>
                <!-- Close Button -->
                <button @click="isOpen = false" class="text-blue-200 hover:text-white transition bg-white/10 p-2 rounded-full hover:bg-white/20">
                    <x-heroicon-m-x-mark class="w-5 h-5" />
                </button>
            </div>

            <!-- Messages Area -->
            <div 
                class="flex-1 p-5 overflow-y-auto bg-gray-50/50 space-y-4 custom-scrollbar scroll-smooth" 
                id="chat-messages"
                @scroll-to-bottom.window="setTimeout(() => { let box = document.getElementById('chat-messages'); box.scrollTop = box.scrollHeight; }, 100);"
                x-effect="if(isOpen) { setTimeout(() => { let box = document.getElementById('chat-messages'); box.scrollTop = box.scrollHeight; }, 100); }"
            >
                @foreach($messages as $msg)
                    @if($msg['role'] === 'user' || $msg['role'] === 'assistant')
                        <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[85%] rounded-2xl p-3.5 text-[0.9rem] leading-relaxed {{ $msg['role'] === 'user' ? 'bg-[#0062B8] text-white rounded-br-sm shadow-md' : 'bg-white text-gray-800 border border-gray-100 rounded-bl-sm shadow-sm' }}">
                                {!! Str::markdown($msg['content'] ?? '') !!}
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- Typing Indicator -->
                @if($isTyping)
                    <div class="flex justify-start">
                        <div class="bg-white border border-gray-100 rounded-2xl rounded-bl-sm p-4 shadow-sm flex gap-1.5 items-center">
                            <div class="w-1.5 h-1.5 bg-[#0062B8] rounded-full animate-bounce"></div>
                            <div class="w-1.5 h-1.5 bg-[#0062B8] rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-1.5 h-1.5 bg-[#0062B8] rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Shortcuts & Input Area -->
            <div class="bg-white border-t border-gray-100 flex flex-col shrink-0 rounded-b-[12px]">
                
                <div class="flex gap-2 overflow-x-auto p-3 custom-scrollbar hide-scrollbar-arrows bg-gray-50/50 border-b border-gray-50">
                    <button wire:click="useShortcut('I would like to book an appointment.')" class="flex-shrink-0 bg-white border border-gray-200 text-[#003B73] hover:border-[#0062B8] hover:bg-blue-50 text-xs font-bold px-4 py-2 rounded-full transition-colors whitespace-nowrap">
                        📅 {{ __('Book Appointment') }}
                    </button>
                    <button wire:click="useShortcut('What departments do you have?')" class="flex-shrink-0 bg-white border border-gray-200 text-[#003B73] hover:border-[#0062B8] hover:bg-blue-50 text-xs font-bold px-4 py-2 rounded-full transition-colors whitespace-nowrap">
                        🏥 {{ __('Find Department') }}
                    </button>
                    <button wire:click="useShortcut('Search your blog for healthy heart tips.')" class="flex-shrink-0 bg-white border border-gray-200 text-[#003B73] hover:border-[#0062B8] hover:bg-blue-50 text-xs font-bold px-4 py-2 rounded-full transition-colors whitespace-nowrap">
                        ❤️ {{ __('Health Tips') }}
                    </button>
                </div>

                <!-- Input Area -->
                <form wire:submit.prevent="sendMessage" class="p-4 relative flex items-end gap-2">
                    <textarea 
                        wire:model="userInput" 
                        placeholder="{{ __('Type your question...') }}" 
                        rows="1"
                        x-on:keydown.enter="if(!$event.shiftKey) { $event.preventDefault(); $wire.sendMessage(); $el.style.height = '48px'; }"
                        @input="$el.style.height = '48px'; $el.style.height = Math.min($el.scrollHeight, 120) + 'px'"
                        class="w-full bg-gray-100 text-sm text-gray-800 rounded-3xl pl-5 pr-12 py-3.5 focus:outline-none focus:ring-2 focus:ring-[#0062B8] focus:bg-white transition-all border border-transparent focus:border-blue-200 resize-none custom-scrollbar leading-relaxed"
                        style="min-height: 48px; max-height: 120px; overflow-y: auto;"
                        {{ $isTyping ? 'disabled' : '' }}
                    ></textarea>
                    
                    <button 
                        type="submit" 
                        class="absolute right-6 bottom-[22px] w-9 h-9 bg-[#003B73] hover:bg-[#0062B8] text-white rounded-full flex items-center justify-center transition-colors shadow-md {{ $isTyping ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105 active:scale-95' }}"
                        {{ $isTyping ? 'disabled' : '' }}
                    >
                        <x-heroicon-s-paper-airplane class="w-4 h-4 translate-x-[1px]" />
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
        .hide-scrollbar-arrows::-webkit-scrollbar-button { display: none; }
    </style>
</div>
