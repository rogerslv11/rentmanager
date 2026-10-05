<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.05)] via-transparent to-[rgba(59,130,246,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="calendar" class="w-3 h-3"></i>
                        Análise
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight capitalize">{{ $monthLabel }}</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Visão consolidada de eventos e prazos</p>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="goToToday" class="btn btn-secondary">
                        <i data-lucide="calendar-clock" class="w-4 h-4"></i> Hoje
                    </button>
                    <div class="bg-[#0F0F12] border border-[#1F1F23] rounded-lg p-1 flex">
                        <button wire:click="$set('view', 'month')" class="px-3 py-1.5 rounded text-xs font-medium transition-colors {{ $view === 'month' ? 'bg-[#22C55E] text-[#052E16]' : 'text-[#A1A1AA] hover:text-white' }}">Mês</button>
                        <button wire:click="$set('view', 'list')" class="px-3 py-1.5 rounded text-xs font-medium transition-colors {{ $view === 'list' ? 'bg-[#22C55E] text-[#052E16]' : 'text-[#A1A1AA] hover:text-white' }}">Lista</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total eventos</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/20">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">próximos 120 dias</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#FBBF24] uppercase tracking-wider font-semibold">Cobranças</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="receipt" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#FBBF24] tracking-tight">{{ $stats['charges'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">vencimentos</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Contratos</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="file-text" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $stats['contracts'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">renovações</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(59,130,246,0.06)] to-[rgba(59,130,246,0.01)] border border-[rgba(59,130,246,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#60A5FA] uppercase tracking-wider font-semibold">Seguros</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="shield" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#60A5FA] tracking-tight">{{ $stats['insurance'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">apólices</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(168,85,247,0.06)] to-[rgba(168,85,247,0.01)] border border-[rgba(168,85,247,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#C084FC] uppercase tracking-wider font-semibold">Manutenções</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="wrench" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#C084FC] tracking-tight">{{ $stats['maintenance'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">agendadas</div>
                </div>
            </div>

            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-2">
                    <button wire:click="previousMonth" class="btn btn-secondary btn-icon">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <div class="text-sm font-semibold text-white capitalize min-w-[160px] text-center">{{ $monthLabel }}</div>
                    <button wire:click="nextMonth" class="btn btn-secondary btn-icon">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></span>
                        <span class="text-[#A1A1AA]">Cobranças</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#22C55E]"></span>
                        <span class="text-[#A1A1AA]">Contratos</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#3B82F6]"></span>
                        <span class="text-[#A1A1AA]">Seguros</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#A855F7]"></span>
                        <span class="text-[#A1A1AA]">Manutenções</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
        {{-- Calendar grid --}}
        <div class="xl:col-span-2">
            @if($view === 'month')
                <div class="card overflow-hidden">
                    <div class="grid grid-cols-7 border-b border-[#1F1F23] bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
                        @foreach(['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'] as $d)
                            <div class="px-3 py-2.5 text-[10px] font-bold text-[#71717A] uppercase tracking-wider text-center">{{ $d }}</div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-7">
                        @for($i = 0; $i < $startDay; $i++)
                            <div class="min-h-[110px] border-r border-b border-[#1F1F23] bg-[#0A0A0C]"></div>
                        @endfor
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date = $refDate->copy()->day($day)->format('Y-m-d');
                                $dayEvents = $eventsByDate[$date] ?? collect();
                                $isToday = $date === $today;
                            @endphp
                            <div class="min-h-[110px] border-r border-b border-[#1F1F23] p-2 hover:bg-[#0F0F12] transition-colors relative {{ $isToday ? 'bg-[rgba(34,197,94,0.04)]' : '' }} group">
                                @if($isToday)
                                    <div class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r from-transparent via-[#22C55E] to-transparent"></div>
                                @endif
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold {{ $isToday ? 'text-[#4ADE80]' : 'text-white' }}">{{ $day }}</span>
                                    @if($dayEvents->count() > 0)
                                        <span class="text-[10px] font-medium text-[#71717A] bg-[#1A1A1F] border border-[#27272A] rounded-full px-1.5 py-0.5">{{ $dayEvents->count() }}</span>
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    @foreach($dayEvents->take(3) as $ev)
                                        <a href="{{ $ev['url'] }}" class="block text-[10px] px-1.5 py-1 rounded transition-all hover:scale-[1.02]" style="background: {{ $ev['color'] }}20; color: {{ $ev['color'] }}; border: 1px solid {{ $ev['color'] }}40;">
                                            <div class="font-medium truncate">{{ $ev['title'] }}</div>
                                        </a>
                                    @endforeach
                                    @if($dayEvents->count() > 3)
                                        <div class="text-[10px] text-[#71717A] font-medium">+{{ $dayEvents->count() - 3 }} mais</div>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @else
                {{-- List view --}}
                <div class="card overflow-hidden">
                    <div class="divide-y divide-[#1F1F23]">
                        @forelse($upcoming as $ev)
                            <a href="{{ $ev['url'] }}" class="block p-5 list-item-hover transition-colors group">
                                <div class="flex items-start gap-4">
                                    <div class="icon-box icon-box-lg flex-shrink-0" style="background: linear-gradient(135deg, {{ $ev['color'] }}, {{ $ev['color'] }}cc); color: white;">
                                        <i data-lucide="{{ $ev['icon'] }}" class="w-5 h-5"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="text-sm font-semibold text-white group-hover:text-[#4ADE80] transition-colors">{{ $ev['title'] }}</h3>
                                        </div>
                                        <div class="text-xs text-[#71717A] mb-2">{{ $ev['subtitle'] }}</div>
                                        <div class="flex items-center gap-3 text-xs">
                                            <span class="inline-flex items-center gap-1.5 text-white font-medium">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#71717A]"></i>
                                                {{ $ev['datetime']->format('d/m/Y') }}
                                            </span>
                                            <span class="text-[#71717A]">·</span>
                                            <span class="inline-flex items-center gap-1.5" style="color: {{ $ev['color'] }}">
                                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                                {{ $ev['datetime']->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <x-ui.empty-state icon="calendar-x" title="Sem eventos próximos" description="Nenhum vencimento ou agendamento nos próximos meses." />
                        @endforelse
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar: Upcoming events --}}
        <div class="space-y-4">
            <div class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
                    <div class="flex items-center gap-2">
                        <div class="icon-box icon-box-sm bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                            <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-white">Próximos eventos</h3>
                    </div>
                    <p class="text-xs text-[#71717A] mt-1">Vencimentos e agendamentos</p>
                </div>
                <div class="divide-y divide-[#1F1F23] max-h-[600px] overflow-y-auto">
                    @forelse($upcoming->take(10) as $ev)
                        <a href="{{ $ev['url'] }}" class="block p-4 list-item-hover transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-1 self-stretch rounded-full flex-shrink-0" style="background: {{ $ev['color'] }};"></div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-white truncate">{{ $ev['title'] }}</div>
                                    <div class="text-xs text-[#71717A] truncate mt-0.5">{{ $ev['subtitle'] }}</div>
                                    <div class="text-[10px] mt-1 flex items-center gap-1" style="color: {{ $ev['color'] }}">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        {{ $ev['datetime']->format('d/m') }} · {{ $ev['datetime']->diffForHumans(null, true, true) }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-sm text-[#71717A]">Nenhum evento próximo.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
