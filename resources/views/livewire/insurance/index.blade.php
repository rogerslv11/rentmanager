<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(59,130,246,0.06)] via-transparent to-[rgba(34,197,94,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#3B82F6] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="shield" class="w-3 h-3"></i>
                        Operações
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Seguros</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Apólices e coberturas dos imóveis</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-secondary">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar
                    </button>
                    <button wire:click="$set('showForm', true)" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                        <i data-lucide="plus" class="w-4 h-4"></i> Nova apólice
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total de apólices</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="shield" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">cadastradas</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Ativas</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['active'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">em vigor</div>
                </div>

                <div class="p-4 rounded-xl {{ $this->stats['expiring_30'] > 0 ? 'bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $this->stats['expiring_30'] > 0 ? 'text-[#FBBF24]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Vencendo (30d)</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold {{ $this->stats['expiring_30'] > 0 ? 'text-[#FBBF24]' : 'text-white' }} tracking-tight">{{ $this->stats['expiring_30'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">renovar em breve</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Cobertura total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['total_coverage'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">prêmio R$ {{ number_format($this->stats['total_premium'], 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($this->policies->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->policies as $p)
                @php
                    $now = now();
                    $isActive = $p->start_date <= $now && $p->end_date >= $now;
                    $isExpiring = $p->isExpiring(30);
                    $isExpired = $p->end_date < $now;
                @endphp
                <div class="card overflow-hidden card-hover relative">
                    @if($isExpiring)
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-[#F59E0B] to-transparent"></div>
                    @elseif($isActive)
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-[#22C55E] to-transparent"></div>
                    @endif

                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="icon-box icon-box-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white shadow-lg shadow-[#3B82F6]/20">
                                <i data-lucide="shield" class="w-5 h-5"></i>
                            </div>
                            <x-ui.badge variant="info">{{ $p->type?->label() }}</x-ui.badge>
                        </div>

                        <h3 class="text-base font-semibold text-white">{{ $p->provider }}</h3>
                        <p class="text-xs text-[#71717A] font-mono mt-0.5">{{ $p->policy_number }}</p>

                        <div class="mt-4 pt-4 border-t border-[#1F1F23] space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-[#71717A] flex items-center gap-1.5">
                                    <i data-lucide="shield" class="w-3 h-3"></i> Cobertura
                                </span>
                                <span class="text-white font-semibold">R$ {{ number_format((float) $p->coverage_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-[#71717A] flex items-center gap-1.5">
                                    <i data-lucide="banknote" class="w-3 h-3"></i> Prêmio
                                </span>
                                <span class="text-white font-medium">R$ {{ number_format((float) $p->premium_amount, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-[#71717A] flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3 h-3"></i> Vigência
                                </span>
                                <span class="text-white font-medium">{{ $p->start_date->format('d/m/Y') }} → {{ $p->end_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-[#71717A] flex items-center gap-1.5">
                                    <i data-lucide="building-2" class="w-3 h-3"></i> Imóvel
                                </span>
                                <a href="{{ route('properties.show', $p->property) }}" class="text-[#A1A1AA] hover:text-white truncate ml-2 transition-colors max-w-[140px]">{{ $p->property->name }}</a>
                            </div>
                        </div>

                        @if($isExpiring)
                            <div class="mt-4 px-3 py-2 bg-[rgba(245,158,11,0.08)] border border-[rgba(245,158,11,0.18)] rounded-lg text-xs text-[#FBBF24] inline-flex items-center gap-2 w-full">
                                <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                                <span class="font-medium">Vence em {{ $p->daysUntilExpiration() }} dias</span>
                            </div>
                        @elseif($isExpired)
                            <div class="mt-4 px-3 py-2 bg-[rgba(244,63,94,0.08)] border border-[rgba(244,63,94,0.18)] rounded-lg text-xs text-[#FB7185] inline-flex items-center gap-2 w-full">
                                <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                                <span class="font-medium">Vencida há {{ abs($p->daysUntilExpiration()) }} dias</span>
                            </div>
                        @elseif($isActive)
                            <div class="mt-4 px-3 py-2 bg-[rgba(34,197,94,0.06)] border border-[rgba(34,197,94,0.18)] rounded-lg text-xs text-[#4ADE80] inline-flex items-center gap-2 w-full">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                                <span class="font-medium">Ativa por mais {{ $p->daysUntilExpiration() }} dias</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="shield" title="Nenhuma apólice" description="Cadastre a primeira apólice de seguro.">
                <x-slot:action>
                    <button wire:click="$set('showForm', true)" class="btn btn-primary">
                        <i data-lucide="plus" class="w-4 h-4"></i> Nova apólice
                    </button>
                </x-slot:action>
            </x-ui.empty-state>
        </div>
    @endif

    @if($showForm)
        <x-ui.modal title="Nova apólice" :show="true">
            <form wire:submit="save" class="space-y-4">
                <x-ui.field label="Imóvel" required>
                    <select wire:model="property_id">
                        <option value="">Selecione...</option>
                        @foreach($properties as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                    </select>
                </x-ui.field>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="Tipo" required>
                        <select wire:model="type">
                            @foreach(\App\Enums\InsuranceType::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Seguradora" required>
                        <input type="text" wire:model="provider">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="Nº da apólice" required>
                        <input type="text" wire:model="policy_number">
                    </x-ui.field>
                    <x-ui.field label="Cobertura">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="coverage_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <x-ui.field label="Prêmio">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="premium_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Início" required>
                        <input type="date" wire:model="start_date">
                    </x-ui.field>
                    <x-ui.field label="Fim" required>
                        <input type="date" wire:model="end_date">
                    </x-ui.field>
                </div>
            </form>
            <x-slot:footer>
                <button type="button" wire:click="$set('showForm', false)" class="btn btn-secondary">Cancelar</button>
                <button type="button" wire:click="save" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i> Salvar
                </button>
            </x-slot:footer>
        </x-ui.modal>
    @endif
</div>
