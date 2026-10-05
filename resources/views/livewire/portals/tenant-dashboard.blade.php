<div>
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Olá, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-[#71717A] mt-1">Acompanhe seu contrato, cobranças e manutenções.</p>
    </div>

    @if($tenant && $tenant->activeContract)
        @php $contract = $tenant->activeContract; @endphp
        <div class="card overflow-hidden">
            <div class="relative p-6 bg-gradient-to-br from-[rgba(34,197,94,0.08)] via-transparent to-transparent border-b border-[#1F1F23]">
                <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-50"></div>
                <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Seu contrato atual</p>
                        <h3 class="text-lg font-semibold text-white mt-1">{{ $contract->property->name }}</h3>
                        <p class="text-xs text-[#71717A] mt-1 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3 h-3"></i>
                            {{ $contract->property->fullAddress() }}
                        </p>
                    </div>
                    <x-ui.badge variant="success">{{ $contract->status->label() }}</x-ui.badge>
                </div>
                <div class="grid grid-cols-3 gap-3 pt-4 border-t border-[#1F1F23]">
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Aluguel</p>
                        <p class="text-lg font-bold text-white mt-1">R$ {{ number_format((float) $contract->rent_amount, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Vencimento</p>
                        <p class="text-lg font-bold text-white mt-1">Dia {{ $contract->due_day }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Dias restantes</p>
                        <p class="text-lg font-bold text-white mt-1">{{ $contract->daysUntilExpiration() }} dias</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
            <x-ui.stat-card label="A pagar" :value="'R$ ' . number_format($stats['pending'], 2, ',', '.')" icon="clock" :color="$stats['pending'] > 0 ? 'yellow' : 'green'" />
            <x-ui.stat-card label="Em atraso" :value="'R$ ' . number_format($stats['overdue'], 2, ',', '.')" icon="alert-circle" :color="$stats['overdue'] > 0 ? 'red' : 'green'" />
            <x-ui.stat-card label="Manutenções" :value="$stats['maintenance']" icon="wrench" color="yellow" />
        </div>

        <div class="card overflow-hidden mt-6">
            <div class="px-5 py-3 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="receipt" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Suas cobranças</h3>
            </div>
            <div class="divide-y divide-[#1F1F23]">
                @forelse($tenant->charges()->latest('due_date')->limit(10)->get() as $c)
                    <div class="flex items-center justify-between p-4 list-item-hover transition-colors">
                        <div>
                            <div class="text-sm font-medium text-white">{{ $c->reference }}</div>
                            <div class="text-xs text-[#71717A] mt-0.5">Vencimento: {{ $c->due_date->format('d/m/Y') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-base font-bold text-white">R$ {{ number_format((float) $c->total_amount, 2, ',', '.') }}</div>
                            <div class="mt-1"><x-ui.badge :variant="$c->status->color()">{{ $c->status->label() }}</x-ui.badge></div>
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state icon="receipt" title="Sem cobranças" />
                @endforelse
            </div>
        </div>
    @else
        <x-ui.empty-state icon="file" title="Sem contrato ativo" description="Entre em contato com a imobiliária." />
    @endif
</div>
