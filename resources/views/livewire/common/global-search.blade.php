<div x-data="{ open: @js($open) }"
     x-show="open"
     x-on:open-command-palette.window="open = true"
     x-on:keydown.escape.window="open = false"
     x-cloak
     class="fixed inset-0 z-[60] flex items-start justify-center pt-24 px-4">
    <div class="absolute inset-0 bg-black/75 backdrop-blur-md" @click="open = false"></div>
    <div x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="relative w-full max-w-xl bg-[#0F0F12] border border-[#27272A] rounded-xl shadow-2xl overflow-hidden">
        <div class="flex items-center gap-3 px-4 py-3.5 border-b border-[#1F1F23]">
            <i data-lucide="search" class="w-4 h-4 text-[#71717A]"></i>
            <input type="search"
                   wire:model.live.debounce.200ms="query"
                   @focus="$el.select()"
                   placeholder="Buscar imóveis, inquilinos, contratos..."
                   class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-white placeholder-[#52525B] text-sm">
            <kbd class="text-[10px] text-[#71717A] font-medium px-2 py-0.5 bg-[#1A1A1F] border border-[#27272A] rounded">ESC</kbd>
        </div>
        <div class="max-h-96 overflow-y-auto p-2">
            @if(strlen($query) >= 2 && $results->count())
                @foreach($results as $r)
                    <button wire:click="go('{{ $r['url'] }}')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-[#1A1A1F] text-left transition-colors group">
                        <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] flex-shrink-0">
                            <i data-lucide="{{ $r['icon'] }}" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm text-white truncate">{{ $r['title'] }}</div>
                            <div class="text-xs text-[#71717A] truncate mt-0.5">{{ $r['subtitle'] }} · {{ $r['type'] }}</div>
                        </div>
                        <i data-lucide="arrow-right" class="w-4 h-4 text-[#71717A] group-hover:text-white transition-colors"></i>
                    </button>
                @endforeach
            @elseif(strlen($query) >= 2)
                <div class="px-4 py-12 text-center">
                    <div class="icon-box icon-box-lg bg-[#1A1A1F] border border-[#27272A] text-[#52525B] mx-auto mb-3">
                        <i data-lucide="search-x" class="w-5 h-5"></i>
                    </div>
                    <p class="text-sm text-[#71717A]">Nenhum resultado encontrado</p>
                </div>
            @else
                <div class="px-4 py-12 text-center">
                    <div class="icon-box icon-box-lg bg-[#1A1A1F] border border-[#27272A] text-[#52525B] mx-auto mb-3">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </div>
                    <p class="text-sm text-[#71717A]">Digite ao menos 2 caracteres para buscar</p>
                    <p class="text-xs text-[#52525B] mt-1">⌘K para abrir este painel</p>
                </div>
            @endif
        </div>
    </div>
</div>
