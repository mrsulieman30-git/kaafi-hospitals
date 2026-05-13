@extends('layouts.app')
@section('seo')
    <title>{{ $page->title }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $page->title }} | {{ config('app.name') }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="{{ $page->title }} | {{ config('app.name') }}">
    <meta property="twitter:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">
@endsection

{{-- Use the SEO data you set in the Admin Panel --}}
@section('title', $page->title . ' - KAAFI Hospitals')
@section('meta_description', $page->meta_description ?? 'KAAFI Hospitals - Keeping You Well')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
            
            {{-- Header --}}
            <div class="bg-[#003B73] px-10 py-12 text-center relative overflow-hidden">
                <!-- Abstract curves for modern feel -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full"><path d="M0,0 C30,40 70,60 100,0 L100,100 L0,100 Z" fill="white"/></svg>
                </div>
                <h1 class="relative z-10 text-4xl md:text-5xl font-black text-white tracking-tight">{{ $page->title }}</h1>
            </div>

            {{-- Body Content --}}
            <div class="p-10 md:p-16">
                <!-- 
                    The 'prose' class is magic. It takes the raw HTML from your MS Word-style 
                    editor and applies professional, highly-readable typography rules to it.
                -->
                <article class="prose prose-lg md:prose-xl prose-blue max-w-none text-gray-700">
                    {!! $page->content !!}
                </article>
            </div>
            
        </div>
    </div>
</div>
@endsection
