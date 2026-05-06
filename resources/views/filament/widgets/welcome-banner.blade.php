<x-filament-widgets::widget>
    <div class="relative overflow-hidden bg-gradient-to-br from-[#003B73] via-[#0052a0] to-[#0062B8] rounded-2xl p-8 text-white shadow-lg transition-all duration-300 hover:shadow-2xl group">
        
        <!-- Abstract Background Animation -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700 ease-in-out"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-[#DC3545] opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700 ease-in-out delay-100"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            
            <!-- Greeting & Info -->
            <div class="flex items-center gap-6 w-full md:w-auto">
                <div class="flex-shrink-0 w-20 h-20 bg-white/10 backdrop-blur-md rounded-full border border-white/20 flex items-center justify-center shadow-inner">
                    <span class="text-3xl font-extrabold text-white">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-blue-200 text-sm font-medium tracking-wider uppercase mb-1">{{ $greeting }},</p>
                    <h2 class="text-3xl font-bold tracking-tight mb-2">{{ $user->name }}</h2>
                    <p class="text-blue-100/80 text-sm flex items-center gap-2">
                        <x-heroicon-o-shield-check class="w-4 h-4 text-[#28A745]" />
                        System Administrator
                    </p>
                </div>
            </div>

            <!-- Smart Quick Actions -->
            <div class="flex flex-wrap gap-3 w-full md:w-auto">
                <a href="/admin/appointments/create" class="flex items-center gap-2 bg-white text-[#003B73] px-5 py-2.5 rounded-xl font-semibold shadow-md hover:bg-gray-50 hover:scale-105 transition-all duration-200 active:scale-95">
                    <x-heroicon-o-plus-circle class="w-5 h-5" />
                    New Appointment
                </a>
                <a href="/admin/doctors/create" class="flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-white/20 hover:scale-105 transition-all duration-200 active:scale-95">
                    <x-heroicon-o-user-plus class="w-5 h-5" />
                    Add Doctor
                </a>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
