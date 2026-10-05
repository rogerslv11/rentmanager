<div>
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Olá, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-[#71717A] mt-1">Acompanhe seus imóveis, contratos e repasses.</p>
    </div>

    @if($owner)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-ui.stat-card label="Imóveis" :value="$stats['properties']" icon="building-2" color="blue" />
            <x-ui.stat-card label="Receita mensal" :value="'R$ ' . number_format($stats['monthly_revenue'], 0, ',', '.')" icon="trending-up" color="green" />
            <x-ui.stat-card label="A receber" :value="'R$ ' . number_format($stats['pending_payouts'], 0, ',', '.')" icon="clock" color="yellow" />
            <x-ui.stat-card label="Recebido" :value="'R$ ' . number_format($stats['total_received'], 0, ',', '.')" icon="check-circle-2" color="green" />
        </div>

        <div class="card overflow-hidden mt-6">
            <div class="px-5 py-3 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Seus imóveis</h3>
            </div>
            <div class="divide-y divide-[#1F1F23]">
                @forelse($owner->properties as $p)
                    <div class="flex items-center justify-between p-4 list-item-hover transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                                <i data-lucide="{{ $p->type->icon() }}" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-white">{{ $p->name }}</div>
                                <div class="text-xs text-[#71717A] mt-0.5 flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    {{ $p->city }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-base font-bold text-[#4ADE80]">R$ {{ number_format((float) $p->rent_amount, 0, ',', '.') }}</div>
                            <div class="mt-1"><x-ui.badge :variant="$p->status->color()">{{ $p->status->label() }}</x-ui.badge></div>
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state icon="building-2" title="Sem imóveis" />
                @endforelse
            </div>
        </div>
    @else
        <x-ui.empty-state icon="user" title="Perfil não vinculado" description="Entre em contato com a imobiliária." />
    @endif
</div>
