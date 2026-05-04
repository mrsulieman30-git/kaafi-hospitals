<div class="fixed bottom-6 right-6 z-50 flex items-end">
    
    <!-- Tooltip (visible only when chat is closed) -->
    @if(!$isOpen)
    <div class="bg-white text-gray-800 text-sm py-3 px-4 rounded-2xl rounded-br-none shadow-[0_8px_30px_rgb(0,0,0,0.12)] mr-4 mb-2 relative border border-gray-100 animate-bounce" style="animation-duration: 3s;">
        <p class="font-bold">Hi! I'm Kaafi AI Assistant.</p>
        <p class="text-gray-500 mt-0.5">Sideen kuu caawin karaa?</p>
        <!-- Triangle pointing right -->
        <div class="absolute w-3 h-3 bg-white border-b border-r border-gray-100 transform rotate-45 -right-1.5 bottom-3"></div>
    </div>
    @endif

    <!-- Chat Toggle Button -->
    <div class="relative">
        <!-- Red Notification Dot -->
        @if(!$isOpen)
        <div class="absolute top-0 right-0 w-3.5 h-3.5 bg-[#DC3545] border-2 border-white rounded-full z-10"></div>
        @endif
        
        <button wire:click="toggleChat" class="bg-[#0062B8] hover:bg-blue-700 text-white rounded-full w-16 h-16 shadow-[0_10px_40px_rgb(0,98,184,0.4)] flex items-center justify-center focus:outline-none transition transform hover:scale-105 border-[3px] border-white">
            @if($isOpen)
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            @else
                <!-- Robot Icon -->
                <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="4" y="8" width="16" height="12" rx="4" fill="white" stroke="none" />
                    <path d="M4 12a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v4a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-4z" stroke="#0062B8" stroke-width="2"/>
                    <circle cx="8" cy="14" r="1.5" fill="#0062B8" stroke="none"/>
                    <circle cx="16" cy="14" r="1.5" fill="#0062B8" stroke="none"/>
                    <path d="M10 18h4" stroke="#0062B8" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 8V4m-3 0h6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <!-- Antenna bulb -->
                    <circle cx="12" cy="4" r="1.5" fill="#DC3545" stroke="none"/>
                </svg>
            @endif
        </button>
    </div>

    <!-- Chat Window -->
    <div class="absolute bottom-20 right-0 w-80 sm:w-[380px] bg-white rounded-2xl shadow-[0_20px_60px_rgb(0,0,0,0.15)] overflow-hidden transition-all duration-300 transform origin-bottom-right {{ $isOpen ? 'scale-100 opacity-100' : 'scale-0 opacity-0 pointer-events-none' }} border border-gray-100 flex flex-col h-[500px] max-h-[80vh]">
        
        <!-- Header -->
        <div class="bg-[#003B73] text-white p-4 flex items-center justify-between shadow-md z-10">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white rounded-full overflow-hidden border-2 border-[#0062B8] flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="4" y="8" width="16" height="12" rx="4" fill="#0062B8" stroke="none" />
                        <circle cx="8" cy="14" r="1.5" fill="white" stroke="none"/>
                        <circle cx="16" cy="14" r="1.5" fill="white" stroke="none"/>
                        <path d="M10 18h4" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="font-bold text-sm tracking-wide">Kaafi AI Assistant</h3>
                    <p class="text-xs text-blue-200 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-[#28A745] mr-1"></span> Online
                    </p>
                </div>
            </div>
            <button wire:click="toggleChat" class="text-gray-300 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="p-4 flex-1 overflow-y-auto bg-gray-50 flex flex-col space-y-4" id="chat-messages" x-data="{ scrollToBottom() { this.$el.scrollTop = this.$el.scrollHeight; } }" x-init="scrollToBottom()" @message-sent.window="scrollToBottom()" @message-received.window="scrollToBottom()">
            
            @foreach($messages as $msg)
                @if($msg['role'] === 'assistant' || $msg['role'] === 'system')
                    <div class="flex items-end">
                        <div class="w-6 h-6 rounded-full bg-[#0062B8] flex-shrink-0 flex items-center justify-center text-white text-[10px] mr-2">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none">
                                <rect x="4" y="8" width="16" height="12" rx="4" fill="white" stroke="none" />
                                <circle cx="8" cy="14" r="1" fill="#0062B8" stroke="none"/>
                                <circle cx="16" cy="14" r="1" fill="#0062B8" stroke="none"/>
                            </svg>
                        </div>
                        <div class="bg-white p-3 rounded-2xl rounded-bl-none shadow-sm max-w-[80%] text-sm text-gray-800 border border-gray-100">
                            {!! nl2br(e($msg['content'])) !!}
                        </div>
                    </div>
                @elseif($msg['role'] === 'user')
                    <div class="flex items-end justify-end">
                        <div class="bg-[#0062B8] p-3 rounded-2xl rounded-br-none shadow-sm max-w-[80%] text-sm text-white">
                            {!! nl2br(e($msg['content'])) !!}
                        </div>
                    </div>
                @endif
            @endforeach

            @if($isLoading)
                <div class="flex items-end">
                    <div class="w-6 h-6 rounded-full bg-[#0062B8] flex-shrink-0 flex items-center justify-center text-white text-xs mr-2">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none">
                            <rect x="4" y="8" width="16" height="12" rx="4" fill="white" stroke="none" />
                        </svg>
                    </div>
                    <div class="bg-white p-3 rounded-2xl rounded-bl-none shadow-sm text-sm text-gray-800 border border-gray-100">
                        <div class="flex space-x-1 items-center h-4">
                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></div>
                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-100 z-10">
            <form wire:submit="sendMessage" class="flex items-center bg-gray-50 rounded-full border border-gray-200 px-2 py-1">
                <input wire:model="newMessage" type="text" class="flex-1 bg-transparent px-3 py-2 text-sm focus:outline-none" placeholder="Type your message..." {{ $isLoading ? 'disabled' : '' }}>
                <button type="submit" class="bg-[#0062B8] text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-700 transition focus:outline-none flex-shrink-0" {{ $isLoading || empty($newMessage) ? 'disabled' : '' }}>
                    <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
            <div class="text-center mt-2">
                <span class="text-[10px] text-gray-400 font-medium tracking-wide">POWERED BY DEEPSEEK AI</span>
            </div>
        </div>
    </div>
</div>
