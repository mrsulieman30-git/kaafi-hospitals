<div class="w-full h-[85vh] rounded-2xl overflow-hidden border border-gray-200 shadow-inner bg-gray-50">
    <div class="bg-gray-100 border-b border-gray-200 px-4 py-2 flex items-center gap-2">
        <div class="w-3 h-3 rounded-full bg-red-400"></div>
        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
        <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
        <span class="ml-2 text-xs text-gray-500 font-medium font-mono truncate">{{ $url }}</span>
    </div>
    <iframe src="{{ $url }}" class="w-full h-full border-none"></iframe>
</div>
