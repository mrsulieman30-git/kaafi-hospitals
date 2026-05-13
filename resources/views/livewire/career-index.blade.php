@section('seo')
    <title>{{ __('Careers & Opportunities') }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('Join our team of medical professionals and staff. Explore job openings, internships, and volunteering opportunities at KAAFI Hospitals.') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:title" content="{{ __('Careers & Opportunities') }} | {{ config('app.name') }}">
    <meta property="og:description" content="{{ __('Join our team of medical professionals and staff. Explore job openings, internships, and volunteering opportunities at KAAFI Hospitals.') }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
@endsection

<div class="bg-gray-50 min-h-screen pb-24 font-sans">
    
    <!-- Premium Hero Section -->
    <div class="relative bg-gradient-to-br from-[#003B73] via-[#0062B8] to-[#003B73] py-20 overflow-hidden shadow-lg mb-12">
        <div class="absolute inset-0 opacity-10">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full fill-white"><path d="M0 0 L100 100 L0 100 Z"/></svg>
        </div>
        
        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="text-center md:text-left">
                    <span class="inline-block bg-white/10 backdrop-blur-md text-white text-xs font-black uppercase tracking-[0.2em] px-4 py-2 rounded-full mb-6 border border-white/20">
                        {{ __('Join Our Mission') }}
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6 leading-tight">
                        {{ __('Build Your Career') }}<br>
                        <span class="text-blue-200">{{ __('With KAAFI Hospitals') }}</span>
                    </h1>
                    <p class="text-blue-100 text-lg md:text-xl font-medium max-w-2xl leading-relaxed">
                        {{ __('We are looking for passionate individuals to join our team of medical professionals and staff in delivering excellence in healthcare.') }}
                    </p>
                </div>
                
                <div class="hidden lg:block w-72 h-72 bg-white/5 backdrop-blur-3xl rounded-[3rem] border border-white/10 p-8 rotate-3">
                    <x-heroicon-o-briefcase class="w-full h-full text-white/20" />
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="container mx-auto px-4 max-w-7xl -mt-24 relative z-20 mb-16">
        <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-gray-100">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Search Input -->
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="h-6 w-6 text-gray-400 group-focus-within:text-[#0062B8] transition-colors" />
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" 
                        class="block w-full pl-14 pr-6 py-5 text-base rounded-2xl border border-gray-100 focus:border-[#0062B8] focus:ring-8 focus:ring-blue-50 bg-gray-50 focus:bg-white text-gray-900 placeholder-gray-400 transition-all font-bold" 
                        placeholder="{{ __('Search for titles, roles, or keywords...') }}">
                </div>

                <!-- Type Filter -->
                <div class="lg:w-72 relative">
                    <select wire:model.live="type" 
                        class="block w-full pl-6 pr-12 py-5 text-base rounded-2xl border border-gray-100 focus:border-[#0062B8] focus:ring-8 focus:ring-blue-50 bg-gray-50 focus:bg-white text-gray-900 transition-all font-bold appearance-none cursor-pointer">
                        <option value="">{{ __('All Categories') }}</option>
                        <option value="job">{{ __('Full-time Jobs') }}</option>
                        <option value="internship">{{ __('Internships') }}</option>
                        <option value="training">{{ __('Training') }}</option>
                        <option value="volunteering">{{ __('Volunteering') }}</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                        <x-heroicon-m-chevron-down class="h-6 w-6 text-gray-400" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job List Grid -->
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($jobs as $job)
                <div class="bg-white rounded-[2rem] overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-gray-100 group hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,59,115,0.1)] transition-all duration-500 flex flex-col h-full">
                    
                    <!-- Content -->
                    <div class="p-8 flex flex-col flex-1">
                        <div class="flex items-center justify-between mb-6">
                            <span @class([
                                'px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border',
                                'bg-emerald-50 text-emerald-700 border-emerald-100' => $job->type === 'job',
                                'bg-amber-50 text-amber-700 border-amber-100' => $job->type === 'internship',
                                'bg-blue-50 text-blue-700 border-blue-100' => $job->type === 'training',
                                'bg-purple-50 text-purple-700 border-purple-100' => $job->type === 'volunteering',
                            ])>
                                {{ __($job->type) }}
                            </span>
                            @if($job->deadline)
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">
                                    {{ __('Deadline') }}: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-2xl font-black text-[#003B73] mb-4 line-clamp-2 leading-tight group-hover:text-[#0062B8] transition-colors">
                            {{ $job->title }}
                        </h3>
                        
                        <div class="flex items-center gap-2 text-gray-500 text-sm font-bold mb-6">
                            <x-heroicon-o-map-pin class="w-4 h-4 text-[#0062B8]" />
                            {{ $job->location }}
                        </div>

                        <div class="prose prose-sm text-gray-500 line-clamp-3 mb-8">
                            {!! strip_tags($job->description) !!}
                        </div>

                        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="inline-flex items-center gap-2 text-sm font-black text-[#0062B8] group-hover:gap-3 transition-all">
                                {{ __('View Details') }}
                                <x-heroicon-m-arrow-right class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-gray-300" />
                    </div>
                    <h3 class="text-2xl font-black text-[#003B73] mb-2">{{ __('No opportunities found') }}</h3>
                    <p class="text-gray-500 font-medium">{{ __('Try adjusting your search filters or check back later.') }}</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16">
            {{ $jobs->links() }}
        </div>
    </div>
</div>
