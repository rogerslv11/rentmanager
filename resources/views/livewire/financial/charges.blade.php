<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(245,158,11,0.05)] via-transparent to-[rgba(34,197,94,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#F59E0B] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="receipt" class="w-3 h-3"></i>
                        Financeiro
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Cobranças</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Acompanhe todos os recebimentos e inadimplência</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-secondary">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar
                    </button>
                    <button class="btn btn-secondary">
                        <i data-lucide="send" class="w-4 h-4"></i> Disparar boletos
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total emitido</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="receipt" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['paid'] + $this->stats['pending'] + $this->stats['overdue'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['total'] }} cobranças</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.05)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Recebido</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format($this->stats['paid'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->collectionRate }}% de adimplência</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#FBBF24] uppercase tracking-wider font-semibold">A receber</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-[#FBBF24] tracking-tight">R$ {{ number_format($this->stats['pending'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['count_pending'] }} pendentes</div>
                </div>

                <div class="p-4 rounded-xl {{ $this->stats['count_overdue'] > 0 ? 'bg-gradient-to-br from-[rgba(244,63,94,0.06)] to-[rgba(244,63,94,0.01)] border border-[rgba(244,63,94,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $this->stats['count_overdue'] > 0 ? 'text-[#FB7185]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Em atraso</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F43F5E] to-[#BE123C] flex items-center justify-center shadow-lg shadow-[#F43F5E]/20">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold {{ $this->stats['count_overdue'] > 0 ? 'text-[#FB7185]' : 'text-white' }} tracking-tight">R$ {{ number_format($this->stats['overdue'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['count_overdue'] }} {{ $this->stats['count_overdue'] == 1 ? 'cobrança' : 'cobranças' }}</div>
                </div>
            </div>

            {{-- Status quick filter pills --}}
            <div class="flex items-center gap-2 flex-wrap mt-5">
                <button wire:click="$set('statusFilter', '')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                    {{ $statusFilter === '' ? 'bg-white text-[#09090B] border-white' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                    <i data-lucide="list" class="w-3 h-3"></i>
                    <span>Todas</span>
                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === '' ? 'bg-[#09090B]/10' : 'bg-[#1F1F23]' }}">{{ $this->stats['total'] }}</span>
                </button>
                @foreach($this->statusBreakdown as $s)
                    @php
                        $activeColor = match($s['color']) {
                            'green' => 'bg-[#22C55E] text-[#052E16] border-[#22C55E]',
                            'yellow' => 'bg-[#F59E0B] text-[#451A03] border-[#F59E0B]',
                            'red' => 'bg-[#F43F5E] text-white border-[#F43F5E]',
                            default => 'bg-[#52525B] text-white border-[#52525B]',
                        };
                        $inactiveColor = match($s['color']) {
                            'green' => 'bg-[rgba(34,197,94,0.08)] text-[#4ADE80] border-[rgba(34,197,94,0.18)] hover:bg-[rgba(34,197,94,0.15)]',
                            'yellow' => 'bg-[rgba(245,158,11,0.08)] text-[#FBBF24] border-[rgba(245,158,11,0.18)] hover:bg-[rgba(245,158,11,0.15)]',
                            'red' => 'bg-[rgba(244,63,94,0.08)] text-[#FB7185] border-[rgba(244,63,94,0.18)] hover:bg-[rgba(244,63,94,0.15)]',
                            default => 'bg-[#1F1F23] text-[#A1A1AA] border-[#27272A] hover:bg-[#27272A]',
                        };
                    @endphp
                    <button wire:click="$set('statusFilter', '{{ $s['status'] }}')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                        {{ $statusFilter === $s['status'] ? $activeColor : $inactiveColor }}">
                        <i data-lucide="{{ $s['icon'] }}" class="w-3 h-3"></i>
                        <span>{{ $s['label'] }}</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === $s['status'] ? 'bg-black/15' : 'bg-black/20' }}">{{ $s['value'] }}</span>
                    </button>
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
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por referência, inquilino ou imóvel..." class="pl-10">
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

    @if($this->charges->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Referência</th>
                        <th>Inquilino</th>
                        <th>Imóvel</th>
                        <th>Vencimento</th>
                        <th class="text-right">Valor</th>
                        <th class="text-right">Pago</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->charges as $c)
                        <tr>
                            <td>
                                <span class="font-mono text-xs text-white">{{ $c->reference }}</span>
                            </td>
                            <td>
                                <a href="{{ route('tenants.show', $c->tenant) }}" class="text-white hover:text-[#4ADE80] font-medium transition-colors">{{ $c->tenant->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('properties.show', $c->property) }}" class="text-[#A1A1AA] hover:text-white transition-colors inline-flex items-center gap-1.5">
                                    <i data-lucide="building-2" class="w-3 h-3 text-[#71717A]"></i>
                                    {{ $c->property->name }}
                                </a>
                            </td>
                            <td class="text-xs">
                                <div class="text-white">{{ $c->due_date->format('d/m/Y') }}</div>
                                @if($c->daysOverdue() > 0)
                                    <div class="text-[#FB7185] font-semibold mt-0.5">+{{ $c->daysOverdue() }} dias</div>
                                @endif
                            </td>
                            <td class="text-right">
                                <span class="font-semibold text-white">R$ {{ number_format((float) $c->total_amount, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-right">
                                <span class="text-[#4ADE80] font-medium">R$ {{ number_format((float) $c->paid_amount, 2, ',', '.') }}</span>
                            </td>
                            <td><x-ui.badge :variant="$c->status->color()">{{ $c->status->label() }}</x-ui.badge></td>
                            <td class="text-right">
                                @if($c->status !== \App\Enums\ChargeStatus::Paid->value)
                                    <button wire:click="markPaid({{ $c->id }})" wire:confirm="Marcar como paga?" class="inline-flex items-center gap-1 text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium transition-colors">
                                        <i data-lucide="check" class="w-3 h-3"></i> Marcar paga
                                    </button>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-[#52525B]">
                                        <i data-lucide="check-check" class="w-3 h-3"></i> Liquidada
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->charges->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="receipt" title="Nenhuma cobrança" :description="$search || $statusFilter ? 'Ajuste os filtros para ver mais resultados.' : 'As cobranças aparecerão aqui quando forem geradas.'" />
        </div>
    @endif
</div>
