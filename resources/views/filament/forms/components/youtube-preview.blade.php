@php
    $url = $getState() ?? $getRecord()?->youtube_video_url ?? '';
    // Safely extract the YouTube Video ID from standard or shortened URLs
    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $match);
    $videoId = $match[1] ?? null;
@endphp

@if($videoId)
    <div class="mt-4 rounded-2xl overflow-hidden shadow-lg border border-gray-200/50 bg-gray-50 relative aspect-video">
        <iframe 
            class="absolute top-0 left-0 w-full h-full"
            src="https://www.youtube.com/embed/{{ $videoId }}?rel=0" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    </div>
@else
    @if(filled($url))
        <div class="mt-2 text-sm text-red-500 flex items-center gap-2">
            <x-heroicon-m-exclamation-circle class="w-5 h-5"/>
            Invalid YouTube URL. Please check the link.
        </div>
    @endif
@endif
