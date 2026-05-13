@section('seo')
    <title>{{ __('Our Specialists') }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Meet our world-class medical team at KAAFI Hospitals. Book appointments with expert doctors and specialists across multiple departments.') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:title" content="{{ __('Our Specialists') }} | {{ config('app.name') }}">
    <meta property="og:description" content="{{ __('Meet our world-class medical team at KAAFI Hospitals. Book appointments with expert doctors and specialists across multiple departments.') }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->fullUrl() }}">
    <meta property="twitter:title" content="{{ __('Our Specialists') }} | {{ config('app.name') }}">
    <meta property="twitter:description" content="{{ __('Meet our world-class medical team at KAAFI Hospitals. Book appointments with expert doctors and specialists across multiple departments.') }}">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">
@endsection

<div class="bg-gray-50 min-h-screen pb-24 font-sans pt-8 lg:pt-12">
    
    <!-- Modern, Space-Saving Dashboard Toolbar -->
    <div class="container mx-auto px-4 max-w-7xl mb-8">
        <div class="bg-white p-6 lg:p-8 rounded-3xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            <!-- Left Side: Title & Info -->
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#0062B8] text-xs font-bold uppercase tracking-wider mb-3">
                    <x-heroicon-s-sparkles class="w-4 h-4" />
                    {{ __('Expert Care') }}
                </div>
                <h1 class="text-3xl lg:text-4xl font-black text-[#003B73] tracking-tight mb-2">{{ __('Our Specialists') }}</h1>
                <p class="text-gray-500 font-medium text-sm lg:text-base">{{ __('Find and book appointments with our world-class medical team.') }}</p>
            </div>

            <!-- Right Side: Search & Filter Controls -->
            <div class="flex flex-col sm:flex-row w-full lg:w-auto gap-3 lg:gap-4">
                
                <!-- Search Bar -->
                <div class="relative group min-w-[260px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400 group-focus-within:text-[#0062B8] transition-colors" />
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-11 pr-4 py-3.5 text-sm rounded-2xl border border-gray-200 focus:border-[#0062B8] focus:ring-4 focus:ring-blue-50 bg-gray-50 focus:bg-white text-gray-900 placeholder-gray-400 transition-all font-medium" placeholder="{{ __('Search doctor by name...') }}">
                </div>
                
                <!-- Department Selector -->
                <div class="relative group min-w-[220px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-heroicon-o-building-office class="h-5 w-5 text-gray-400 group-focus-within:text-[#0062B8] transition-colors" />
                    </div>
                    <select wire:model.live="department_id" class="block w-full pl-11 pr-10 py-3.5 text-sm rounded-2xl border border-gray-100 focus:border-[#0062B8] focus:ring-4 focus:ring-blue-50 bg-gray-50 focus:bg-white text-gray-900 transition-all font-medium appearance-none cursor-pointer">
                        <option value="">{{ __('All Departments') }}</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->localized_name }}</option>
                        @endforeach
                    </select>
                    <!-- Custom Dropdown Arrow -->
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <x-heroicon-m-chevron-down class="h-5 w-5 text-gray-400" />
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Doctors Grid -->
    <div class="container mx-auto px-4 max-w-7xl relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($doctors as $doctor)
                <div class="bg-white rounded-3xl overflow-hidden shadow-[0_10px_30px_rgba(0,59,115,0.06)] border border-gray-100 group hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,59,115,0.12)] transition-all duration-300 flex flex-col">
                    
                    <!-- Doctor Image -->
                    <div class="relative h-72 overflow-hidden bg-gray-100">
                        <img src="{{ $doctor->display_image }}" alt="Doctor Image" class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
                        
                        <!-- Department Badge -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="inline-block bg-[#003B73] text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-md border border-white/10 uppercase tracking-widest">
                                {{ $doctor->department ? $doctor->department->localized_name : __('General Medicine') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Doctor Info -->
                    <div class="p-6 flex flex-col flex-1 text-center items-center justify-between">
                        <div class="w-full">
                            <h3 class="text-xl font-black text-[#003B73] mb-1 line-clamp-1">
                                {{ $doctor->localized_name }}
                            </h3>
                            <p class="text-sm font-bold text-emerald-600 mb-4 line-clamp-1 uppercase tracking-wide">
                                {{ $doctor->localized_title }}
                            </p>
                        </div>

                        <!-- THE FIX: Real routing for Profile & Booking -->
                        <div class="flex gap-2 w-full mt-4">
                            <a href="{{ route('doctors.profile', $doctor->id) }}" class="flex-1 bg-white text-gray-700 font-bold py-3 rounded-xl border border-gray-200 hover:border-[#003B73] hover:text-[#003B73] transition-colors flex items-center justify-center text-sm shadow-sm">
                                {{ __('View Profile') }}
                            </a>
                            <a href="{{ route('book.appointment', $doctor->id) }}" class="flex-[1.5] bg-[#0062B8] text-white font-bold py-3 rounded-xl border border-transparent hover:bg-[#003B73] shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm group/btn">
                                <x-heroicon-o-calendar-days class="w-4 h-4 group-hover/btn:animate-bounce" />
                                {{ __('Book') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-lg mb-6">
                        <x-heroicon-o-users class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-2xl font-black text-[#003B73] mb-2">{{ __('No doctors found') }}</h3>
                    <p class="text-gray-500 font-medium">{{ __('Try adjusting your search or department filter.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
