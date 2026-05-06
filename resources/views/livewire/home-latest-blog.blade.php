<div class="bg-white py-16 font-sans relative overflow-hidden border-t border-gray-50">
    <!-- Include Swiper.js CSS & JS INSIDE the root div -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        
        <!-- Alpine.js wrapper -->
        <div x-data="{
            init() {
                new Swiper(this.$refs.blogSlider, {
                    slidesPerView: 1.2,
                    spaceBetween: 16,
                    grabCursor: true,
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: '.blog-next',
                        prevEl: '.blog-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 2.2, spaceBetween: 20 },
                        768: { slidesPerView: 3.2, spaceBetween: 24 },
                        1024: { slidesPerView: 4, spaceBetween: 24 },
                    }
                });
            }
        }">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="inline-block bg-blue-50 text-[#0062B8] text-xs font-black uppercase tracking-widest px-3 py-1 rounded-full mb-3">Health Insights</span>
                    <h2 class="text-3xl md:text-4xl font-black text-[#003B73] tracking-tight">Latest Medical News</h2>
                </div>
                <div class="flex items-center gap-2">
                    <button class="blog-prev w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 border border-gray-200 text-[#003B73] hover:bg-[#0062B8] hover:text-white transition-colors focus:outline-none">
                        <x-heroicon-m-chevron-left class="w-6 h-6" />
                    </button>
                    <button class="blog-next w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 border border-gray-200 text-[#003B73] hover:bg-[#0062B8] hover:text-white transition-colors focus:outline-none">
                        <x-heroicon-m-chevron-right class="w-6 h-6" />
                    </button>
                    <a href="/posts" class="ml-2 text-sm font-bold text-[#0062B8] hover:text-[#003B73] hidden sm:block">View All</a>
                </div>
            </div>

            <div x-ref="blogSlider" class="swiper overflow-visible">
                <div class="swiper-wrapper flex">
                    <!-- NATIVE AD INJECTION -->
                    <div class="swiper-slide h-auto">
                        <x-native-ad />
                    </div>

                    @forelse($posts as $post)
                        <div class="swiper-slide h-auto">
                            <a href="/posts/{{ $post->slug }}" class="flex flex-col h-full bg-white rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_8px_30px_rgba(0,59,115,0.08)] transition-all duration-300 group">
                                <div class="relative h-40 overflow-hidden bg-gray-100 shrink-0">
                                    <img src="{{ $post->display_image }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $post->title }}">
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <p class="text-[11px] text-gray-400 font-bold mb-2 uppercase tracking-wide">{{ $post->created_at->format('M d, Y') }}</p>
                                    <h3 class="text-lg font-black text-gray-900 leading-tight mb-2 group-hover:text-[#0062B8] transition-colors line-clamp-2">{{ $post->title }}</h3>
                                    <p class="text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2 font-medium">{{ $post->excerpt }}</p>
                                    <div class="mt-auto flex items-center pt-3 border-t border-gray-50 text-[#0062B8] text-sm font-bold group-hover:text-emerald-500 transition-colors">
                                        Read <x-heroicon-m-arrow-right class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" />
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="w-full text-center py-12 text-gray-500 font-medium">More health articles coming soon.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <style>.swiper-button-next::after, .swiper-button-prev::after { content: none; }</style>
</div>
