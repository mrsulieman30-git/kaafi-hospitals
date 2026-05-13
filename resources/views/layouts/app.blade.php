<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @php
        $hospitalName = $siteSettings->get('hospital_name', 'KAAFI Hospitals');
        $hospitalDescription = __('KAAFI Hospitals provides world-class healthcare with compassionate care and medical excellence in Somalia.');
        $defaultOgImage = $siteSettings->get('logo_path') ? asset('storage/' . $siteSettings->get('logo_path')) : asset('images/og-image.jpg');
    @endphp

    <!-- Dynamic SEO Meta Tags -->
    @if(View::hasSection('seo'))
        @yield('seo')
    @else
        <title>{{ $hospitalName }} - {{ __('Keeping You Well') }}</title>
        <meta name="description" content="{{ $hospitalDescription }}">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:title" content="{{ $hospitalName }}">
        <meta property="og:description" content="{{ $hospitalDescription }}">
        <meta property="og:image" content="{{ $defaultOgImage }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ request()->fullUrl() }}">
        <meta property="twitter:title" content="{{ $hospitalName }}">
        <meta property="twitter:description" content="{{ $hospitalDescription }}">
        <meta property="twitter:image" content="{{ $defaultOgImage }}">
    @endif
    @stack('seo')
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Hospital",
      "name": "KAAFI Hospitals",
      "image": "{{ asset('images/og-image.jpg') }}",
      "@@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "+252 61 0000000",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Main Street",
        "addressLocality": "Mogadishu",
        "addressCountry": "SO"
      }
    }
    </script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Tailwind CSS (CDN for quick dev, will use Vite for prod) -->
   
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased text-gray-800 bg-white overflow-x-hidden">

    @php
        $globalSettings = [
            'emergency_phone' => $siteSettings->get('emergency_phone', '+252 90 666 0001'),
            'additional_phones' => $siteSettings->get('additional_phones', []),
            'hospital_email' => $siteSettings->get('contact_email', 'info@kaafihospitals.so'),
            'hospital_address' => $siteSettings->get('hospital_address', 'Wadajir District, Mogadishu, Somalia'),
            'city_name' => $siteSettings->get('city_name', 'Mogadishu'),
        ];
        $logoPath = $siteSettings->get('logo_path') ? asset('storage/' . $siteSettings->get('logo_path')) : asset('images/logo.png');

        $menuDepartments = \App\Models\Department::whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn($q) => $q->where('is_active', true)])
            ->get();
    @endphp

    <div class="bg-[#003B73] text-white text-[10px] md:text-xs font-medium py-2 px-4 border-b border-blue-800/30">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-y-2">
            
            <div class="flex items-center gap-3 sm:gap-6 shrink-0" x-data="{ expanded: false }">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>{{ $globalSettings['city_name'] }}</span>
                </span>
                
                <div class="relative flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <div class="flex items-center gap-1 cursor-pointer group" @click="expanded = !expanded">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $globalSettings['emergency_phone']) }}" class="font-bold hover:text-blue-200 transition-colors">{{ $globalSettings['emergency_phone'] }}</a>
                        @if(!empty($globalSettings['additional_phones']))
                            <svg :class="expanded ? 'rotate-180' : ''" class="w-3 h-3 text-blue-300 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        @endif
                    </div>

                    <!-- Expandable Dropdown -->
                    @if(!empty($globalSettings['additional_phones']))
                    <div x-show="expanded" x-cloak @click.away="expanded = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute top-full left-0 mt-2 w-48 bg-white text-gray-800 rounded-xl shadow-2xl py-2 z-[60] border border-gray-100 overflow-hidden">
                        <div class="px-4 py-1 text-[9px] font-black text-blue-500 uppercase tracking-widest border-b border-gray-50 mb-1">
                            {{ __('All Contacts') }}
                        </div>
                        @foreach($globalSettings['additional_phones'] as $phone)
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone['number']) }}" class="flex items-center justify-between px-4 py-2 hover:bg-blue-50 transition-colors group/num">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-[#003B73] group-hover/num:text-[#0062B8]">{{ $phone['number'] }}</span>
                                    @if(!empty($phone['label']))
                                        <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tighter">{{ $phone['label'] }}</span>
                                    @endif
                                </div>
                                <svg class="w-3 h-3 text-emerald-500 opacity-0 group-hover/num:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 005.47 5.47l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                <span class="hidden lg:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <a href="mailto:{{ $globalSettings['hospital_email'] }}" class="hover:text-blue-200">{{ $globalSettings['hospital_email'] }}</a>
                </span>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                <div class="hidden md:flex items-center gap-3 border-r border-blue-800/50 pr-4 mr-1">
                    <a href="/about" class="hover:text-blue-200 transition-colors">{{ __('About Us') }}</a>
                    <a href="#" class="hover:text-blue-200 transition-colors">{{ __('Careers') }}</a>
                    <a href="/posts" class="hover:text-blue-200 transition-colors">{{ __('News & Updates') }}</a>
                </div>

                @if($siteSettings->get('whatsapp_number'))
                    @php
                        $waNumber = preg_replace('/[^0-9]/', '', $siteSettings->get('whatsapp_number'));
                    @endphp
                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer" class="flex items-center transition-transform hover:scale-110" title="Chat on WhatsApp">
                        {{-- Desktop Button --}}
                        <div class="hidden sm:flex items-center gap-1.5 px-2 py-1 bg-[#25D366] hover:bg-green-600 rounded transition-colors">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                            <span class="font-bold text-[10px] text-white">WhatsApp</span>
                        </div>
                        {{-- Mobile Icon --}}
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" class="w-6 h-6 sm:hidden">
                    </a>
                @endif

                @if(app()->getLocale() === 'so')
                    <a href="{{ route('language.switch', 'en') }}" class="flex items-center gap-1.5 px-2 py-1 bg-white/10 hover:bg-white/20 rounded transition-colors" title="Switch to English">
                        <img src="https://flagcdn.com/w40/us.png" alt="English" class="w-4 h-3 object-cover rounded-sm shadow-sm">
                        <span class="font-bold text-[10px] text-white uppercase">Eng</span>
                    </a>
                @else
                    <a href="{{ route('language.switch', 'so') }}" class="flex items-center gap-1.5 px-2 py-1 bg-white/10 hover:bg-white/20 rounded transition-colors" title="Ku beddel Soomaali">
                        <img src="https://flagcdn.com/w40/so.png" alt="Somali" class="w-4 h-3 object-cover rounded-sm shadow-sm">
                        <span class="font-bold text-[10px] text-white uppercase">Som</span>
                    </a>
                @endif

                <span class="hidden sm:inline-flex bg-red-500 text-white px-2 py-0.5 rounded text-[10px] font-bold animate-pulse">
                    {{ __('24/7 Emergency') }}
                </span>
            </div>
        </div>
    </div>

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center shrink-0">
                    <a href="/" class="flex items-center gap-3">
                        <div class="flex items-center">
                            @if($siteSettings->get('logo_path'))
                                {{-- Dynamic Logo from Admin Settings --}}
                                <img src="{{ asset('storage/' . $siteSettings->get('logo_path')) }}" 
                                     alt="{{ $siteSettings->get('hospital_name', 'KAAFI Hospitals') }}" 
                                     class="h-10 md:h-12 w-auto object-contain"
                                     style="height: {{ $siteSettings->get('logo_height', 48) }}px;">
                            @else
                                {{-- Default SVG Logo --}}
                                <svg class="w-10 h-10 md:w-12 md:h-12 text-[#DC3545]" viewBox="0 0 100 100" fill="currentColor">
                                    <path d="M 50 10 C 25 10 10 30 10 50 C 10 70 25 90 50 90 C 75 90 90 75 90 60 L 75 60 C 75 70 65 75 50 75 C 35 75 25 60 25 50 C 25 40 35 25 50 25 C 65 25 75 35 75 45 L 90 45 C 90 25 75 10 50 10 Z" fill="#DC3545"/>
                                    <path d="M 50 20 C 30 20 18 35 18 50 C 18 65 30 80 50 80" stroke="#003B73" stroke-width="6" fill="none"/>
                                </svg>
                                <div class="ml-2 flex flex-col justify-center leading-none hidden sm:flex">
                                    <div class="flex items-baseline">
                                        <span class="text-[#DC3545] font-bold text-xl md:text-2xl tracking-tight">KAAFI</span>
                                        <span class="text-[#003B73] font-bold text-lg md:text-xl tracking-tight ml-1">HOSPITALS</span>
                                    </div>
                                    <span class="text-[#0062B8] font-semibold text-[0.6rem] tracking-widest mt-1 uppercase">Keeping You Well</span>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="hidden xl:flex items-center gap-3 lg:gap-6">
                    <a href="/" class="flex flex-col items-center group {{ request()->is('/') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                        <svg class="w-5 h-5 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[11px] lg:text-xs font-bold leading-tight whitespace-nowrap">{{ __('Home') }}</span>
                    </a>
                    <a href="/about" class="flex flex-col items-center group {{ request()->is('about') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                        <svg class="w-5 h-5 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-[11px] lg:text-xs font-bold leading-tight whitespace-nowrap">{{ __('About Us') }}</span>
                    </a>
                    <div class="relative group flex flex-col items-center" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="/departments" class="flex flex-col items-center group {{ request()->is('departments*') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                            <svg class="w-5 h-5 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-[11px] lg:text-xs font-bold leading-tight whitespace-nowrap">{{ __('Services') }}</span>
                        </a>
                        
                        <div x-show="open" x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute left-1/2 -translate-x-1/2 top-full w-64 bg-white border border-gray-100 shadow-2xl rounded-2xl py-3 mt-1 z-[100]">
                            @foreach($menuDepartments as $dept)
                                <div class="relative group/sub" x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                    <a href="{{ route('departments.show', $dept->slug) }}" class="flex items-center justify-between px-5 py-2.5 text-sm font-bold text-[#003B73] hover:bg-blue-50 hover:text-[#0062B8] transition">
                                        <span>{{ $dept->localized_name }}</span>
                                        @if($dept->children->count() > 0)
                                            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        @endif
                                    </a>
                                    
                                    @if($dept->children->count() > 0)
                                        <div x-show="subOpen" x-cloak 
                                             class="absolute left-full top-0 w-64 bg-white border border-gray-100 shadow-2xl rounded-2xl py-3 ml-1 z-[101]">
                                            @foreach($dept->children as $child)
                                                <a href="{{ route('departments.show', $child->slug) }}" class="block px-5 py-2.5 text-sm font-bold text-[#003B73] hover:bg-blue-50 hover:text-[#0062B8] transition border-l-2 border-transparent hover:border-blue-500">
                                                    {{ $child->localized_name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="border-t border-gray-50 mt-2 pt-2 px-2">
                                <a href="/departments" class="flex items-center justify-center gap-2 py-2 text-xs font-black text-[#DC3545] hover:bg-red-50 rounded-xl transition uppercase tracking-wider">
                                    {{ __('All Services') }} <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="/doctors" class="flex flex-col items-center group {{ request()->is('doctors') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                        <svg class="w-5 h-5 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-[11px] lg:text-xs font-bold leading-tight whitespace-nowrap">{{ __('Doctors') }}</span>
                    </a>
                    <a href="/about" class="flex flex-col items-center group text-[#003B73] hover:text-[#0062B8] transition">
                        <svg class="w-5 h-5 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-[11px] lg:text-xs font-bold leading-tight whitespace-nowrap">{{ __('Patients & Visitors') }}</span>
                    </a>
                    <a href="/posts" class="flex flex-col items-center group {{ request()->is('posts*') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                        <svg class="w-5 h-5 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        <span class="text-[11px] lg:text-xs font-bold leading-tight whitespace-nowrap">{{ __('Blog') }}</span>
                    </a>
                    <a href="/contact" class="flex flex-col items-center group {{ request()->is('contact') ? 'text-[#0062B8]' : 'text-[#003B73] hover:text-[#0062B8]' }} transition">
                        <svg class="w-5 h-5 mb-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-[11px] lg:text-xs font-bold leading-tight whitespace-nowrap">{{ __('Contact') }}</span>
                    </a>
                </div>

                <div class="flex items-center gap-4 shrink-0">
                    <a href="/appointment" class="hidden sm:inline-flex items-center justify-center bg-red-600 text-white font-bold text-sm px-4 lg:px-6 py-2.5 rounded-xl shadow-md hover:bg-red-700 hover:shadow-lg transition-all">
                        <svg class="w-5 h-5 mr-2 opacity-90 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="whitespace-nowrap">{{ __('Book Appointment') }}</span>
                    </a>

                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden p-2 text-[#003B73] rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <div x-show="mobileMenuOpen" x-collapse x-cloak class="xl:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 z-40">
            <div class="px-4 py-6 flex flex-col gap-4">
                <a href="/" class="text-base font-bold {{ request()->is('/') ? 'text-[#0062B8]' : 'text-gray-800' }}">{{ __('Home') }}</a>
                <a href="/about" class="text-base font-bold {{ request()->is('about') ? 'text-[#0062B8]' : 'text-gray-800' }}">{{ __('About Us') }}</a>
                <div x-data="{ servicesOpen: false }">
                    <div class="flex items-center justify-between">
                        <a href="/departments" class="text-base font-bold {{ request()->is('departments*') ? 'text-[#0062B8]' : 'text-gray-800' }}">{{ __('Services') }}</a>
                        <button @click="servicesOpen = !servicesOpen" class="p-2 bg-gray-50 rounded-lg">
                            <svg :class="servicesOpen ? 'rotate-180' : ''" class="w-5 h-5 transition-transform text-[#003B73]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>
                    <div x-show="servicesOpen" x-collapse x-cloak class="mt-2 ml-2 pl-4 border-l-2 border-blue-100 flex flex-col gap-4 py-2">
                        @foreach($menuDepartments as $dept)
                            <div x-data="{ subOpen: false }">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('departments.show', $dept->slug) }}" class="text-sm font-bold text-gray-700">{{ $dept->localized_name }}</a>
                                    @if($dept->children->count() > 0)
                                        <button @click="subOpen = !subOpen" class="p-1">
                                            <svg :class="subOpen ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                    @endif
                                </div>
                                @if($dept->children->count() > 0)
                                    <div x-show="subOpen" x-collapse x-cloak class="mt-2 ml-2 pl-3 border-l border-gray-200 flex flex-col gap-3">
                                        @foreach($dept->children as $child)
                                            <a href="{{ route('departments.show', $child->slug) }}" class="text-xs font-semibold text-gray-500 hover:text-[#0062B8]">{{ $child->localized_name }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <a href="/departments" class="text-xs font-black text-[#DC3545] uppercase tracking-wider pt-2">{{ __('View All Services') }}</a>
                    </div>
                </div>
                <a href="/doctors" class="text-base font-bold {{ request()->is('doctors') ? 'text-[#0062B8]' : 'text-gray-800' }}">{{ __('Doctors') }}</a>
                <a href="/posts" class="text-base font-bold {{ request()->is('posts*') ? 'text-[#0062B8]' : 'text-gray-800' }}">{{ __('Latest News') }}</a>
                <a href="/contact" class="text-base font-bold {{ request()->is('contact') ? 'text-[#0062B8]' : 'text-gray-800' }}">{{ __('Contact') }}</a>
                <div class="pt-4 border-t border-gray-100">
                    <a href="/appointment" class="w-full flex items-center justify-center bg-red-600 text-white font-bold text-base px-6 py-3 rounded-xl shadow-md">
                        <svg class="w-5 h-5 mr-2 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('Book Appointment') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="bg-kaafi-navy text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-2xl font-bold mb-4">KAAFI <span class="text-blue-300">HOSPITALS</span></h3>
                    <p class="text-blue-100 mb-6">{{ __('Providing world-class healthcare') }}. {{ __('Keeping You Well. We are committed to providing compassionate, high-quality healthcare for you and your family.') }}</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center hover:bg-kaafi-blue transition">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center hover:bg-kaafi-blue transition">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4 border-b border-blue-800 pb-2 inline-block">{{ __('Quick Links') }}</h4>
                    <ul class="space-y-2 text-blue-100">
                        <li><a href="/" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Home') }}</a></li>
                        <li><a href="/about" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('About Us') }}</a></li>
                        <li><a href="/departments" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Departments') }}</a></li>
                        <li><a href="/doctors" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Doctors') }}</a></li>
                        <li><a href="/blog" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Latest News') }}</a></li>
                        <li><a href="/contact" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Contact Us') }}</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4 border-b border-blue-800 pb-2 inline-block">{{ __('Our Departments') }}</h4>
                    <ul class="space-y-2 text-blue-100">
                        <li><a href="/departments/cardiology" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Cardiology') }}</a></li>
                        <li><a href="/departments/neurology" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Neurology') }}</a></li>
                        <li><a href="/departments/pediatrics" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Pediatrics') }}</a></li>
                        <li><a href="/departments/orthopedics" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Orthopedics') }}</a></li>
                        <li><a href="/departments/laboratory" class="hover:text-white transition flex items-center"><span class="mr-2">›</span> {{ __('Laboratory') }}</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-4 border-b border-blue-800 pb-2 inline-block">{{ __('Contact Information') }}</h4>
                    <ul class="space-y-4 text-blue-100">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-1 text-kaafi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Wadajir District,<br>Mogadishu, Somalia</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-kaafi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+252 615 666 999</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-kaafi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>info@kaafihospitals.so</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-blue-900 pt-6 text-center text-sm text-blue-200 flex flex-col md:flex-row justify-between items-center">
                <p>&copy; {{ date('Y') }} KAAFI Hospitals. {{ __('All Rights Reserved') }}.</p>
                <div class="mt-4 md:mt-0 space-x-4">
                    <a href="#" class="hover:text-white transition">{{ __('Privacy Policy') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('Terms of Service') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AI Chatbot Placeholder (Livewire Component will go here) -->
    <livewire:ai-chat-widget />
    
    @livewireScripts
</body>
</html>
