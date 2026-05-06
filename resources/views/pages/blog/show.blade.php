@extends('layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' - KAAFI Hospitals Blog')
@section('meta_description', $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 160)))

@push('meta')
    <title>{{ ($post->meta_title ?: $post->title) . ' - KAAFI Hospitals Blog' }}</title>
    <meta name="description" content="{{ $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 160)) }}">

    {{-- Open Graph (Facebook, LinkedIn, WhatsApp) --}}
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->meta_title ?: $post->title }}">
    <meta property="og:description" content="{{ $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 160)) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($post->image)
    <meta property="og:image" content="{{ asset('storage/' . $post->image) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="675">
    @endif
    <meta property="og:site_name" content="KAAFI Hospitals">
    <meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
    @if($post->category)
    <meta property="article:section" content="{{ $post->category->name }}">
    @endif

    {{-- Twitter/X Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->meta_title ?: $post->title }}">
    <meta name="twitter:description" content="{{ $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 160)) }}">
    @if($post->image)
    <meta name="twitter:image" content="{{ asset('storage/' . $post->image) }}">
    @endif

    {{-- Schema.org Article --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Article",
      "headline": "{{ $post->meta_title ?: $post->title }}",
      "description": "{{ $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 160)) }}",
      @if($post->image)
      "image": "{{ asset('storage/' . $post->image) }}",
      @endif
      "datePublished": "{{ $post->published_at?->toIso8601String() }}",
      "dateModified": "{{ $post->updated_at->toIso8601String() }}",
      "author": {
        "@@type": "Person",
        "name": "{{ $post->user->name ?? 'KAAFI Hospitals' }}"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "KAAFI Hospitals",
        "logo": {
          "@@type": "ImageObject",
          "url": "{{ asset('images/og-image.jpg') }}"
        }
      },
      "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ url()->current() }}"
      }
    }
    </script>
@endpush

@section('content')
    {{-- Hero Image --}}
    <div class="relative bg-[#003B73]">
        @if($post->image)
        <div class="relative h-[400px] md:h-[500px]">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-[#003B73] via-[#003B73]/60 to-transparent"></div>
        </div>
        @else
        <div class="h-[300px] bg-gradient-to-br from-[#003B73] to-[#0062B8]"></div>
        @endif

        {{-- Post Title Overlay --}}
        <div class="absolute bottom-0 left-0 right-0 pb-12 pt-20 bg-gradient-to-t from-[#003B73] to-transparent">
            <div class="container mx-auto px-4 max-w-4xl">
                @if($post->category)
                <span class="inline-block bg-[#DC3545] text-white text-xs font-bold px-4 py-1.5 rounded-full mb-4 shadow-lg">{{ $post->category->name }}</span>
                @endif
                <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4">{{ $post->title }}</h1>
                <div class="flex flex-wrap items-center text-blue-200 text-sm space-x-4">
                    @if($post->user)
                    <span class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-[#0062B8] flex items-center justify-center text-white text-xs font-bold mr-2">{{ strtoupper(substr($post->user->name, 0, 1)) }}</div>
                        {{ $post->user->name }}
                    </span>
                    @endif
                    @if($post->published_at)
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $post->published_at->format('F d, Y') }}
                    </span>
                    @endif
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Article Body --}}
    <article class="container mx-auto px-4 max-w-4xl py-12">
        {{-- Excerpt / Lead --}}
        @if($post->excerpt)
        <div class="mb-10 text-xl text-gray-600 font-medium leading-relaxed border-l-4 border-[#0062B8] pl-6 italic">
            {{ $post->excerpt }}
        </div>
        @endif

        {{-- Content --}}
        <div class="prose prose-lg max-w-none 
            prose-headings:text-[#003B73] prose-headings:font-extrabold
            prose-a:text-[#0062B8] prose-a:no-underline hover:prose-a:underline
            prose-img:rounded-xl prose-img:shadow-lg
            prose-blockquote:border-l-[#0062B8] prose-blockquote:bg-blue-50 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:rounded-r-lg
            prose-strong:text-[#003B73]
            prose-code:bg-gray-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-sm
            prose-table:border-collapse prose-th:bg-gray-50
            text-gray-700 leading-relaxed">
            {!! $post->content !!}
        </div>

        {{-- Tags / Category --}}
        @if($post->category)
        <div class="mt-10 flex items-center space-x-2">
            <span class="text-sm text-gray-500">Category:</span>
            <span class="bg-blue-50 text-[#0062B8] text-sm font-semibold px-4 py-1.5 rounded-full">{{ $post->category->name }}</span>
        </div>
        @endif

        {{-- Engagement Component --}}
        <livewire:blog-engagement :post="$post" />

        {{-- Back to Blog --}}
        <div class="mt-10 pt-8 border-t border-gray-200">
            <a href="/blog" class="inline-flex items-center text-[#0062B8] hover:text-[#003B73] font-semibold transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to All Posts
            </a>
        </div>
    </article>

    {{-- Related Posts --}}
    @if($relatedPosts->count() > 0)
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 max-w-7xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $related)
                <a href="/blog/{{ $related->slug }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <div class="h-48 overflow-hidden">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#003B73] to-[#0062B8] flex items-center justify-center">
                                <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-base font-bold text-gray-900 group-hover:text-[#0062B8] transition line-clamp-2">{{ $related->title }}</h3>
                        <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $related->excerpt ?: Str::limit(strip_tags($related->content), 100) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection
