<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.05)] via-transparent to-[rgba(245,158,11,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="file-text" class="w-3 h-3"></i>
                        Carteira
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Contratos</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Gerencie todos os contratos de locação</p>
                </div>
                <a href="{{ route('contracts.create') }}" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                    <i data-lucide="file-plus" class="w-4 h-4"></i> Novo contrato
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/20">
                            <i data-lucide="file-text" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">contratos</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.05)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Ativos</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['active'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">em vigor</div>
                </div>
                <div class="p-4 rounded-xl {{ $this->stats['expiring'] > 0 ? 'bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $this->stats['expiring'] > 0 ? 'text-[#FBBF24]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Vencendo (60d)</span>
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5 {{ $this->stats['expiring'] > 0 ? 'text-[#FBBF24]' : 'text-[#52525B]' }}"></i>
                    </div>
                    <div class="text-2xl font-bold {{ $this->stats['expiring'] > 0 ? 'text-[#FBBF24]' : 'text-white' }} tracking-tight">{{ $this->stats['expiring'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">renovar em breve</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Receita ativa</span>
                        <i data-lucide="banknote" class="w-3.5 h-3.5 text-[#52525B]"></i>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['totalRent'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">mensal total</div>
                </div>
            </div>

            {{-- Status quick filter pills --}}
            <div class="flex items-center gap-2 flex-wrap mt-5">
                <button wire:click="$set('statusFilter', '')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                    {{ $statusFilter === '' ? 'bg-white text-[#09090B] border-white' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                    <span>Todos</span>
                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === '' ? 'bg-[#09090B]/10' : 'bg-[#1F1F23]' }}">{{ $this->stats['total'] }}</span>
                </button>
                @foreach($this->statusBreakdown as $s)
                    @if($s['value'] > 0)
                        @php
                            $activeColor = match($s['color']) {
                                'green' => 'bg-[#22C55E] text-[#052E16] border-[#22C55E]',
                                'yellow' => 'bg-[#F59E0B] text-[#451A03] border-[#F59E0B]',
                                'red' => 'bg-[#F43F5E] text-white border-[#F43F5E]',
                                'gray' => 'bg-[#52525B] text-white border-[#52525B]',
                                default => 'bg-[#3B82F6] text-white border-[#3B82F6]',
                            };
                            $inactiveColor = match($s['color']) {
                                'green' => 'bg-[rgba(34,197,94,0.08)] text-[#4ADE80] border-[rgba(34,197,94,0.18)] hover:bg-[rgba(34,197,94,0.15)]',
                                'yellow' => 'bg-[rgba(245,158,11,0.08)] text-[#FBBF24] border-[rgba(245,158,11,0.18)] hover:bg-[rgba(245,158,11,0.15)]',
                                'red' => 'bg-[rgba(244,63,94,0.08)] text-[#FB7185] border-[rgba(244,63,94,0.18)] hover:bg-[rgba(244,63,94,0.15)]',
                                'gray' => 'bg-[#1F1F23] text-[#A1A1AA] border-[#27272A] hover:bg-[#27272A]',
                                default => 'bg-[rgba(59,130,246,0.08)] text-[#60A5FA] border-[rgba(59,130,246,0.18)] hover:bg-[rgba(59,130,246,0.15)]',
                            };
                        @endphp
                        <button wire:click="$set('statusFilter', '{{ $s['status'] }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                            {{ $statusFilter === $s['status'] ? $activeColor : $inactiveColor }}">
                            <span>{{ $s['label'] }}</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === $s['status'] ? 'bg-black/15' : 'bg-black/20' }}">{{ $s['value'] }}</span>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-9">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por número, imóvel ou inquilino..." class="pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                @if($search || $statusFilter)
                    <button wire:click="$set('search', ''); $set('statusFilter', '')" class="btn btn-secondary w-full">
                        <i data-lucide="x" class="w-4 h-4"></i> Limpar filtros
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($this->contracts->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Imóvel / Inquilino</th>
                        <th>Período</th>
                        <th class="text-right">Aluguel</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->contracts as $c)
                        <tr>
                            <td>
                                <a href="{{ route('contracts.show', $c) }}" class="font-mono text-sm font-medium text-white hover:text-[#4ADE80] transition-colors">{{ $c->number }}</a>
                            </td>
                            <td>
                                <div class="font-medium text-white">{{ $c->property->name }}</div>
                                <div class="text-xs text-[#71717A] mt-0.5">{{ $c->tenant->name }}</div>
                            </td>
                            <td class="text-xs">
                                <div class="text-white">{{ $c->start_date->format('d/m/Y') }} → {{ $c->end_date->format('d/m/Y') }}</div>
                                <div class="text-[#71717A] mt-0.5">{{ $c->durationInMonths() }} meses</div>
                            </td>
                            <td class="text-right">
                                <div class="text-[#4ADE80] font-semibold">R$ {{ number_format((float) $c->rent_amount, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-[#71717A] mt-0.5">mensal</div>
                            </td>
                            <td><x-ui.badge :variant="$c->status->color()">{{ $c->status->label() }}</x-ui.badge></td>
                            <td class="text-right">
                                <a href="{{ route('contracts.show', $c) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#4ADE80] hover:text-[#22C55E] transition-colors">
                                    Ver contrato
                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->contracts->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="file-text" title="Nenhum contrato" :description="$search || $statusFilter ? 'Ajuste os filtros para ver mais resultados.' : 'Crie o primeiro contrato de locação.'">
                <x-slot:action>
                    @if($search || $statusFilter)
                        <button wire:click="$set('search', ''); $set('statusFilter', '')" class="btn btn-secondary">
                            <i data-lucide="x" class="w-4 h-4"></i> Limpar filtros
                        </button>
                    @else
                        <a href="{{ route('contracts.create') }}" class="btn btn-primary">
                            <i data-lucide="plus" class="w-4 h-4"></i> Criar contrato
                        </a>
                    @endif
                </x-slot:action>
            </x-ui.empty-state>
        </div>
    @endif
</div>
