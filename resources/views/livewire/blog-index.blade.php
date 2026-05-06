<div class="bg-gray-50 min-h-screen pb-24 font-sans pt-8 lg:pt-12 overflow-x-hidden">
    <!-- Include Swiper.js CSS & JS INSIDE the root div -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Modern, Space-Saving Dashboard Toolbar -->
    <div class="container mx-auto px-4 max-w-7xl mb-8">
        <div class="bg-white p-6 lg:p-8 rounded-3xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            <!-- Left Side: Title & Info -->
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-3">
                    <x-heroicon-s-newspaper class="w-4 h-4" />
                    Latest Insights
                </div>
                <h1 class="text-3xl lg:text-4xl font-black text-[#003B73] tracking-tight mb-2">Health Blog</h1>
                <p class="text-gray-500 font-medium text-sm lg:text-base">Empowering your wellness journey with the latest medical news.</p>
            </div>

            <!-- Right Side: Search Bar -->
            <div class="flex flex-col sm:flex-row w-full lg:w-auto gap-3 lg:gap-4">
                <div class="relative group min-w-[260px] lg:min-w-[320px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400 group-focus-within:text-[#0062B8] transition-colors" />
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-11 pr-4 py-3.5 text-sm rounded-2xl border border-gray-200 focus:border-[#0062B8] focus:ring-4 focus:ring-blue-50 bg-gray-50 focus:bg-white text-gray-900 placeholder-gray-400 transition-all font-medium" placeholder="Search articles, conditions, tips...">
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Endless Carousel -->
    @if($featuredPosts->isNotEmpty() && empty($search))
        <div class="mb-16 mt-4 w-full" x-data="{
            init() {
                new Swiper(this.$refs.featuredSlider, {
                    slidesPerView: 1.15, // Shows the center slide + peeks at the edges
                    centeredSlides: true,
                    spaceBetween: 20,
                    loop: true, // Creates the endless feeling
                    speed: 800, // Smooth transition speed
                    autoplay: {
                        delay: 3500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        640: { slidesPerView: 1.2, spaceBetween: 24 },
                        1024: { slidesPerView: 1.4, spaceBetween: 40 }
                    }
                });
            }
        }">
            <!-- The Slider Container (py-8 adds comfortable space above and below) -->
            <div x-ref="featuredSlider" class="swiper featured-slider py-8">
                <div class="swiper-wrapper">
                    @foreach($featuredPosts as $featured)
                        <div class="swiper-slide">
                            <!-- Compact, Fixed-Height Card -->
                            <a href="/posts/{{ $featured->slug }}" class="flex flex-col md:flex-row h-auto md:h-[420px] bg-white rounded-[2rem] overflow-hidden shadow-[0_10px_40px_rgba(0,59,115,0.08)] border border-gray-100 group">
                                
                                <!-- Image Half -->
                                <div class="w-full md:w-1/2 h-56 md:h-full relative overflow-hidden bg-gray-100 shrink-0">
                                    <img src="{{ $featured->display_image }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="{{ $featured->title }}">
                                </div>
                                
                                <!-- Content Half -->
                                <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center bg-white">
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="bg-emerald-100 text-emerald-700 text-xs font-black uppercase tracking-wider px-3 py-1 rounded-full">Featured</span>
                                        <span class="text-sm text-gray-500 font-medium">{{ $featured->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <h2 class="text-2xl md:text-3xl font-black text-[#003B73] leading-tight mb-4 group-hover:text-[#0062B8] transition-colors line-clamp-3">
                                        {{ $featured->title }}
                                    </h2>
                                    <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-6 line-clamp-3 font-medium">
                                        {{ $featured->excerpt }}
                                    </p>
                                    <div class="mt-auto flex items-center gap-3 text-[#0062B8] font-bold group-hover:translate-x-2 transition-transform">
                                        Read Full Article <x-heroicon-m-arrow-right class="w-5 h-5" />
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="swiper-pagination !-bottom-2"></div>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 max-w-7xl relative z-20">
        <!-- Posts Grid (2 cols on mobile, 3 on tablet, 4 on desktop) -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 lg:gap-8">
            <!-- NATIVE AD INJECTION -->
            <div class="col-span-1">
                <x-native-ad />
            </div>

            @forelse($posts as $post)
                <a href="/posts/{{ $post->slug }}" class="group flex flex-col bg-white rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_10px_30px_rgba(0,59,115,0.08)] transition-all duration-300 hover:-translate-y-1">
                    
                    <!-- Image -->
                    <div class="relative h-32 sm:h-48 overflow-hidden bg-gray-100 shrink-0">
                        <img src="{{ $post->display_image }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $post->title }}">
                    </div>
                    
                    <!-- Content (Responsive padding and text sizing so 2-columns fit perfectly on mobile) -->
                    <div class="p-3 sm:p-5 flex flex-col flex-1">
                        <p class="text-[10px] sm:text-xs text-gray-400 font-bold mb-1.5 sm:mb-2 uppercase tracking-wide">{{ $post->created_at->format('M d, Y') }}</p>
                        <h3 class="text-sm sm:text-lg font-black text-gray-900 leading-snug mb-2 group-hover:text-[#0062B8] transition-colors line-clamp-2">{{ $post->title }}</h3>
                        
                        <!-- Hide excerpt on very small screens to keep cards tidy, show on tablet+ -->
                        <p class="hidden sm:block text-gray-500 text-sm leading-relaxed mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                        
                        <div class="mt-auto flex items-center pt-2 sm:pt-3 border-t border-gray-50 text-[#0062B8] text-xs sm:text-sm font-bold group-hover:text-emerald-500 transition-colors">
                            Read <x-heroicon-m-arrow-right class="w-3 h-3 sm:w-4 sm:h-4 ml-1 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <x-heroicon-o-document-magnifying-glass class="w-10 h-10 text-gray-400" />
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-2">No articles found</h3>
                    <p class="text-sm md:text-base text-gray-500">We couldn't find any articles matching your search.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>

    <!-- CSS to create the fading 3D Carousel effect for the featured slider -->
    <style>
        .featured-slider .swiper-slide {
            transition: all 0.5s ease;
            opacity: 0.4;
            transform: scale(0.9);
        }
        .featured-slider .swiper-slide-active {
            opacity: 1;
            transform: scale(1);
        }
        .featured-slider .swiper-pagination-bullet {
            background-color: #cbd5e1;
            opacity: 1;
        }
        .featured-slider .swiper-pagination-bullet-active {
            background-color: #0062B8;
            width: 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
    </style>
</div>
