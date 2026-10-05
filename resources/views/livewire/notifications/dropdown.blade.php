<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative w-9 h-9 flex items-center justify-center rounded-lg hover:bg-[#1A1A1F] text-[#A1A1AA] hover:text-white transition-colors">
        <i data-lucide="bell" class="w-4 h-4"></i>
        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 w-2 h-2 bg-[#22C55E] rounded-full pulse-green ring-2 ring-[#08080A]"></span>
        @endif
    </button>
    <div x-show="open" x-transition x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-96 bg-[#0F0F12] border border-[#27272A] rounded-xl shadow-2xl overflow-hidden z-50">
        <div class="flex items-center justify-between px-4 py-3 border-b border-[#1F1F23] bg-gradient-to-br from-[#16161A] to-[#0F0F12]">
            <div class="flex items-center gap-2">
                <i data-lucide="bell" class="w-4 h-4 text-[#71717A]"></i>
                <h3 class="text-sm font-semibold text-white">Notificações</h3>
                @if($unreadCount > 0)
                    <span class="badge badge-success text-[10px]">{{ $unreadCount }} novas</span>
                @endif
            </div>
            @if($unreadCount > 0)
                <button wire:click="markAllRead" class="text-xs text-[#4ADE80] hover:text-[#22C55E] transition-colors">Marcar todas lidas</button>
            @endif
        </div>
        <div class="max-h-96 overflow-y-auto divide-y divide-[#1F1F23]">
            @forelse($notifications as $n)
                <div wire:click="markRead('{{ $n->id }}')" class="px-4 py-3 hover:bg-[#0A0A0C] cursor-pointer {{ $n->read_at ? 'opacity-60' : '' }}">
                    <div class="flex items-start gap-3">
                        @if(!$n->read_at)
                            <span class="w-2 h-2 rounded-full bg-[#22C55E] mt-1.5 flex-shrink-0"></span>
                        @else
                            <span class="w-2 h-2 mt-1.5 flex-shrink-0"></span>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-white">{{ $n->data['title'] ?? 'Notificação' }}</div>
                            <div class="text-xs text-[#A1A1AA] mt-0.5 line-clamp-2">{{ $n->data['message'] ?? '' }}</div>
                            <div class="text-xs text-[#71717A] mt-1.5">{{ $n->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center">
                    <div class="icon-box icon-box-lg bg-[#1A1A1F] border border-[#27272A] text-[#52525B] mx-auto mb-3">
                        <i data-lucide="bell-off" class="w-5 h-5"></i>
                    </div>
                    <p class="text-sm text-[#71717A]">Sem notificações</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
