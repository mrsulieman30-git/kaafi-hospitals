@extends('layouts.app')

@section('title', $doctor->name . ' - KAAFI Hospitals')

@php
    $workingDays = [];
    foreach($doctor->schedules->where('is_active', true) as $schedule) {
        $days = is_array($schedule->day_of_week) ? $schedule->day_of_week : [$schedule->day_of_week];
        $workingDays = array_merge($workingDays, $days);
    }
    $workingDays = array_unique($workingDays);
    $workingDaysJson = json_encode(array_values($workingDays));

    // YouTube Extraction Logic
    $videoId = null;
    if($doctor->youtube_video_url) {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $doctor->youtube_video_url, $match);
        $videoId = $match[1] ?? null;
    }
@endphp

@section('content')
<div class="bg-gray-50 min-h-screen py-16 relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-gradient-to-br from-[#0062B8]/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 max-w-7xl relative z-10">
        <nav class="mb-8 flex text-sm text-gray-500 font-medium">
            <a href="/" class="hover:text-[#0062B8] transition">{{ __('Home') }}</a>
            <span class="mx-2">/</span>
            <a href="/doctors" class="hover:text-[#0062B8] transition">{{ __('Our Doctors') }}</a>
            <span class="mx-2">/</span>
            <span class="text-[#003B73]">{{ $doctor->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-10">
            <!-- Left Column: Doctor Profile Card & Video -->
            <div class="lg:col-span-5 space-y-8">
                
                <!-- Main Profile Card -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-[#003B73] to-[#0062B8] relative">
                        <div class="absolute -bottom-16 w-full flex justify-center">
                            <div class="w-32 h-32 rounded-full border-4 border-white bg-white overflow-hidden shadow-lg">
                                <!-- Uses the cropped image from Filament, or fallback -->
                                <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://ui-avatars.com/api/?name='.urlencode($doctor->name).'&color=003B73&background=E8F4FD' }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-20 pb-10 px-8 text-center">
                        <h1 class="text-3xl font-black text-gray-900 mb-1">{{ $doctor->name }}</h1>
                        <p class="text-lg font-bold text-[#0062B8] mb-4">{{ $doctor->title }}</p>
                        
                        <div class="inline-flex items-center gap-2 bg-sky-50 text-sky-700 px-4 py-2 rounded-xl text-sm font-semibold mb-8">
                            <x-heroicon-o-building-office class="w-5 h-5" />
                            {{ $doctor->department->name ?? __('General Medicine') }}
                        </div>

                        <a href="/appointment" class="flex items-center justify-center gap-2 w-full bg-[#DC3545] hover:bg-red-700 text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-500/30 transition-all hover:-translate-y-1 mb-8">
                            <x-heroicon-o-calendar-days class="w-6 h-6" />
                            {{ __('Book Appointment') }}
                        </a>

                        @if($doctor->bio)
                            <div class="text-left pt-8 border-t border-gray-100">
                                <h3 class="text-[#003B73] font-black text-xs uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <span class="w-4 h-[2px] bg-blue-500"></span> {{ __('Professional Bio') }}
                                </h3>
                                <div class="text-gray-600 leading-relaxed prose prose-sm max-w-none prose-headings:text-[#003B73] prose-a:text-blue-600">
                                    {!! $doctor->bio !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- NEW: Video Biography Section -->
                @if($videoId)
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6">
                    <h3 class="text-lg font-black text-[#003B73] mb-4 flex items-center gap-2">
                        <x-heroicon-o-play-circle class="w-6 h-6 text-red-500" />
                        {{ __('Meet') }} {{ $doctor->name }}
                    </h3>
                    <div class="relative w-full rounded-2xl overflow-hidden aspect-video shadow-inner bg-gray-900">
                        <iframe 
                            class="absolute top-0 left-0 w-full h-full"
                            src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @endif

            </div>

            <!-- Right Column: Interactive Schedule Calendar (Unchanged from previous step) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 sm:p-10 h-full flex flex-col">
                    <div class="mb-8">
                        <h2 class="text-2xl font-black text-[#003B73] flex items-center gap-3">
                            <x-heroicon-o-calendar class="w-8 h-8 text-sky-500" />
                            {{ __("Doctor's Availability") }}
                        </h2>
                        <p class="text-gray-500 mt-2 font-medium">{{ __('Real-time schedule. Highlighted days indicate when the doctor is accepting consultations.') }}</p>
                    </div>

                    <!-- Alpine.js Dynamic Calendar -->
                    <div x-data="doctorCalendar()" x-init="initCalendar()" class="flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <button @click="prevMonth" class="p-2 hover:bg-white rounded-lg transition-colors text-gray-500 hover:text-[#0062B8] shadow-sm">
                                <x-heroicon-o-chevron-left class="w-6 h-6" />
                            </button>
                            <h3 class="text-xl font-bold text-gray-900" x-text="monthNames[month] + ' ' + year"></h3>
                            <button @click="nextMonth" class="p-2 hover:bg-white rounded-lg transition-colors text-gray-500 hover:text-[#0062B8] shadow-sm">
                                <x-heroicon-o-chevron-right class="w-6 h-6" />
                            </button>
                        </div>

                        <div class="grid grid-cols-7 gap-2 mb-4">
                            <template x-for="day in [__('Sun'), __('Mon'), __('Tue'), __('Wed'), __('Thu'), __('Fri'), __('Sat')]">
                                <div class="text-center text-xs font-black text-gray-400 uppercase tracking-wider" x-text="day"></div>
                            </template>
                        </div>

                        <div class="grid grid-cols-7 gap-2 flex-1">
                            <template x-for="(day, index) in days" :key="index">
                                <div 
                                    class="relative flex items-center justify-center rounded-xl p-2 sm:p-4 text-sm sm:text-base font-semibold transition-all duration-300"
                                    :class="{
                                        'bg-transparent': day.empty,
                                        'bg-gray-50 text-gray-300': !day.empty && (day.isPast || !day.isWorking),
                                        'bg-emerald-50 border-2 border-emerald-200 text-emerald-700 shadow-sm cursor-pointer hover:bg-emerald-500 hover:text-white hover:shadow-emerald-500/40 hover:-translate-y-1': !day.empty && !day.isPast && day.isWorking
                                    }"
                                >
                                    <span x-show="!day.empty" x-text="day.date"></span>
                                    <template x-if="!day.empty && !day.isPast && day.isWorking">
                                        <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                        </span>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function doctorCalendar() {
        return {
            month: new Date().getMonth(),
            year: new Date().getFullYear(),
            workingDays: {!! $workingDaysJson !!},
            days: [],
            monthNames: [__('January'), __('February'), __('March'), __('April'), __('May'), __('June'), __('July'), __('August'), __('September'), __('October'), __('November'), __('December')],
            
            initCalendar() {
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let startDay = new Date(this.year, this.month, 1).getDay(); 
                let today = new Date();
                today.setHours(0, 0, 0, 0);

                this.days = [];
                for (let i = 0; i < startDay; i++) { this.days.push({ empty: true }); }
                for (let i = 1; i <= daysInMonth; i++) {
                    let currentDate = new Date(this.year, this.month, i);
                    let dayName = currentDate.toLocaleDateString('en-US', { weekday: 'long' });
                    this.days.push({
                        empty: false, date: i, fullDate: currentDate,
                        isWorking: this.workingDays.includes(dayName),
                        isPast: currentDate < today
                    });
                }
            },
            nextMonth() {
                if (this.month === 11) { this.month = 0; this.year++; } else { this.month++; }
                this.initCalendar();
            },
            prevMonth() {
                if (this.month === 0) { this.month = 11; this.year--; } else { this.month--; }
                this.initCalendar();
            }
        }
    }
</script>
@endsection
