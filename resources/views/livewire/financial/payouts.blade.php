<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(168,85,247,0.05)] via-transparent to-[rgba(34,197,94,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#A855F7] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="banknote" class="w-3 h-3"></i>
                        Financeiro
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Repasses</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Gerencie os repasses aos proprietários</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-secondary">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar
                    </button>
                    <button class="btn btn-primary shadow-lg shadow-[#22C55E]/10">
                        <i data-lucide="plus" class="w-4 h-4"></i> Gerar repasses
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#FBBF24] uppercase tracking-wider font-semibold">A repassar</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-[#FBBF24] tracking-tight">R$ {{ number_format($this->stats['pending'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['count_pending'] }} {{ $this->stats['count_pending'] == 1 ? 'repasse' : 'repasses' }}</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Pago este mês</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format($this->stats['paid_month'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">em repasses</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total pago</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['paid'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['count_paid'] }} repasses</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Taxas cobradas</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="percent" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['total_fees'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">administrativas</div>
                </div>
            </div>

            @if(count($this->statusBreakdown) > 0)
                <div class="flex items-center gap-2 flex-wrap mt-5">
                    <button wire:click="$set('statusFilter', '')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                        {{ $statusFilter === '' ? 'bg-white text-[#09090B] border-white' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                        <span>Todos</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === '' ? 'bg-[#09090B]/10' : 'bg-[#1F1F23]' }}">{{ $this->stats['count_total'] }}</span>
                    </button>
                    @foreach($this->statusBreakdown as $s)
                        @if($s['value'] > 0)
                            @php
                                $isActive = $statusFilter === $s['status'];
                            @endphp
                            <button wire:click="$set('statusFilter', '{{ $s['status'] }}')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                                {{ $isActive ? 'bg-[#22C55E] text-[#052E16] border-[#22C55E]' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                                <span>{{ $s['label'] }}</span>
                                <span class="px-1.5 py-0.5 rounded text-[10px] {{ $isActive ? 'bg-black/15' : 'bg-black/20' }}">{{ $s['value'] }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-9">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar proprietário..." class="pl-10">
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

    @if($this->payouts->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Proprietário</th>
                        <th>Período</th>
                        <th class="text-right">Bruto</th>
                        <th class="text-right">Taxa</th>
                        <th class="text-right">Líquido</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->payouts as $p)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] text-xs flex-shrink-0">
                                        {{ mb_substr($p->owner->name, 0, 1) }}
                                    </div>
                                    <a href="{{ route('owners.show', $p->owner) }}" class="font-medium text-white hover:text-[#4ADE80] transition-colors">{{ $p->owner->name }}</a>
                                </div>
                            </td>
                            <td class="text-xs">
                                <div class="text-white">{{ $p->period_start?->format('d/m/Y') }} → {{ $p->period_end?->format('d/m/Y') }}</div>
                            </td>
                            <td class="text-right">
                                <span class="text-[#A1A1AA] font-medium">R$ {{ number_format((float) $p->gross_amount, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-right">
                                <span class="text-[#FB7185] font-medium">− R$ {{ number_format((float) $p->admin_fee, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-right">
                                <span class="text-[#4ADE80] font-bold">R$ {{ number_format((float) $p->net_amount, 2, ',', '.') }}</span>
                            </td>
                            <td><x-ui.badge :variant="$p->status->color()">{{ $p->status->label() }}</x-ui.badge></td>
                            <td class="text-right">
                                @if($p->status !== \App\Enums\PayoutStatus::Paid->value)
                                    <button wire:click="markPaid({{ $p->id }})" wire:confirm="Confirmar pagamento?" class="inline-flex items-center gap-1 text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium transition-colors">
                                        <i data-lucide="check" class="w-3 h-3"></i> Marcar pago
                                    </button>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-[#52525B]">
                                        <i data-lucide="check-check" class="w-3 h-3"></i> Liquidado
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->payouts->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="banknote" title="Nenhum repasse" :description="$search || $statusFilter ? 'Ajuste os filtros para ver mais resultados.' : 'Os repasses aparecerão aqui conforme forem gerados.'" />
        </div>
    @endif
</div>
