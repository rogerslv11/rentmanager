<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.06)] via-transparent to-[rgba(168,85,247,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <a href="{{ route('contracts.index') }}" class="inline-flex items-center gap-1.5 text-xs text-[#A1A1AA] hover:text-white mb-6 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar para contratos
            </a>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Contrato</span>
                        <x-ui.badge :variant="$contract->status->color()">{{ $contract->status->label() }}</x-ui.badge>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight font-mono">{{ $contract->number }}</h1>
                    <div class="flex items-center gap-3 mt-2 flex-wrap">
                        <a href="{{ route('properties.show', $contract->property) }}" class="text-sm text-[#A1A1AA] hover:text-white transition-colors inline-flex items-center gap-1.5">
                            <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                            {{ $contract->property->name }}
                        </a>
                        <span class="text-[#52525B]">·</span>
                        <a href="{{ route('tenants.show', $contract->tenant) }}" class="text-sm text-[#A1A1AA] hover:text-white transition-colors inline-flex items-center gap-1.5">
                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                            {{ $contract->tenant->name }}
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="terminate" wire:confirm="Deseja realmente encerrar este contrato?" class="btn btn-secondary">
                        <i data-lucide="x-circle" class="w-4 h-4"></i> Encerrar
                    </button>
                    <a href="{{ route('contracts.renew', $contract) }}" class="btn btn-primary shadow-lg shadow-[#22C55E]/10">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i> Renovar
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Aluguel</span>
                        <i data-lucide="banknote" class="w-3.5 h-3.5 text-[#4ADE80]"></i>
                    </div>
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format((float) $contract->rent_amount, 2, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">mensal</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Taxa administrativa</span>
                        <i data-lucide="percent" class="w-3.5 h-3.5 text-[#52525B]"></i>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">{{ $contract->admin_fee_percent }}%</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">sobre o aluguel</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Repasse líquido</span>
                        <i data-lucide="trending-up" class="w-3.5 h-3.5 text-[#4ADE80]"></i>
                    </div>
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format($contract->netOwnerAmount(), 2, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">ao proprietário</div>
                </div>
                <div class="p-4 rounded-xl {{ $contract->isExpiring(30) ? 'bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $contract->isExpiring(30) ? 'text-[#FBBF24]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Dias restantes</span>
                        <i data-lucide="calendar-clock" class="w-3.5 h-3.5 {{ $contract->isExpiring(30) ? 'text-[#FBBF24]' : 'text-[#52525B]' }}"></i>
                    </div>
                    <div class="text-xl font-bold {{ $contract->isExpiring(30) ? 'text-[#FBBF24]' : 'text-white' }} tracking-tight">{{ $contract->daysUntilExpiration() }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">até {{ $contract->end_date->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ tab: 'info' }" class="card overflow-hidden">
        <div class="border-b border-[#1F1F23] bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
            <nav class="tabs-nav">
                @foreach(['info' => ['Informações', 'info'], 'charges' => ['Cobranças', 'receipt', $contract->charges->count()], 'timeline' => ['Histórico', 'history', $contract->histories->count()]] as $key => $info)
                    <button type="button" @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ? 'active' : ''"
                            class="tab-btn inline-flex items-center gap-2">
                        <i data-lucide="{{ $info[1] }}" class="w-3.5 h-3.5"></i>
                        {{ $info[0] }}
                        @if(isset($info[2]))
                            <span class="px-1.5 py-0.5 rounded text-[10px] bg-[#1F1F23] text-[#71717A]">{{ $info[2] }}</span>
                        @endif
                    </button>
                @endforeach
            </nav>
        </div>

        <div x-show="tab === 'info'" class="p-6 lg:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="card overflow-hidden card-hover">
                    <div class="px-4 py-2.5 border-b border-[#1F1F23] flex items-center gap-2">
                        <div class="icon-box icon-box-sm bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                            <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-[11px] font-semibold text-[#A1A1AA] uppercase tracking-wider">Imóvel</span>
                    </div>
                    <a href="{{ route('properties.show', $contract->property) }}" class="block p-4 list-item-hover transition-colors">
                        <div class="font-medium text-white">{{ $contract->property->name }}</div>
                        <div class="text-xs text-[#71717A] mt-1">{{ $contract->property->fullAddress() }}</div>
                    </a>
                </div>
                <div class="card overflow-hidden card-hover">
                    <div class="px-4 py-2.5 border-b border-[#1F1F23] flex items-center gap-2">
                        <div class="icon-box icon-box-sm bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white">
                            <i data-lucide="user-round" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-[11px] font-semibold text-[#A1A1AA] uppercase tracking-wider">Inquilino</span>
                    </div>
                    <a href="{{ route('tenants.show', $contract->tenant) }}" class="block p-4 list-item-hover transition-colors">
                        <div class="font-medium text-white">{{ $contract->tenant->name }}</div>
                        <div class="text-xs text-[#71717A] mt-1">{{ $contract->tenant->email }}</div>
                    </a>
                </div>
                <div class="card overflow-hidden card-hover">
                    <div class="px-4 py-2.5 border-b border-[#1F1F23] flex items-center gap-2">
                        <div class="icon-box icon-box-sm bg-gradient-to-br from-[#A855F7] to-[#7E22CE] text-white">
                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="text-[11px] font-semibold text-[#A1A1AA] uppercase tracking-wider">Proprietário</span>
                    </div>
                    <a href="{{ route('owners.show', $contract->owner) }}" class="block p-4 list-item-hover transition-colors">
                        <div class="font-medium text-white">{{ $contract->owner?->name ?? '—' }}</div>
                        <div class="text-xs text-[#71717A] mt-1">{{ $contract->owner?->email ?? '—' }}</div>
                    </a>
                </div>
            </div>

            <div class="divider-dotted"></div>

            <div>
                <h3 class="text-xs font-bold text-[#71717A] uppercase tracking-wider mb-4">Termos do contrato</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Início</p>
                        <p class="text-sm font-semibold text-white">{{ $contract->start_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Vencimento</p>
                        <p class="text-sm font-semibold text-white">{{ $contract->end_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Assinado em</p>
                        <p class="text-sm font-semibold text-white">{{ $contract->signed_at?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Duração</p>
                        <p class="text-sm font-semibold text-white">{{ $contract->durationInMonths() }} meses</p>
                    </div>
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Vencimento dia</p>
                        <p class="text-sm font-semibold text-white">{{ $contract->due_day }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Reajuste</p>
                        <p class="text-sm font-semibold text-white">{{ $contract->adjustment_index }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Periodicidade</p>
                        <p class="text-sm font-semibold text-white">{{ $contract->adjustment_periodicity }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Auto-renova</p>
                        <p class="text-sm font-semibold text-white inline-flex items-center gap-1.5">
                            @if($contract->auto_renew)
                                <i data-lucide="check" class="w-3.5 h-3.5 text-[#22C55E]"></i> Sim
                            @else
                                <i data-lucide="x" class="w-3.5 h-3.5 text-[#F43F5E]"></i> Não
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'charges'" class="p-6 lg:p-8" x-cloak>
            @if($contract->charges->count())
                <div class="table-wrapper">
                    <table class="table">
                        <thead><tr><th>Referência</th><th>Vencimento</th><th>Valor</th><th>Pago</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($contract->charges->take(24) as $c)
                                <tr>
                                    <td class="font-mono text-xs">{{ $c->reference }}</td>
                                    <td>{{ $c->due_date->format('d/m/Y') }}</td>
                                    <td>R$ {{ number_format((float) $c->total_amount, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format((float) $c->paid_amount, 2, ',', '.') }}</td>
                                    <td><x-ui.badge :variant="$c->status->color()">{{ $c->status->label() }}</x-ui.badge></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-ui.empty-state icon="receipt" title="Sem cobranças" />
            @endif
        </div>

        <div x-show="tab === 'timeline'" class="p-6 lg:p-8" x-cloak>
            @if($contract->histories->count())
                <div class="relative pl-6">
                    <div class="absolute top-0 bottom-0 left-2 w-px bg-gradient-to-b from-[#22C55E] via-[#1F1F23] to-transparent"></div>
                    @foreach($contract->histories as $h)
                        <div class="relative pb-5 last:pb-0">
                            <div class="absolute -left-[18px] top-1 w-3 h-3 rounded-full bg-gradient-to-br from-[#22C55E] to-[#15803D] ring-4 ring-[#0F0F12]"></div>
                            <div class="text-sm text-white font-medium">{{ $h->action }}</div>
                            <div class="text-xs text-[#71717A] mt-1 flex items-center gap-1.5">
                                <i data-lucide="user" class="w-3 h-3"></i>
                                {{ $h->user?->name ?? 'Sistema' }}
                                <span class="text-[#3F3F46]">·</span>
                                {{ $h->created_at->diffForHumans() }}
                            </div>
                            @if($h->notes)
                                <div class="text-sm text-[#A1A1AA] mt-2 p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23]">{{ $h->notes }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state icon="clock" title="Sem histórico" />
            @endif
        </div>
    </div>
</div>
