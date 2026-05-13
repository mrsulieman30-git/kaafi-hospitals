@php
    $docName = $this->doctor->localized_name;
    $deptName = $this->doctor->department ? $this->doctor->department->localized_name : 'General Medicine';
    $speciality = $this->doctor->specialization ? $this->doctor->localized_bio : $deptName; // Fallback to bio if specialization not found or using bio as specialization
@endphp

<!-- PUSH TO HEAD: WhatsApp, Facebook, and Twitter Link Preview Cards -->
@section('seo')
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    
    <!-- Open Graph (WhatsApp, Facebook, LinkedIn) -->
    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $this->doctor->display_image }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="KAAFI Hospitals">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $this->doctor->display_image }}">

    <!-- Google Search Physician Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Physician",
      "name": "{{ $docName }}",
      "image": "{{ $this->doctor->display_image }}",
      "medicalSpecialty": "{{ $speciality }}",
      "hospitalAffiliation": {
        "@@type": "Hospital",
        "name": "KAAFI Hospitals"
      },
      "description": "{{ $seoDescription }}",
      "url": "{{ request()->url() }}",
      @if(!empty($this->workingDays))
      "openingHoursSpecification": [
        @foreach($this->workingDays as $day)
        {
          "@@type": "OpeningHoursSpecification",
          "dayOfWeek": "https://schema.org/{{ $day }}"
        }{{ $loop->last ? '' : ',' }}
        @endforeach
      ],
      @endif
      "potentialAction": {
        "@@type": "ReserveAction",
        "target": {
          "@@type": "EntryPoint",
          "urlTemplate": "{{ route('book.appointment', $this->doctor->id) }}",
          "inLanguage": ["en", "so"],
          "actionPlatform": [
            "http://schema.org/DesktopWebPlatform",
            "http://schema.org/MobileWebPlatform"
          ]
        },
        "result": {
          "@@type": "Reservation",
          "name": "Book Appointment"
        }
      }
    }
    </script>
@endsection

<div class="bg-gray-50 min-h-screen pb-24 font-sans">
    
    <!-- Top Nav -->
    <div class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
        <div class="container mx-auto px-4 max-w-5xl py-4 flex justify-between items-center">
            <a href="/doctors" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-[#0062B8] transition-colors group">
                <x-heroicon-m-arrow-left class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" />
                {{ __('Back to All Doctors') }}
            </a>
            
            <!-- Quick Share Button -->
            <button onclick="navigator.clipboard.writeText(window.location.href); alert('{{ __('Doctor profile link copied to clipboard!') }}');" class="text-xs font-bold text-[#0062B8] bg-blue-50 px-3 py-1.5 rounded-full hover:bg-blue-100 transition-colors flex items-center gap-1">
                <x-heroicon-o-share class="w-4 h-4" /> {{ __('Share Profile') }}
            </button>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-5xl pt-12">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden flex flex-col md:flex-row">
            
            <!-- Left Side: Image -->
            <div class="w-full md:w-2/5 h-[450px] md:h-auto relative bg-gray-100 group overflow-hidden">
                <img src="{{ $this->doctor->display_image }}" class="absolute inset-0 w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700" alt="{{ $docName }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
            </div>

            <!-- Right Side: Details -->
            <div class="w-full md:w-3/5 p-8 md:p-12 flex flex-col">
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-blue-50 text-[#0062B8] text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-full">
                            {{ $deptName }}
                        </span>
                        @if($this->doctor->is_active)
                        <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-600 uppercase tracking-widest px-2 py-1 bg-emerald-50 rounded-md">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> {{ __('Available') }}
                        </span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl md:text-5xl font-black text-[#003B73] mb-2 tracking-tight leading-tight">
                        {{ $docName }}
                    </h1>
                    <h2 class="text-xl md:text-2xl font-bold text-emerald-600 mb-6">
                        {{ $this->doctor->localized_title }}
                    </h2>
                </div>

                <!-- Live Schedule Display -->
                @if(!empty($this->workingDays))
                <div class="mb-8 bg-gray-50 border border-gray-100 rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <x-heroicon-s-clock class="w-4 h-4 text-blue-400" />
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Weekly Schedule') }}</h4>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            @php $isWorking = in_array($day, $this->workingDays); @endphp
                            <div class="px-3 py-1.5 rounded-xl text-xs font-black border transition-all {{ $isWorking ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-gray-100 border-gray-200 text-gray-300' }}">
                                {{ __(substr($day, 0, 3)) }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Description / Bio -->
                <div class="mb-10 flex-1">
                    <h3 class="text-[#003B73] font-black text-sm uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-4 h-[2px] bg-blue-500"></span> {{ __('Professional Bio') }}
                    </h3>
                    <div class="text-gray-600 leading-relaxed text-lg">
                        @if($this->doctor->localized_bio)
                            {!! $this->doctor->localized_bio !!}
                        @else
                            {{ $seoDescription }}
                        @endif
                    </div>
                </div>

                <!-- Call to action -->
                <div class="pt-8 border-t border-gray-100">
                    <a href="{{ route('book.appointment', $this->doctor->id) }}" class="group relative inline-flex w-full md:w-auto items-center justify-center gap-3 bg-red-600 text-white px-10 py-5 rounded-2xl font-black shadow-xl shadow-red-900/20 hover:bg-red-700 hover:shadow-2xl hover:shadow-red-900/40 transition-all transform hover:-translate-y-1 text-xl overflow-hidden">
                        <span class="absolute inset-0 bg-white/10 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 skew-x-12"></span>
                        <x-heroicon-o-calendar-days class="w-6 h-6" />
                        {{ __('Book Appointment') }}
                    </a>
                    <p class="text-center md:text-left text-xs text-gray-400 mt-4 font-medium italic">
                        * {{ __('Immediate confirmation once reception reviews your request.') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
