<x-filament-widgets::widget>
    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 relative overflow-hidden transition-all duration-300 hover:shadow-2xl group">
        
        <!-- Subtle Ambient Background Glow -->
        <div class="absolute top-[-20%] right-[-5%] w-48 h-48 bg-gradient-to-br from-red-50 to-orange-50 rounded-full blur-3xl pointer-events-none group-hover:scale-110 transition-transform duration-700"></div>

        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-black text-[#003B73] flex items-center gap-3">
                        <x-heroicon-o-cpu-chip class="w-8 h-8 text-[#DC3545]" />
                        DeepSeek AI Quota
                    </h2>
                    <p class="text-sm text-gray-500 font-medium mt-1">Annual message limit for the automated medical assistant ({{ now()->year }} cycle)</p>
                </div>
                
                <div class="text-left md:text-right bg-gray-50 p-4 rounded-2xl border border-gray-100 shadow-inner">
                    <p class="text-4xl font-black text-gray-900 leading-none">{{ number_format($remainingQuota) }}</p>
                    <p class="text-[0.65rem] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Messages Remaining</p>
                </div>
            </div>

            <!-- The Burning Line (Progress Bar) -->
            <div class="relative w-full h-5 bg-gray-100 rounded-full overflow-hidden shadow-inner border border-gray-200/50">
                <div 
                    class="absolute top-0 left-0 h-full rounded-full transition-all duration-1000 ease-out relative overflow-hidden shadow-md"
                    style="width: {{ $percentageUsed > 0 ? $percentageUsed : 0.5 }}%; background: linear-gradient(90deg, #10B981 0%, #F59E0B 60%, #DC3545 100%);"
                >
                    <!-- Flowing energy animation overlay -->
                    <div class="absolute top-0 left-0 w-full h-full bg-white/20 animate-pulse"></div>
                    
                    <!-- Striped texture for modern mechanical feel -->
                    <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-size: 1rem 1rem;"></div>
                </div>
            </div>

            <!-- Footer Stats -->
            <div class="flex justify-between items-center mt-4 text-sm font-bold">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full {{ $percentageUsed > 80 ? 'bg-red-500 animate-ping' : 'bg-emerald-500' }}"></div>
                    <span class="text-gray-700">{{ number_format($usedQuota) }} Used <span class="text-gray-400 font-medium">({{ number_format($percentageUsed, 2) }}%)</span></span>
                </div>
                <span class="text-gray-400">{{ number_format($annualLimit) }} Total Limit</span>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
