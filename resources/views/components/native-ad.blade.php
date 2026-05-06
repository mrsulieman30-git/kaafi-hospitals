@php
    $ad = \App\Models\BlogPost::getRandomPriorityAd();
@endphp

@if($ad)
<a href="/posts/{{ $ad->slug }}" class="flex flex-col bg-gradient-to-br from-blue-50 to-white rounded-2xl overflow-hidden shadow-[0_4px_15px_rgba(0,0,0,0.05)] border border-blue-200 hover:shadow-[0_8px_25px_rgba(0,59,115,0.1)] transition-all duration-300 group relative h-full">
    
    <!-- Sponsored Tag -->
    <div class="absolute top-2 left-2 z-10">
        <span class="bg-yellow-400 text-yellow-900 text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded shadow-sm">Sponsored Offer</span>
    </div>

    <!-- Image -->
    <div class="relative h-32 overflow-hidden bg-gray-100 shrink-0">
        <img src="{{ $ad->display_image }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
    </div>
    
    <!-- Content -->
    <div class="p-4 flex flex-col flex-1">
        <h3 class="text-base font-black text-[#003B73] leading-snug mb-2 line-clamp-2">{{ $ad->title }}</h3>
        <p class="text-xs text-gray-500 leading-relaxed mb-3 line-clamp-2 font-medium">{{ $ad->excerpt }}</p>
        
        <div class="mt-auto flex items-center justify-between">
            @if($ad->new_price)
                <div class="font-black text-emerald-600">${{ $ad->new_price }}</div>
            @else
                <div class="text-xs font-bold text-[#0062B8]">Learn More</div>
            @endif
            <x-heroicon-m-arrow-right class="w-4 h-4 text-[#0062B8] group-hover:translate-x-1 transition-transform" />
        </div>
    </div>
</a>
@endif
