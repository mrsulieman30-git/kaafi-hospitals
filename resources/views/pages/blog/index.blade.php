@extends('layouts.app')
@section('title', 'Health News & Blog - KAAFI Hospitals')
@section('meta_description', 'Stay updated with the latest medical research, health tips, and hospital news from KAAFI Hospitals.')

@section('content')
    {{-- Hero Banner --}}
    <div class="relative bg-gradient-to-br from-[#003B73] via-[#0052a0] to-[#0062B8] py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><defs><pattern id="blogGrid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(#blogGrid)"/></svg>
        </div>
        <div class="relative container mx-auto px-4 text-center max-w-4xl">
            <span class="inline-block bg-white/20 text-white text-sm font-semibold px-4 py-1.5 rounded-full mb-6 backdrop-blur-sm">📰 Our Blog</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">Health News & Insights</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">Stay updated with the latest medical research, health tips, and news from KAAFI Hospitals.</p>
        </div>
    </div>

    {{-- Blog Grid --}}
    <div class="container mx-auto px-4 py-16 max-w-7xl">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
                    {{-- Image --}}
                    <div class="relative h-56 overflow-hidden">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#003B73] to-[#0062B8] flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                        @endif
                        @if($post->category)
                        <span class="absolute top-4 left-4 bg-white/95 text-[#003B73] text-xs font-bold px-3 py-1 rounded-full shadow-sm backdrop-blur-sm">{{ $post->category->name }}</span>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center text-xs text-gray-400 mb-3 space-x-3">
                            @if($post->published_at)
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                            @endif
                            @if($post->user)
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $post->user->name }}
                            </span>
                            @endif
                        </div>

                        <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-[#0062B8] transition line-clamp-2">
                            <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                        </h2>

                        <p class="text-gray-500 text-sm leading-relaxed mb-4 flex-1 line-clamp-3">
                            {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
                            <div class="flex items-center space-x-4 text-xs text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    {{ $post->likes_count }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    {{ $post->comments->where('is_approved', true)->count() }}
                                </span>
                            </div>
                            <a href="/blog/{{ $post->slug }}" class="text-[#0062B8] font-semibold text-sm hover:text-[#003B73] transition flex items-center">
                                Read More <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-24 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                <h3 class="mt-4 text-xl font-bold text-gray-700">No posts yet</h3>
                <p class="mt-2 text-gray-500">Check back later for new articles and health updates.</p>
            </div>
        @endif
    </div>
@endsection