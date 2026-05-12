@extends('layouts.app')
@section('title', __('About Us') . ' - KAAFI Hospitals')
@section('content')
    @php
        // Fetch Map specifically to handle the JSON decode
        $coordsRaw = $siteSettings->get('location_coordinates');
        
        $lat = 11.2829; // Fallback (Bosaso)
        $lng = 49.1816; // Fallback (Bosaso)

        if ($coordsRaw) {
            $coords = is_string($coordsRaw) ? json_decode($coordsRaw, true) : $coordsRaw;
            if (isset($coords['lat']) && isset($coords['lng'])) {
                $lat = $coords['lat'];
                $lng = $coords['lng'];
            }
        }
    @endphp

    <!-- Compact About Title -->
    <div class="px-4 max-w-7xl mx-auto pt-6 pb-2 border-b border-gray-100 mb-8">
        <h1 class="text-2xl md:text-3xl font-black text-[#003B73]">{{ __('Contact KAAFI Hospitals') }}</h1>
        <p class="text-xs md:text-sm text-gray-500 mt-1">{{ __('We are here to help you 24/7') }}</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Left Column: Story & Info -->
            <div class="space-y-8">
                <!-- Story Section -->
                <div>
                    <h2 class="text-xl font-bold text-[#003B73] mb-3 flex items-center gap-2">
                        <x-heroicon-s-information-circle class="w-6 h-6 text-[#0062B8]" />
                        {{ __('Our Story') }}
                    </h2>
                    <div x-data="{ expanded: false }" class="relative">
                        <p :class="expanded ? '' : 'line-clamp-3 md:line-clamp-4'" class="text-gray-600 leading-relaxed text-sm md:text-base transition-all duration-300">
                            {{ __('KAAFI HOSPITALS is a private healthcare facility located in Bosaso, Bari region, Somalia. Established in February 2019, its primary objective is to advance healthcare services in Puntland and across the country. Since its inception, the hospital has positioned itself as one of the leading private medical centers in Bosaso, delivering a diverse range of healthcare services to the local community. Its strategic location—on the main road, opposite Shabeele Hotel—makes it easily accessible, allowing patients from all parts of the city and the region to reach the facility with ease.') }}
                        </p>
                        <button @click="expanded = !expanded" class="inline-flex items-center gap-1 text-[#0062B8] font-bold text-xs md:text-sm mt-2 hover:text-[#003B73] transition-colors group">
                            <span x-text="expanded ? '{{ __('Read Less') }}' : '{{ __('Read More') }}'"></span>
                            <svg :class="expanded ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Mission & Vision -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100">
                        <h3 class="font-bold text-[#003B73] mb-2">{{ __('Our Mission') }}</h3>
                        <p class="text-xs md:text-sm text-gray-600">{{ __('To meet the healthcare needs of the people living in Bari and the greater Puntland region by providing reliable, safe, and affordable medical services.') }}</p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <h3 class="font-bold text-[#003B73] mb-2">{{ __('Our Vision') }}</h3>
                        <p class="text-xs md:text-sm text-gray-600">{{ __('To become one of the premier healthcare providers in the region, recognized for high quality, easy accessibility, and patient-centered care.') }}</p>
                    </div>
                </div>

                <!-- Core Values -->
                <div>
                    <h2 class="text-xl font-bold text-[#003B73] mb-4">{{ __('Core Values') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                        <div class="flex gap-3">
                            <div class="bg-emerald-50 text-emerald-700 w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                                <x-heroicon-s-heart class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ __('Compassion') }}</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ __('Every patient is treated with care and respect.') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-blue-50 text-[#003B73] w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                                <x-heroicon-s-star class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ __('Excellence') }}</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ __('A steadfast commitment to delivering high-quality healthcare services.') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-indigo-50 text-indigo-700 w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                                <x-heroicon-s-shield-check class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ __('Integrity') }}</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ __('Transparency and honesty in all medical and administrative operations.') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-amber-50 text-amber-700 w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                                <x-heroicon-s-light-bulb class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ __('Innovation') }}</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ __('Utilizing modern technology and advanced methods to improve patient outcomes.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact Details & Map -->
            <div class="space-y-6">
                
                <!-- Contact Cards -->
                <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-gray-100 p-6 md:p-8">
                    <h2 class="text-xl font-bold text-[#003B73] mb-6">{{ __('Contact Information') }}</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-50 p-3 rounded-xl text-[#0062B8]">
                                <x-heroicon-s-map-pin class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ __('Location') }}</h4>
                                <p class="text-gray-500 text-sm mt-1">{{ $siteSettings->get('hospital_address', 'Bosaso, Somalia') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-emerald-50 p-3 rounded-xl text-emerald-600">
                                <x-heroicon-s-phone class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ __('Call Us') }}</h4>
                                <p class="text-gray-500 text-sm mt-1">{{ $siteSettings->get('contact_phone', '+252 615 666 999') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-amber-50 p-3 rounded-xl text-amber-600">
                                <x-heroicon-s-envelope class="w-6 h-6" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ __('Email Us') }}</h4>
                                <p class="text-gray-500 text-sm mt-1">{{ $siteSettings->get('contact_email', 'info@kaafihospitals.so') }}</p>
                            </div>
                        </div>

                        @if($siteSettings->get('whatsapp_number'))
                        <div class="flex items-start gap-4">
                            <div class="bg-green-50 p-3 rounded-xl text-green-600">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ __('WhatsApp Us') }}</h4>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings->get('whatsapp_number')) }}" target="_blank" class="text-[#25D366] font-bold text-sm mt-1 hover:underline">
                                    {{ $siteSettings->get('whatsapp_number') }}
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Beautiful Interactive Map Section -->
        <div class="bg-white rounded-3xl shadow-[0_10px_40px_rgba(0,59,115,0.08)] border border-gray-100 overflow-hidden mt-12">
            <!-- Map Header -->
            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#0062B8] shadow-sm">
                        <x-heroicon-s-map class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-xl md:text-2xl font-black text-[#003B73]">{{ __('Visit KAAFI Hospitals') }}</h3>
                        <p class="text-gray-500 font-medium text-sm">{{ __('Find us using the interactive map below.') }}</p>
                    </div>
                </div>
                
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lng }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-[#0062B8] text-white font-bold py-3 px-6 rounded-xl shadow-md hover:bg-[#003B73] hover:shadow-lg transition-all active:scale-95 text-sm">
                    <x-heroicon-o-paper-airplane class="w-5 h-5" /> {{ __('Get Directions') }}
                </a>
            </div>

            <!-- The Google Map -->
            <div class="w-full h-[350px] md:h-[450px] bg-gray-100 relative">
                <iframe 
                    src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=16&output=embed" 
                    class="absolute inset-0 w-full h-full border-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- Photo Gallery Section -->
        @php
            $gallery = $siteSettings->get('about_gallery', []);
            if(is_string($gallery)) {
                $gallery = json_decode($gallery, true) ?? [];
            }
        @endphp

        @if(!empty($gallery))
        <div class="mt-20">
            <div class="flex items-center gap-4 mb-10">
                <div class="h-px bg-gray-100 flex-grow"></div>
                <h2 class="text-2xl md:text-4xl font-black text-[#003B73] whitespace-nowrap">{{ __('Photo Gallery') }}</h2>
                <div class="h-px bg-gray-100 flex-grow"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="{ open: false, activeImg: '' }">
                @foreach($gallery as $photo)
                    <div class="relative group aspect-square rounded-3xl overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl transition-all duration-500" @click="open = true; activeImg = '{{ asset('storage/' . $photo) }}'">
                        <img src="{{ asset('storage/' . $photo) }}" alt="Hospital Gallery" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-[#003B73]/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                            <svg class="w-10 h-10 text-white transform scale-90 group-hover:scale-100 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        </div>
                    </div>
                @endforeach

                <!-- Fullscreen Modal Preview -->
                <div x-show="open" 
                     x-cloak 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-black/95 backdrop-blur-md" 
                     @keydown.escape.window="open = false">
                    
                    <button @click="open = false" class="absolute top-6 right-6 text-white hover:text-red-500 transition-colors p-2 bg-white/10 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <div class="max-w-5xl max-h-full flex items-center justify-center" @click.away="open = false">
                        <img :src="activeImg" class="max-w-full max-h-[85vh] rounded-2xl shadow-[0_0_100px_rgba(0,0,0,0.5)] border-4 border-white/10">
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection