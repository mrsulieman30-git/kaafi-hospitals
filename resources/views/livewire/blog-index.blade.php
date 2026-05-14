<div>
    @section('seo')
        <title>{{ __('KAAFI Updates') }} | {{ config('app.name') }}</title>
        <meta name="description" content="{{ __('Stay updated with the latest medical news, health tips, and hospital updates from KAAFI Hospitals.') }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:title" content="{{ __('KAAFI Updates') }} | {{ config('app.name') }}">
        <meta property="og:description" content="{{ __('Stay updated with the latest medical news, health tips, and hospital updates from KAAFI Hospitals.') }}">
        <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ request()->fullUrl() }}">
        <meta property="twitter:title" content="{{ __('KAAFI Updates') }} | {{ config('app.name') }}">
        <meta property="twitter:description" content="{{ __('Stay updated with the latest medical news, health tips, and hospital updates from KAAFI Hospitals.') }}">
        <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">
    @endsection

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50/30">
<!-- Compact Facebook-style Header -->
    <div class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Title -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#003B73] rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">{{ __('KAAFI Updates') }}</h1>
                </div>

                <!-- Search & Filters in Single Line -->
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 sm:flex-initial">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            class="w-full sm:w-64 pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#003B73] focus:border-transparent bg-white"
                            placeholder="{{ __('Search articles...') }}"
                        >
                    </div>

                    <!-- Category Filter -->
                    <div class="relative">
                        <select
                            wire:model.live="selectedCategory"
                            class="appearance-none bg-white border border-gray-300 px-4 py-2 pr-8 rounded-lg text-sm focus:ring-2 focus:ring-[#003B73] focus:border-transparent cursor-pointer"
                        >
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $getLocalizedString($category->name) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="relative">
                        <select
                            wire:model.live="sortBy"
                            class="appearance-none bg-white border border-gray-300 px-4 py-2 pr-8 rounded-lg text-sm focus:ring-2 focus:ring-[#003B73] focus:border-transparent cursor-pointer"
                        >
                            <option value="latest">{{ __('Latest') }}</option>
                            <option value="popular">{{ __('Popular') }}</option>
                            <option value="oldest">{{ __('Oldest') }}</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Featured Posts Slider -->
        @if($featuredPosts->isNotEmpty() && empty($search) && is_null($selectedCategory))
            <div class="mb-16">
                <!-- Swiper CSS & JS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
                <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

                <div class="text-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-2">{{ __('Featured Articles') }}</h2>
                    <p class="text-gray-600">{{ __('Handpicked content from our medical experts') }}</p>
                </div>

                <div x-data="featuredSlider()" class="relative">
                    <div x-ref="slider" class="swiper featured-swiper">
                        <div class="swiper-wrapper">
                            @foreach($featuredPosts as $post)
                                <div class="swiper-slide">
                                    <a href="/posts/{{ $post->slug }}" class="group block">
                                        <div class="bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 mx-4 border border-gray-100">
                                            <div class="relative h-64 md:h-80 overflow-hidden">
                                                <img
                                                    src="{{ $post->display_image }}"
                                                    alt="{{ $post->title }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                                >
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                                                <!-- Featured Badge -->
                                                <div class="absolute top-4 left-4">
                                                    <span class="bg-emerald-500 text-white text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg">
                                                        {{ __('Featured') }}
                                                    </span>
                                                </div>

                                                <!-- Category Badge -->
                                                @if($post->category)
                                                    <div class="absolute top-4 right-4">
                                                        <span class="bg-white/90 text-gray-900 text-xs font-bold px-3 py-1.5 rounded-full backdrop-blur-sm">
                                                            {{ $getLocalizedString($post->category->name) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-6 md:p-8">
                                                <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        {{ $post->created_at->format('M d, Y') }}
                                                    </span>
                                                    @if($post->user)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                            </svg>
                                                            {{ $post->user->name }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3 group-hover:text-[#0062B8] transition-colors leading-tight line-clamp-2">
                                                    {{ $post->title }}
                                                </h3>

                                                <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-4 line-clamp-3">
                                                    {{ $post->excerpt }}
                                                </p>

                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                            </svg>
                                                            {{ $post->likes_count ?? 0 }}
                                                        </span>
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                            </svg>
                                                            {{ $post->comments->where('is_approved', true)->count() }}
                                                        </span>
                                                    </div>

                                                    <div class="flex items-center text-[#0062B8] font-semibold group-hover:translate-x-1 transition-transform">
                                                        {{ __('Read More') }}
                                                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigation -->
                        <div class="swiper-button-next !text-[#003B73] !w-12 !h-12 !right-2 after:!text-lg"></div>
                        <div class="swiper-button-prev !text-[#003B73] !w-12 !h-12 !left-2 after:!text-lg"></div>

                        <!-- Pagination -->
                        <div class="swiper-pagination !bottom-4"></div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Posts Grid -->
        <div class="pb-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-1">{{ __('Latest Articles') }}</h2>
                    <p class="text-gray-600">
                        @if($search)
                            {{ __('Search results for') }}: <span class="font-semibold text-gray-900">"{{ $search }}"</span>
                        @elseif($selectedCategory)
                            {{ __('Articles in') }}: <span class="font-semibold text-gray-900">{{ $categories->find($selectedCategory)?->name ?? 'Category' }}</span>
                        @else
                            {{ __('Explore our comprehensive collection of medical content') }}
                        @endif
                    </p>
                </div>

                <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
                    <span>{{ $posts->total() }} {{ __('articles found') }}</span>
                </div>
            </div>

            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                    @foreach($posts as $post)
                        <article class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:-translate-y-1">
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden bg-gray-100">
                                <img
                                    src="{{ $post->display_image }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                >

                                <!-- Badges Overlay -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if($post->created_at > now()->subDays(7))
                                        <span class="bg-red-500 text-white text-xs font-black uppercase tracking-wider px-2 py-1 rounded shadow-lg">
                                            {{ __('New') }}
                                        </span>
                                    @endif

                                    @if($post->type === 'ad')
                                        <span class="bg-orange-500 text-white text-xs font-black uppercase tracking-wider px-2 py-1 rounded shadow-lg">
                                            {{ __('Offer') }}
                                        </span>
                                    @elseif($post->category)
                                        <span class="bg-[#003B73] text-white text-xs font-black uppercase tracking-wider px-2 py-1 rounded shadow-lg">
                                            {{ $getLocalizedString($post->category->name) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Reading Time Indicator -->
                                <div class="absolute bottom-3 right-3">
                                    <span class="bg-black/70 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                        {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $post->created_at->format('M d, Y') }}
                                    </span>
                                    @if($post->user)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $post->user->name }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-[#0062B8] transition-colors leading-tight line-clamp-2">
                                    <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                                </h3>

                                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                                </p>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            {{ $post->likes_count ?? 0 }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            {{ $post->comments->where('is_approved', true)->count() }}
                                        </span>
                                    </div>

                                    <a href="/posts/{{ $post->slug }}" class="text-[#0062B8] font-semibold text-sm hover:text-[#003B73] transition-colors flex items-center group-hover:translate-x-1">
                                        {{ __('Read More') }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 shadow-lg">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">{{ __('No articles found') }}</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        @if($search)
                            {{ __('We couldn\'t find any articles matching your search for') }} <strong>"{{ $search }}"</strong>
                        @else
                            {{ __('Check back later for new medical updates and health insights.') }}
                        @endif
                    </p>
                    @if($search)
                        <button wire:click="$set('search', '')" class="bg-[#003B73] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#0052a0] transition-colors">
                            {{ __('Clear Search') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function featuredSlider() {
    return {
        init() {
            new Swiper(this.$refs.slider, {
                slidesPerView: 3,
                spaceBetween: 20,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: { slidesPerView: 1.2 },
                    640: { slidesPerView: 2.2 },
                    1024: { slidesPerView: 2.5 },
                    1280: { slidesPerView: 3 }
                },
                effect: 'coverflow',
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 150,
                    modifier: 1,
                    slideShadows: false,
                }
            });
        }
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.swiper-pagination-bullet {
    background-color: #cbd5e1;
    opacity: 1;
}

.swiper-pagination-bullet-active {
    background-color: #003B73;
    transform: scale(1.2);
}

.swiper-button-next,
.swiper-button-prev {
    color: #003B73 !important;
    background: white;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 59, 115, 0.15);
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 18px !important;
    font-weight: bold;
}

/* Featured slider custom sizing */
.featured-swiper .swiper-slide {
    transition: transform 0.3s ease;
}

.featured-swiper .swiper-slide-active {
    transform: scale(1);
    z-index: 2;
}

.featured-swiper .swiper-slide-next,
.featured-swiper .swiper-slide-prev {
    transform: scale(0.5);
    z-index: 1;
}

.featured-swiper .swiper-slide:not(.swiper-slide-active):not(.swiper-slide-next):not(.swiper-slide-prev) {
    transform: scale(0.5);
    opacity: 0.7;
}
</style>
</div>
