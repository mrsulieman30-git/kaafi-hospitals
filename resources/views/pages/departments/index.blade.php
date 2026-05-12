@extends('layouts.app')
@section('title', 'Departments - KAAFI Hospitals')
@section('content')
<div class="bg-kaafi-light py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-kaafi-navy">{{ __('Our Departments') }}</h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">{{ __('Comprehensive healthcare services under one roof.') }}</p>
    </div>
</div>
<div class="container mx-auto px-4 py-16">
    @php
        $departments = \App\Models\Department::where('is_active', true)->get();
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($departments as $dept)
        <a href="{{ route('departments.show', $dept->slug) }}" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 block">
            <div class="h-48 overflow-hidden relative bg-blue-50">
                @if($dept->image)
                    <img class="w-full h-full object-cover object-center" src="{{ asset('storage/' . $dept->image) }}" alt="{{ $dept->name }}">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-kaafi-blue opacity-50">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
            <div class="p-6 text-center">
                <h3 class="text-xl font-bold text-gray-900">{{ $dept->name }}</h3>
                <span class="inline-block mt-3 text-kaafi-blue font-semibold hover:text-blue-800 text-sm">{{ __('View Profile') }} &rarr;</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection