@extends('layouts.app')

@section('content')
    <livewire:smart-ad-widget />
    <!-- Hero Section -->
    <div class="relative w-full h-[600px] overflow-hidden">
        <!-- Dynamic Background Image -->
        @if($siteSettings->get('hero_bg_path'))
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $siteSettings->get('hero_bg_path')) }}'); opacity: {{ floatval($siteSettings->get('hero_bg_opacity', 10)) / 100 }};"></div>
        @else
            <img class="absolute inset-0 w-full h-full object-cover object-center" src="{{ asset('images/hospital-reception.jpg') }}" alt="Hospital Reception" onerror="this.src='https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'">
        @endif
        
        <!-- Gradient Overlay to make text readable on the left -->
        <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent"></div>
        
        <div class="relative max-w-7xl mx-auto h-full flex flex-col justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h1 class="text-5xl tracking-tight font-extrabold text-[#003B73] sm:text-6xl lg:text-7xl">
                    <span class="block">{{ __('Your Health,') }}</span>
                    <span class="block text-[#003B73]">{{ __('Our Priority') }}</span>
                </h1>
                <p class="mt-4 text-lg text-gray-700 sm:max-w-xl">
                    {{ __(':name is committed to providing compassionate, high-quality healthcare for you and your family.', ['name' => $siteSettings->get('hospital_name', 'KAAFI Hospitals')]) }}
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="/appointment" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-white bg-[#0062B8] hover:bg-blue-700 transition shadow-lg">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <div class="flex flex-col text-left">
                            <span class="text-base font-bold leading-tight">{{ __('Book Appointment') }}</span>
                        </div>
                    </a>
                    <a href="/departments" class="inline-flex items-center justify-center px-6 py-3 border border-[#0062B8] rounded-lg text-[#0062B8] bg-white hover:bg-blue-50 transition shadow-lg">
                        <svg class="w-6 h-6 mr-3 text-[#0062B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="flex flex-col text-left">
                            <span class="text-base font-bold leading-tight">{{ __('Our Services') }}</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Trust Indicators Bar -->
    <div class="bg-white shadow-xl relative z-20 -mt-12 mx-4 md:mx-auto max-w-6xl rounded-2xl p-6 md:p-8 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <div class="flex items-center justify-center md:justify-start px-4">
                <div class="flex-shrink-0 text-[#0062B8]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-gray-900 leading-tight">{{ __('Trusted Care') }}</h3>
                </div>
            </div>
            <div class="flex items-center justify-center md:justify-start px-4 pt-4 md:pt-0">
                <div class="flex-shrink-0 text-[#0062B8]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-gray-900 leading-tight">{{ __('Expert Doctors') }}</h3>
                </div>
            </div>
            <div class="flex items-center justify-center md:justify-start px-4 pt-4 md:pt-0">
                <div class="flex-shrink-0 text-[#0062B8]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-gray-900 leading-tight">{{ __('Advanced Technology') }}</h3>
                </div>
            </div>
            <div class="flex items-center justify-center md:justify-start px-4 pt-4 md:pt-0">
                <div class="flex-shrink-0 text-[#0062B8]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-gray-900 leading-tight">{{ __('24/7 Emergency') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Doctors Section -->
    <div class="bg-gray-50 py-20 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('Meet Our Specialists') }}
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    {{ __('Our team of experienced medical professionals is dedicated to providing you with the best possible care.') }}
                </p>
            </div>

            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($doctors as $doctor)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="h-64 overflow-hidden relative">
                        <img class="w-full h-full object-cover object-top" src="{{ $doctor->display_image }}" alt="{{ $doctor->localized_name }}">
                        <div class="absolute bottom-0 w-full bg-gradient-to-t from-[#003B73] to-transparent h-1/2 opacity-70"></div>
                        <div class="absolute bottom-4 left-4 text-white font-semibold">
                            {{ $doctor->department->localized_name ?? __('Specialist') }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900">{{ $doctor->localized_name }}</h3>
                        <p class="text-[#0062B8] font-medium mt-1">{{ $doctor->localized_title }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('doctors.profile', $doctor->id) }}" class="text-[#0062B8] hover:text-blue-800 font-semibold flex items-center">
                                {{ __('View Profile') }} <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <a href="/doctors" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-[#003B73] hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#003B73]">
                    {{ __('View All Doctors') }}
                </a>
            </div>
        </div>
    </div>
    <!-- Latest Health Insights Section -->
    <livewire:home-latest-blog />
@endsection
