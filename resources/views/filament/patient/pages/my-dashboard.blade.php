<x-filament-panels::page>
    <div class="max-w-5xl mx-auto space-y-8">
        
        <!-- Welcome Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight italic">Kaafi Health Portal</h1>
                <p class="text-gray-500 mt-1 font-medium italic underline">Your upcoming consultations and medical history.</p>
            </div>
            <div class="hidden sm:block text-right">
                <p class="text-sm font-bold text-[#003B73]">{{ now()->format('l, d M Y') }}</p>
                <p class="text-xs text-gray-400">Mogadishu, Somalia</p>
            </div>
        </div>

        <!-- Next Appointment with Countdown -->
        @if($upcoming)
            <div 
                x-data="{
                    expiry: new Date('{{ $upcoming->appointment_date }} {{ $upcoming->appointment_time }}').getTime(),
                    now: new Date().getTime(),
                    days: 0, hours: 0, minutes: 0, seconds: 0,
                    init() {
                        setInterval(() => {
                            this.now = new Date().getTime();
                            let diff = this.expiry - this.now;
                            if (diff > 0) {
                                this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                            }
                        }, 1000);
                    }
                }"
                class="relative overflow-hidden bg-white rounded-[2rem] shadow-2xl border border-gray-100 transition-all group"
            >
                <div class="absolute top-0 left-0 w-full h-2 {{ $upcoming->status === 'approved' ? 'bg-emerald-500' : 'bg-amber-500' }}"></div>
                
                <div class="p-10">
                    <div class="flex flex-col lg:flex-row justify-between gap-12">
                        <!-- Left: Info -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <span class="px-4 py-1 rounded-full text-xs font-black uppercase tracking-[0.2em] {{ $upcoming->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $upcoming->status === 'approved' ? 'Confirmed Appointment' : 'Awaiting Confirmation' }}
                                </span>
                            </div>

                            <div class="space-y-1">
                                <p class="text-gray-400 text-sm font-bold uppercase tracking-widest italic underline">Specialist</p>
                                <h2 class="text-4xl font-black text-[#003B73]">{{ $upcoming->doctor->name ?? 'Medical Specialist' }}</h2>
                                <p class="text-xl text-sky-600 font-bold">{{ $upcoming->department->name ?? 'General Medicine' }}</p>
                            </div>

                            <div class="flex items-center gap-6 pt-4">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-400 font-bold uppercase italic underline">Date</span>
                                    <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($upcoming->appointment_date)->format('l, F j, Y') }}</span>
                                </div>
                                <div class="w-px h-10 bg-gray-200"></div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-400 font-bold uppercase italic underline">Time</span>
                                    <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($upcoming->appointment_time)->format('h:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Countdown -->
                        <div class="bg-gray-50 rounded-[1.5rem] p-8 flex flex-col items-center justify-center min-w-[280px] border border-gray-100 shadow-inner">
                            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 italic underline">Starts In</p>
                            <div class="flex gap-4">
                                <div class="text-center">
                                    <span class="text-3xl font-black text-[#003B73]" x-text="days">0</span>
                                    <p class="text-[0.5rem] font-bold text-gray-400 uppercase italic underline">Days</p>
                                </div>
                                <div class="text-2xl font-black text-gray-200 mt-1">:</div>
                                <div class="text-center">
                                    <span class="text-3xl font-black text-[#003B73]" x-text="hours">0</span>
                                    <p class="text-[0.5rem] font-bold text-gray-400 uppercase italic underline">Hrs</p>
                                </div>
                                <div class="text-2xl font-black text-gray-200 mt-1">:</div>
                                <div class="text-center">
                                    <span class="text-3xl font-black text-[#003B73]" x-text="minutes">0</span>
                                    <p class="text-[0.5rem] font-bold text-gray-400 uppercase italic underline">Min</p>
                                </div>
                            </div>
                            
                            <!-- Simple Reminder Note -->
                            <div class="mt-6 flex items-start gap-2 bg-sky-50 p-3 rounded-lg border border-sky-100">
                                <x-heroicon-o-information-circle class="w-4 h-4 text-sky-500 mt-0.5" />
                                <p class="text-[0.65rem] text-sky-700 leading-tight">Please arrive 15 minutes early at Wadajir District facility for check-in.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Appointments State -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-16 text-center italic underline">
                <div class="w-20 h-20 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <x-heroicon-o-calendar class="w-10 h-10 text-sky-300" />
                </div>
                <h3 class="text-2xl font-black text-[#003B73]">No Appointments Scheduled</h3>
                <p class="text-gray-500 mt-2 max-w-md mx-auto italic underline">Schedule your next visit with our medical specialists in just a few clicks.</p>
                <a href="/appointment" target="_blank" class="mt-8 inline-flex items-center justify-center px-10 py-4 border border-transparent text-sm font-black rounded-2xl shadow-xl text-white bg-[#0062B8] hover:bg-[#003B73] transition-all hover:scale-105 active:scale-95">
                    Book Appointment Now
                </a>
            </div>
        @endif

        <!-- Recent History Section -->
        @if($history->count() > 0)
            <div class="pt-4">
                <div class="flex items-center gap-2 mb-6">
                    <div class="h-1 w-8 bg-sky-500 rounded-full italic underline"></div>
                    <h3 class="text-xl font-black text-[#003B73] italic underline uppercase tracking-tight">Visit History</h3>
                </div>
                <div class="grid gap-4">
                    @foreach($history as $record)
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:bg-gray-50 transition-colors italic underline">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 shadow-sm italic underline">
                                    <x-heroicon-o-document-check class="w-6 h-6 text-gray-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-900 italic underline">{{ \Carbon\Carbon::parse($record->appointment_date)->format('M d, Y') }}</p>
                                    <p class="text-[0.7rem] text-gray-500 font-bold uppercase tracking-wider italic underline">{{ $record->doctor->name ?? 'General Consultation' }}</p>
                                </div>
                            </div>
                            <span class="px-4 py-1 rounded-lg text-[0.65rem] font-black uppercase tracking-widest italic underline {{ $record->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ $record->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
