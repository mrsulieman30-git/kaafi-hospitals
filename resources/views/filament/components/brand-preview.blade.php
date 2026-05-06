@php
    // Safe URL extractor for Filament FileUpload states
    $getPreviewUrl = function ($file) {
        if (!$file) return null;
        
        // Filament often stores files in an array during the temporary upload state
        if (is_array($file)) {
            $file = array_values($file)[0] ?? null;
        }
        
        if (is_string($file)) {
            return asset('storage/' . $file);
        }
        
        if (is_object($file) && method_exists($file, 'temporaryUrl')) {
            return $file->temporaryUrl();
        }
        
        return null;
    };

    $logoSrc = $getPreviewUrl($logo_path);
    $heroBgSrc = $getPreviewUrl($hero_bg_path);
    $chatbotAvatarSrc = $getPreviewUrl($chatbot_avatar_path);
@endphp

<div class="w-full rounded-xl border-4 border-gray-800 overflow-hidden shadow-2xl relative bg-white transition-all">
    <!-- Mock Top Bar -->
    <div class="bg-[#003B73] h-2 w-full"></div>
    
    <!-- Mock Navbar -->
    <div class="bg-white border-b border-gray-100 p-4 flex items-center transition-all duration-300
        {{ $logo_position === 'center' ? 'justify-center' : ($logo_position === 'right' ? 'justify-end' : 'justify-start') }}">
        
        @if($logoSrc)
            <img src="{{ $logoSrc }}" alt="Logo" class="transition-all duration-300" style="height: {{ $logo_height ?? 40 }}px; object-fit: contain;">
        @else
            <div class="text-2xl font-black text-[#003B73] tracking-tighter">KAAFI<span class="text-[#DC3545]">.</span></div>
        @endif
    </div>

    <!-- Mock Hero Section -->
    <div class="relative h-64 bg-[#0062B8] flex flex-col items-center justify-center text-center px-4 overflow-hidden">
        @if($heroBgSrc)
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-300 mix-blend-overlay" 
                 style="background-image: url('{{ $heroBgSrc }}'); opacity: {{ ($hero_bg_opacity ?? 10) / 100 }};">
            </div>
        @endif
        
        <div class="relative z-10 space-y-2">
            <h1 class="text-3xl font-black text-white drop-shadow-md">Excellence in Healthcare</h1>
            <p class="text-blue-100 text-sm">Your trusted partner in wellness.</p>
            <div class="mt-4 inline-block px-6 py-2 bg-[#DC3545] text-white text-sm font-bold rounded-full shadow-lg">Book Appointment</div>
        </div>
    </div>

    <!-- Mock Chatbot Bubble -->
    <div class="absolute bottom-4 right-4 w-12 h-12 bg-[#003B73] rounded-full shadow-[0_4px_15px_rgba(0,59,115,0.4)] flex items-center justify-center overflow-hidden border-2 border-white/20 transition-all">
        @if($chatbotAvatarSrc)
            <img src="{{ $chatbotAvatarSrc }}" class="w-full h-full object-cover">
        @else
            <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6 text-white" />
        @endif
    </div>
</div>
