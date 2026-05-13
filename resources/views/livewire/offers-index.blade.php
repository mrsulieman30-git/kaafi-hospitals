@section('seo')
    <title>{{ __('Medical Offers') }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Explore the latest medical checkup packages and special offers at KAAFI Hospitals.') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:title" content="{{ __('Medical Offers') }} | {{ config('app.name') }}">
    <meta property="og:description" content="{{ __('Explore the latest medical checkup packages and special offers at KAAFI Hospitals.') }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->fullUrl() }}">
    <meta property="twitter:title" content="{{ __('Medical Offers') }} | {{ config('app.name') }}">
    <meta property="twitter:description" content="{{ __('Explore the latest medical checkup packages and special offers at KAAFI Hospitals.') }}">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">
@endsection

<div class="bg-gray-50 min-h-screen pb-24 font-sans pt-12">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <div class="text-center mb-16">
            <span class="inline-block bg-red-50 text-red-600 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3">Special Deals</span>
            <h1 class="text-4xl md:text-5xl font-black text-[#003B73] tracking-tight mb-4">Hospital Offers & Notices</h1>
            <p class="text-gray-500 font-medium">Discover our latest health packages, discounts, and important updates.</p>
        </div>

        <!-- 2 cols on mobile, 3 on desktop -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-8">
            @foreach($offers as $offer)
                <div class="bg-white rounded-2xl sm:rounded-3xl overflow-hidden shadow-lg border border-gray-100 flex flex-col group hover:-translate-y-2 hover:shadow-2xl transition-all">
                    
                    <a href="/posts/{{ $offer->slug }}" class="relative h-40 sm:h-56 overflow-hidden block">
                        <img src="{{ $offer->display_image }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        
                        @if($offer->new_price)
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md rounded-xl p-2 shadow-lg border border-white/50 text-center">
                                @if($offer->old_price)
                                    <span class="block text-[10px] text-gray-500 font-bold line-through">${{ $offer->old_price }}</span>
                                @endif
                                <span class="block text-lg sm:text-xl text-emerald-600 font-black leading-none">${{ $offer->new_price }}</span>
                            </div>
                        @endif
                    </a>

                    <div class="p-4 sm:p-6 flex flex-col flex-1">
                        <h3 class="text-base sm:text-xl font-black text-[#003B73] mb-2 line-clamp-2">{{ $offer->title }}</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mb-4 line-clamp-3">{{ $offer->excerpt }}</p>
                        
                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                            <!-- LIKE BUTTON (Livewire Magic) -->
                            <button wire:click="likeAd({{ $offer->id }})" class="flex items-center gap-1.5 text-gray-400 hover:text-red-500 transition-colors">
                                <x-heroicon-s-heart class="w-5 h-5" />
                                <span class="font-bold text-sm">{{ $offer->likes }}</span>
                            </button>
                            
                            <a href="/posts/{{ $offer->slug }}" class="text-xs sm:text-sm font-bold text-[#0062B8] hover:text-[#003B73]">View Details &rarr;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
