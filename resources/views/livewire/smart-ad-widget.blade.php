<div>
    @if($latestAd)
    <div x-data="{
            isOpen: false,
            showBubble: false,
            adId: {{ $latestAd->id }},
            
            // Dragging state
            pos: { x: window.innerWidth - 100, y: window.innerHeight - 100 },
            startPos: { x: 0, y: 0 },
            dragging: false,
            
            init() {
                // Initialize position to bottom right
                this.pos.x = window.innerWidth - 90;
                this.pos.y = window.innerHeight - 90;

                // Check LocalStorage for Refresh Counting logic
                let isHidden = localStorage.getItem('kaafi_ad_closed_' + this.adId) === 'true';
                let refreshCount = parseInt(localStorage.getItem('kaafi_ad_refreshes_' + this.adId) || '0');

                if (isHidden) {
                    refreshCount++;
                    localStorage.setItem('kaafi_ad_refreshes_' + this.adId, refreshCount);
                    
                    // If refreshed 3 times, bring it back!
                    if (refreshCount >= 3) {
                        localStorage.setItem('kaafi_ad_closed_' + this.adId, 'false');
                        localStorage.setItem('kaafi_ad_refreshes_' + this.adId, '0');
                        this.showBubble = true;
                        setTimeout(() => { this.isOpen = true; $wire.recordView(); }, 1500);
                    }
                } else {
                    this.showBubble = true;
                    setTimeout(() => { this.isOpen = true; $wire.recordView(); }, 1500);
                }
            },
            closeAd() {
                this.isOpen = false;
                this.showBubble = false;
                localStorage.setItem('kaafi_ad_closed_' + this.adId, 'true');
                localStorage.setItem('kaafi_ad_refreshes_' + this.adId, '0');
            },
            dragStart(e) {
                this.dragging = true;
                let clientX = e.clientX || e.touches[0].clientX;
                let clientY = e.clientY || e.touches[0].clientY;
                this.startPos = { x: clientX - this.pos.x, y: clientY - this.pos.y };
            },
            dragMove(e) {
                if (!this.dragging) return;
                e.preventDefault();
                let clientX = e.clientX || e.touches[0].clientX;
                let clientY = e.clientY || e.touches[0].clientY;
                
                // Calculate new position and keep within screen bounds
                let newX = clientX - this.startPos.x;
                let newY = clientY - this.startPos.y;
                
                this.pos.x = Math.max(10, Math.min(newX, window.innerWidth - 80));
                this.pos.y = Math.max(10, Math.min(newY, window.innerHeight - 80));
            },
            dragEnd() {
                this.dragging = false;
            }
        }"
        @resize.window="pos.x = Math.min(pos.x, window.innerWidth - 80); pos.y = Math.min(pos.y, window.innerHeight - 80)"
        class="fixed inset-0 z-[99999] pointer-events-none"
    >

        <!-- THE DRAGGABLE FLOATING BUBBLE -->
        <!-- Binds to mouse and touch events for seamless dragging -->
        <div 
            x-show="showBubble"
            x-transition.opacity
            class="absolute pointer-events-auto shadow-2xl flex items-center justify-center cursor-grab active:cursor-grabbing hover:scale-105 transition-transform"
            :class="dragging ? 'duration-0' : 'duration-300'"
            :style="`transform: translate3d(${pos.x}px, ${pos.y}px, 0); width: 70px; height: 70px;`"
            @mousedown="dragStart($event)"
            @mousemove.window="dragMove($event)"
            @mouseup.window="dragEnd()"
            @touchstart="dragStart($event)"
            @touchmove.window="dragMove($event)"
            @touchend.window="dragEnd()"
            @click="if(!dragging) isOpen = true"
        >
            <div class="relative w-full h-full rounded-full border-4 border-white shadow-[0_10px_25px_rgba(0,59,115,0.4)] overflow-hidden bg-[#003B73]">
                <img src="{{ $latestAd->display_image }}" class="w-full h-full object-cover opacity-80 mix-blend-overlay">
                <div class="absolute inset-0 flex items-center justify-center text-white">
                    <x-heroicon-s-tag class="w-6 h-6 animate-pulse" />
                </div>
            </div>
            
            <!-- Red Notification Dot -->
            <span class="absolute top-0 right-0 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-white"></span>
            </span>
        </div>


        <!-- THE POPUP MODAL (Opens when bubble is clicked) -->
        <div x-show="isOpen" x-transition.opacity class="fixed inset-0 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm pointer-events-auto" style="display: none;">
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0" @click.away="isOpen = false" class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col">
                
                <!-- Close AD FOREVER (Until 3 refreshes) -->
                <button @click="closeAd()" class="absolute top-4 right-4 z-10 p-2 bg-black/20 hover:bg-black/40 text-white rounded-full backdrop-blur-md transition-colors" title="Dismiss Offer">
                    <x-heroicon-m-x-mark class="w-5 h-5" />
                </button>

                <div class="h-64 relative bg-gray-100">
                    <img src="{{ $latestAd->display_image }}" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-6">
                        <span class="bg-red-500 text-white text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg border border-red-400">Limited Time Offer</span>
                    </div>
                </div>

                <div class="p-8 text-center">
                    <h2 class="text-3xl font-black text-[#003B73] mb-2 leading-tight">{{ $latestAd->title }}</h2>
                    <p class="text-gray-500 mb-6 font-medium">{{ $latestAd->excerpt }}</p>
                    
                    @if($latestAd->new_price)
                        <div class="flex items-center justify-center gap-4 mb-6">
                            @if($latestAd->old_price)
                                <span class="text-2xl text-gray-400 font-bold line-through">${{ $latestAd->old_price }}</span>
                            @endif
                            <span class="text-4xl text-emerald-500 font-black drop-shadow-sm">${{ $latestAd->new_price }}</span>
                        </div>
                    @endif

                    <div class="flex flex-col gap-3">
                        <a href="/posts/{{ $latestAd->slug }}" class="w-full bg-[#0062B8] text-white font-black py-4 rounded-2xl shadow-lg hover:bg-[#003B73] transition-colors text-lg">
                            Claim Offer Now
                        </a>
                        <!-- Minimize Back to Bubble -->
                        <button @click="isOpen = false" class="text-gray-400 text-sm font-bold hover:text-gray-600 mt-2">
                            Remind me later
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endif
</div>
