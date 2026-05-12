<div class="mt-12">
    {{-- Engagement Bar --}}
    <div class="flex items-center justify-between border-y border-gray-200 py-4 mb-10">
        <div class="flex items-center space-x-6">
            {{-- Like Button --}}
            <button wire:click="toggleLike" class="flex items-center space-x-2 group transition">
                <span class="w-10 h-10 rounded-full flex items-center justify-center transition {{ $hasLiked ? 'bg-red-50 text-[#DC3545]' : 'bg-gray-100 text-gray-500 group-hover:bg-red-50 group-hover:text-[#DC3545]' }}">
                    <svg class="w-5 h-5" fill="{{ $hasLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </span>
                <span class="font-semibold text-sm {{ $hasLiked ? 'text-[#DC3545]' : 'text-gray-600' }}">{{ $post->likes_count }} {{ $post->likes_count === 1 ? __('Like') : __('Likes') }}</span>
            </button>

            {{-- Comment Toggle --}}
            <button wire:click="toggleCommentForm" class="flex items-center space-x-2 group transition">
                <span class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-blue-50 group-hover:text-[#0062B8] text-gray-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </span>
                <span class="font-semibold text-sm text-gray-600">{{ $comments->count() }} {{ $comments->count() === 1 ? __('Comment') : __('Comments') }}</span>
            </button>
        </div>

        {{-- Share Buttons --}}
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-500 mr-2 hidden sm:inline">{{ __('Share:') }}</span>
            {{-- Facebook --}}
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-[#1877F2] flex items-center justify-center text-white hover:opacity-80 transition" title="Share on Facebook">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            {{-- Twitter/X --}}
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-black flex items-center justify-center text-white hover:opacity-80 transition" title="Share on X">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            {{-- WhatsApp --}}
            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-[#25D366] flex items-center justify-center text-white hover:opacity-80 transition" title="Share on WhatsApp">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
            {{-- Copy Link --}}
            <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { this.innerText='✓'; setTimeout(() => this.innerHTML='<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3\'></path></svg>', 1500) })" class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-300 transition" title="Copy Link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
            </button>
        </div>
    </div>

    {{-- Comment Submitted Notification --}}
    @if($commentSubmitted)
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-8 flex items-center">
        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-green-800 text-sm font-medium">{{ __('Thank you! Your comment has been submitted and is awaiting moderation.') }}</p>
    </div>
    @endif

    {{-- Comment Form --}}
    @if($showCommentForm)
    <div class="bg-gray-50 rounded-2xl p-6 mb-10 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Leave a Comment') }}</h3>
        <form wire:submit="submitComment">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Your Name') }}</label>
                    <input wire:model="commentName" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] outline-none transition" placeholder="{{ __('Your Name') }}" required>
                    @error('commentName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                    <input wire:model="commentEmail" type="email" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] outline-none transition" placeholder="{{ __('Email Address') }}" required>
                    @error('commentEmail') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Your Comment') }}</label>
                <textarea wire:model="commentContent" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0062B8] focus:border-[#0062B8] outline-none transition resize-none" placeholder="{{ __('Write your thoughts...') }}" required></textarea>
                @error('commentContent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-[#003B73] hover:bg-[#0062B8] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm">
                {{ __('Submit Comment') }}
            </button>
        </form>
    </div>
    @endif

    {{-- Approved Comments --}}
    @if($comments->count() > 0)
    <div class="mb-10">
        <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('Comments') }} ({{ $comments->count() }})</h3>
        <div class="space-y-6">
            @foreach($comments as $comment)
            <div class="flex space-x-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-[#003B73] to-[#0062B8] flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                </div>
                <div class="flex-1 bg-gray-50 rounded-2xl rounded-tl-none p-4 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $comment->name }}</h4>
                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->content }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
