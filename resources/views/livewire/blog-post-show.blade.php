@section('seo')
    <title>{{ $post->title }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ $post->excerpt }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image" content="{{ $post->display_image }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->fullUrl() }}">
    <meta property="twitter:title" content="{{ $post->title }}">
    <meta property="twitter:description" content="{{ $post->excerpt }}">
    <meta property="twitter:image" content="{{ $post->display_image }}">
@endsection

<div class="bg-gray-50 min-h-screen pb-24 font-sans">
    
    <!-- Top Navigation Bar -->
    <div class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
        <div class="container mx-auto px-4 max-w-4xl py-4 flex items-center justify-between">
            <a href="{{ $post->type === 'ad' ? '/offers' : '/posts' }}" class="flex items-center text-sm font-bold text-gray-500 hover:text-[#0062B8] transition-colors group">
                <x-heroicon-m-arrow-left class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" />
                {{ __('Back to') }} {{ $post->type === 'ad' ? __('Offers') : __('Articles') }}
            </a>
            
            <div class="flex gap-3">
                <button onclick="window.print()" class="p-2 text-gray-400 hover:text-[#003B73] transition-colors bg-gray-50 rounded-full hover:bg-gray-100" title="Print Content">
                    <x-heroicon-m-printer class="w-5 h-5" />
                </button>
            </div>
        </div>
    </div>

    <!-- Sleek, Compact Article Header -->
    <div class="container mx-auto px-4 max-w-4xl pt-6 pb-2">
        <div class="flex flex-wrap items-center gap-2 mb-2">
            @if($post->type === 'ad')
                <span class="bg-red-100 text-red-700 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-sm">{{ __('Special Offer') }}</span>
            @else
                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-sm">{{ __('Healthcare') }}</span>
            @endif
            <span class="text-xs text-gray-400 font-bold">{{ $post->created_at->format('M j, Y') }}</span>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-black text-[#003B73] leading-snug mb-3">
            {{ $post->title }}
        </h1>
        
        <p class="text-sm md:text-base text-gray-600 font-medium leading-relaxed mb-6 border-l-[3px] border-[#0062B8] pl-3">
            {{ $post->excerpt }}
        </p>

        @if($post->type === 'ad' && $post->new_price)
            <div class="bg-white border border-gray-100 rounded-2xl p-4 md:p-5 flex items-center gap-4 shadow-md mb-6 max-w-sm">
                @if($post->old_price)
                    <div class="text-gray-400 font-bold text-lg line-through">${{ $post->old_price }}</div>
                @endif
                <div class="text-emerald-500 font-black text-3xl">${{ $post->new_price }}</div>
            </div>
        @endif
    </div>

    <!-- Featured Image -->
    <div class="container mx-auto px-4 max-w-5xl mb-16">
        <div class="relative w-full aspect-video md:aspect-[21/9] rounded-3xl overflow-hidden shadow-2xl">
            <img src="{{ $post->display_image }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $post->title }}">
        </div>
    </div>

    <!-- Content (Prose format for rich text reading) -->
    <div class="container mx-auto px-4 max-w-3xl">
        
        <div class="prose prose-lg prose-blue max-w-none prose-headings:font-black prose-headings:text-[#003B73] prose-a:text-[#0062B8] prose-img:rounded-2xl prose-img:shadow-lg mb-16">
            {!! $post->content !!}
        </div>

        <!-- Linked Doctor Card (If tagged in Admin Panel) -->
        @if($post->linked_doctor_id && $post->linkedDoctor)
            <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 flex flex-col md:flex-row items-center gap-6 mb-16 shadow-inner">
                <img src="{{ $post->linkedDoctor->display_image }}" class="w-24 h-24 rounded-full object-cover shadow-md border-4 border-white">
                <div class="flex-1 text-center md:text-left">
                    <h4 class="font-black text-xl text-[#003B73]">{{ $post->linkedDoctor->name }}</h4>
                    <p class="text-emerald-600 font-bold text-sm uppercase tracking-wide mb-2">{{ $post->linkedDoctor->department->name ?? 'Specialist' }}</p>
                    <p class="text-gray-500 text-sm">{{ Str::limit($post->linkedDoctor->bio, 100) }}</p>
                </div>
                <a href="{{ route('doctors.profile', $post->linkedDoctor->id) }}" class="bg-white border border-gray-200 text-[#003B73] font-bold px-6 py-3 rounded-xl hover:border-[#0062B8] transition-colors shadow-sm whitespace-nowrap">
                    View Doctor
                </a>
            </div>
        @endif
        
        <!-- NATIVE AD INJECTION -->
        <div class="mb-16">
            <x-native-ad />
        </div>

        <!-- Author/Hospital Footer -->
        <div class="mt-8 pt-8 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#003B73] rounded-full flex items-center justify-center shadow-inner shrink-0">
                    <span class="text-white font-black text-lg">K</span>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">KAAFI Hospitals</h4>
                    <p class="text-sm text-gray-500">{{ $post->type === 'ad' ? 'Official Offer' : 'Medical Excellence Team' }}</p>
                </div>
            </div>
            
            <!-- SMART AI BUTTON -->
            <button onclick="window.dispatchEvent(new CustomEvent('open-ai-chat-context', { detail: { type: '{{ $post->type === 'ad' ? 'offer' : 'article' }}', id: {{ $post->id }} } }))" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#003B73] text-white px-8 py-4 rounded-full font-black shadow-lg hover:bg-[#0062B8] transition-colors cursor-pointer hover:scale-105 active:scale-95 border-none outline-none">
                <x-heroicon-s-sparkles class="w-5 h-5" />
                {{ __('Discuss with AI') }}
            </button>
        </div>
        
    </div>
</div>
