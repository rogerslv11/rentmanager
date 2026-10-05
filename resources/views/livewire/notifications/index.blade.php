<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.06)] via-transparent to-[rgba(59,130,246,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="bell" class="w-3 h-3"></i>
                        Conta
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Notificações</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Central de notificações e atualizações</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($stats['unread'] > 0)
                        <button wire:click="markAllRead" class="btn btn-secondary">
                            <i data-lucide="check-check" class="w-4 h-4"></i> Marcar todas lidas
                        </button>
                    @endif
                    <button wire:click="clearAll" wire:confirm="Limpar TODAS as notificações?" class="btn btn-secondary">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Limpar tudo
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="bell" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">notificações</div>
                </div>
                <div class="p-4 rounded-xl {{ $stats['unread'] > 0 ? 'bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $stats['unread'] > 0 ? 'text-[#4ADE80]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Não lidas</span>
                        <div class="w-7 h-7 rounded-lg {{ $stats['unread'] > 0 ? 'bg-gradient-to-br from-[#22C55E] to-[#15803D]' : 'bg-[#1F1F23]' }} flex items-center justify-center shadow-lg {{ $stats['unread'] > 0 ? 'shadow-[#22C55E]/30' : '' }}">
                            <i data-lucide="mail" class="w-3.5 h-3.5 {{ $stats['unread'] > 0 ? 'text-[#052E16]' : 'text-[#71717A]' }}"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold {{ $stats['unread'] > 0 ? 'text-[#4ADE80]' : 'text-white' }} tracking-tight">{{ $stats['unread'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">aguardando leitura</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Hoje</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="calendar-clock" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $stats['today'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">nas últimas 24h</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Esta semana</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $stats['week'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">últimos 7 dias</div>
                </div>
            </div>
        </div>
    </div>

    @if($allNotifications->count())
        <div class="card overflow-hidden">
            <div class="px-5 py-3 border-b border-[#1F1F23] flex items-center justify-between bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
                <div class="flex items-center gap-2 text-xs text-[#71717A]">
                    <i data-lucide="inbox" class="w-3.5 h-3.5"></i>
                    <span>{{ $allNotifications->count() }} {{ $allNotifications->count() == 1 ? 'notificação' : 'notificações' }} no total</span>
                </div>
                <div class="text-xs text-[#71717A]">
                    Mostrando {{ $allNotifications->firstItem() }}–{{ $allNotifications->lastItem() }}
                </div>
            </div>
            <div class="divide-y divide-[#1F1F23]">
                @foreach($allNotifications as $n)
                    <div class="px-5 py-4 hover:bg-[#0F0F12] transition-colors {{ $n->read_at ? 'opacity-60' : 'bg-[rgba(34,197,94,0.02)]' }} group" wire:key="notif-{{ $n->id }}">
                        <div class="flex items-start gap-4">
                            <div class="relative flex-shrink-0">
                                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] shadow-lg shadow-[#22C55E]/10">
                                    <i data-lucide="{{ $n->data['icon'] ?? 'bell' }}" class="w-4 h-4"></i>
                                </div>
                                @if(!$n->read_at)
                                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-[#22C55E] ring-2 ring-[#0F0F12] pulse-green"></span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-sm font-semibold text-white">{{ $n->data['title'] ?? 'Notificação' }}</h3>
                                    @if(!$n->read_at)
                                        <span class="badge badge-success text-[10px] py-0 px-1.5">Nova</span>
                                    @endif
                                </div>
                                @if(!empty($n->data['message']))
                                    <p class="text-sm text-[#A1A1AA] mt-1">{{ $n->data['message'] }}</p>
                                @endif
                                <div class="flex items-center gap-3 mt-2 text-xs">
                                    <div class="flex items-center gap-1 text-[#71717A]">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        {{ $n->created_at->diffForHumans() }}
                                    </div>
                                    <span class="text-[#3F3F46]">·</span>
                                    <div class="flex items-center gap-1 text-[#71717A]">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                        {{ $n->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if(!$n->read_at)
                                    <button wire:click="markRead('{{ $n->id }}')" class="btn btn-secondary btn-icon tooltip" data-tooltip="Marcar como lida">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                @endif
                                <button wire:click="delete('{{ $n->id }}')" wire:confirm="Remover esta notificação?" class="btn btn-secondary btn-icon tooltip" data-tooltip="Remover">
                                    <i data-lucide="trash-2" class="w-4 h-4 text-[#FB7185]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="px-5 py-4 border-t border-[#1F1F23]">
                {{ $allNotifications->links() }}
            </div>
        </div>
    @else
        <div class="card p-12">
            <x-ui.empty-state
                icon="bell-off"
                title="Sem notificações"
                description="Quando houver novas atualizações ou eventos, você verá aqui." />
        </div>
    @endif
</div>
