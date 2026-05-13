@section('seo')
    <title>{{ $job->title }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($job->description), 160) }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:title" content="{{ $job->title }} | {{ config('app.name') }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($job->description), 160) }}">
    <meta property="og:image" content="{{ $job->image ? asset('storage/' . $job->image) : asset('images/og-image.jpg') }}">
@endsection

<div class="bg-gray-50 min-h-screen pb-24 font-sans">
    
    <!-- Compact Job Header -->
    <div class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
        <div class="container mx-auto px-4 max-w-5xl py-4 flex items-center justify-between">
            <a href="{{ route('careers.index') }}" class="flex items-center text-sm font-bold text-gray-500 hover:text-[#0062B8] transition-colors group">
                <x-heroicon-m-arrow-left class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" />
                {{ __('Back to Opportunities') }}
            </a>
            
            <button onclick="window.print()" class="p-2 text-gray-400 hover:text-[#003B73] transition-colors bg-gray-50 rounded-full" title="Print Job Details">
                <x-heroicon-m-printer class="w-5 h-5" />
            </button>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-5xl pt-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left: Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100 mb-8">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span @class([
                            'px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border',
                            'bg-emerald-50 text-emerald-700 border-emerald-100' => $job->type === 'job',
                            'bg-amber-50 text-amber-700 border-amber-100' => $job->type === 'internship',
                            'bg-blue-50 text-blue-700 border-blue-100' => $job->type === 'training',
                            'bg-purple-50 text-purple-700 border-purple-100' => $job->type === 'volunteering',
                        ])>
                            {{ __($job->type) }}
                        </span>
                        <span class="flex items-center gap-1.5 text-gray-400 text-sm font-bold bg-gray-50 px-4 py-2 rounded-xl">
                            <x-heroicon-o-map-pin class="w-4 h-4" />
                            {{ $job->location }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-black text-[#003B73] leading-tight mb-12">
                        {{ $job->title }}
                    </h1>

                    <!-- Description Section -->
                    <div class="mb-12">
                        <h3 class="text-xl font-black text-[#003B73] mb-6 flex items-center gap-3">
                            <span class="w-8 h-1 bg-blue-500 rounded-full"></span>
                            {{ __('Role Overview') }}
                        </h3>
                        <div class="prose prose-lg prose-blue max-w-none text-gray-600 leading-relaxed">
                            {!! $job->description !!}
                        </div>
                    </div>

                    <!-- Requirements Section -->
                    @if($job->requirements)
                    <div class="mb-12">
                        <h3 class="text-xl font-black text-[#003B73] mb-6 flex items-center gap-3">
                            <span class="w-8 h-1 bg-emerald-500 rounded-full"></span>
                            {{ __('Requirements & Qualifications') }}
                        </h3>
                        <div class="prose prose-lg prose-emerald max-w-none text-gray-600 leading-relaxed">
                            {!! $job->requirements !!}
                        </div>
                    </div>
                    @endif

                    <!-- Benefits Section -->
                    @if($job->benefits)
                    <div class="mb-8">
                        <h3 class="text-xl font-black text-[#003B73] mb-6 flex items-center gap-3">
                            <span class="w-8 h-1 bg-amber-500 rounded-full"></span>
                            {{ __('Benefits & Perks') }}
                        </h3>
                        <div class="prose prose-lg prose-amber max-w-none text-gray-600 leading-relaxed">
                            {!! $job->benefits !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right: Action Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-[#003B73] rounded-[2.5rem] p-8 md:p-10 text-white shadow-2xl mb-8 overflow-hidden relative">
                        <div class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                        
                        <h4 class="text-xl font-black mb-4 relative z-10">{{ __('Interested?') }}</h4>
                        <p class="text-blue-100 text-sm font-medium mb-8 relative z-10 leading-relaxed">
                            {{ __('Join KAAFI Hospitals and be part of a team dedicated to medical excellence.') }}
                        </p>

                        <div class="space-y-6 mb-10 relative z-10">
                            @if($job->deadline)
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                                    <x-heroicon-o-calendar class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-300">{{ __('Apply Before') }}</p>
                                    <p class="font-bold">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                                    <x-heroicon-o-envelope class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-300">{{ __('Send Application To') }}</p>
                                    <p class="font-bold">hr@kaafi.com</p>
                                </div>
                            </div>
                        </div>

                        <a href="mailto:hr@kaafi.com?subject=Application for {{ $job->title }}" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-black py-5 rounded-2xl text-center shadow-xl shadow-emerald-900/40 transition-all transform hover:-translate-y-1 relative z-10">
                            {{ __('Apply Now') }}
                        </a>
                    </div>

                    <!-- Trust Card -->
                    <div class="bg-blue-50 rounded-[2rem] p-8 border border-blue-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-[#0062B8] rounded-2xl flex items-center justify-center shadow-md">
                                <x-heroicon-s-shield-check class="w-6 h-6 text-white" />
                            </div>
                            <h5 class="font-black text-[#003B73]">{{ __('Verified Employer') }}</h5>
                        </div>
                        <p class="text-xs text-blue-700/70 font-medium leading-relaxed">
                            {{ __('KAAFI Hospitals is an equal opportunity employer. We value diversity and are committed to creating an inclusive environment for all employees.') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
