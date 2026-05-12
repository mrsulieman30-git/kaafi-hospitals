@extends('layouts.app')
@section('title', $department->name . ' - KAAFI Hospitals')
@section('content')
<div class="bg-kaafi-light py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-kaafi-navy">{{ $department->name }}</h1>
    </div>
</div>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        @if($department->image)
            <img class="w-full h-96 object-cover object-center" src="{{ asset('storage/' . $department->image) }}" alt="{{ $department->name }}">
        @else
            <div class="w-full h-64 bg-blue-100 text-kaafi-blue flex items-center justify-center">
                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        @endif
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('About Department') }}</h2>
            <div class="prose max-w-none text-gray-600 mb-8">
                {!! $department->description !!}
            </div>
            
            @if($department->children->count() > 0)
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-t pt-8">{{ __('Our Branches') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
                    @foreach($department->children as $subDept)
                        <a href="{{ route('departments.show', $subDept->slug) }}" class="group bg-white rounded-[2rem] overflow-hidden transition-all duration-500 border border-gray-100 hover:border-blue-200 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_50px_rgba(0,59,115,0.12)] hover:-translate-y-3 flex flex-col h-full">
                            {{-- Image Container --}}
                            <div class="h-52 w-full bg-blue-50 relative overflow-hidden shrink-0">
                                @if($subDept->image)
                                    <img src="{{ asset('storage/' . $subDept->image) }}" alt="{{ $subDept->localized_name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[#0062B8]">
                                        <svg class="w-16 h-16 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                @endif
                                
                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-[#003B73]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6">
                                    <div class="flex items-center gap-2 text-white text-xs font-black uppercase tracking-[0.2em] transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                        {{ __('Explore Branch') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-7 flex flex-col flex-grow bg-white">
                                <h3 class="font-black text-[#003B73] text-xl group-hover:text-[#0062B8] transition-colors duration-300 leading-tight mb-3">
                                    {{ $subDept->localized_name }}
                                </h3>
                                @if($subDept->description)
                                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 mb-4">
                                        {{ strip_tags($subDept->description) }}
                                    </p>
                                @endif
                                <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Department') }}</span>
                                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[#0062B8] group-hover:bg-[#0062B8] group-hover:text-white transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($department->doctors()->where('is_active', true)->count() > 0)
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-t pt-8">{{ __('Our Specialists') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($department->doctors()->where('is_active', true)->get() as $doctor)
                        <div class="bg-gray-50 rounded-2xl p-5 text-center border border-gray-100 hover:shadow-md transition-all">
                            <div class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-4 border-2 border-white shadow-sm">
                                <img src="{{ $doctor->display_image }}" alt="{{ $doctor->localized_name }}" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-bold text-gray-900">{{ $doctor->localized_name }}</h3>
                            <p class="text-xs font-bold text-[#0062B8] mb-4 uppercase tracking-wider">{{ $doctor->localized_title }}</p>
                            <a href="{{ route('doctors.profile', $doctor->id) }}" class="inline-flex items-center justify-center w-full text-xs font-bold text-white bg-[#0062B8] py-2.5 rounded-xl hover:bg-[#003B73] transition-all">
                                {{ __('View Profile') }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
