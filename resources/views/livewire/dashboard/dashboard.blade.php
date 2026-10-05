<div>
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                <i data-lucide="calendar" class="w-3 h-3"></i>
                {{ now()->translatedFormat('l, d \\d\\e F \\d\\e Y') }}
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Dashboard</h1>
            <p class="text-sm text-[#71717A] mt-1">Visão geral da operação em tempo real</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn btn-secondary">
                <i data-lucide="download" class="w-4 h-4"></i> Exportar
            </button>
            <button class="btn btn-secondary">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Atualizar
            </button>
        </div>
    </div>

    {{-- Financial KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-ui.stat-card
            label="Receita do mês"
            :value="'R$ ' . number_format($stats['revenue_this_month'], 2, ',', '.')"
            icon="trending-up"
            color="green"
            :trend="$stats['revenue_last_month'] > 0 ? round((($stats['revenue_this_month'] - $stats['revenue_last_month']) / $stats['revenue_last_month']) * 100, 1) . '%' : null"
            :trendDirection="$stats['revenue_this_month'] >= $stats['revenue_last_month'] ? 'up' : 'down'" />

        <x-ui.stat-card
            label="A receber"
            :value="'R$ ' . number_format($stats['pending_amount'], 2, ',', '.')"
            icon="clock"
            color="yellow"
            :trend="number_format($stats['pending_amount'], 0, ',', '.')"
            trendDirection="neutral" />

        <x-ui.stat-card
            label="Em atraso"
            :value="'R$ ' . number_format($stats['overdue_amount'], 2, ',', '.')"
            icon="alert-circle"
            color="red"
            :trend="number_format($stats['overdue_amount'], 0, ',', '.')"
            trendDirection="neutral" />

        <x-ui.stat-card
            label="Taxa de ocupação"
            :value="$stats['occupancy_rate'] . '%'"
            icon="pie-chart"
            color="blue"
            :trend="$stats['rented_properties'] . '/' . $stats['total_properties'] . ' imóveis'"
            trendDirection="neutral" />
    </div>

    {{-- Property KPIs --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('properties.index') }}" class="card card-hover p-5 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Imóveis</p>
                    <p class="text-2xl font-bold text-white mt-1.5 tracking-tight">{{ $stats['total_properties'] }}</p>
                </div>
                <div class="icon-box icon-box-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white shadow-lg shadow-[#3B82F6]/20">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] text-[#52525B] group-hover:text-[#71717A] transition-colors">
                Ver todos <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </div>
        </a>

        <a href="{{ route('properties.index') }}?status=available" class="card card-hover p-5 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Disponíveis</p>
                    <p class="text-2xl font-bold text-[#4ADE80] mt-1.5 tracking-tight">{{ $stats['available_properties'] }}</p>
                </div>
                <div class="icon-box icon-box-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] shadow-lg shadow-[#22C55E]/20">
                    <i data-lucide="home" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] text-[#52525B] group-hover:text-[#71717A] transition-colors">
                Ver disponíveis <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </div>
        </a>

        <a href="{{ route('properties.index') }}?status=rented" class="card card-hover p-5 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Alugados</p>
                    <p class="text-2xl font-bold text-white mt-1.5 tracking-tight">{{ $stats['rented_properties'] }}</p>
                </div>
                <div class="icon-box icon-box-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] text-white shadow-lg shadow-[#A855F7]/20">
                    <i data-lucide="key" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] text-[#52525B] group-hover:text-[#71717A] transition-colors">
                Ver alugados <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </div>
        </a>

        <a href="{{ route('maintenance.index') }}" class="card card-hover p-5 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Manutenções</p>
                    <p class="text-2xl font-bold text-[#F59E0B] mt-1.5 tracking-tight">{{ $stats['open_maintenance'] }}</p>
                </div>
                <div class="icon-box icon-box-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03] shadow-lg shadow-[#F59E0B]/20">
                    <i data-lucide="wrench" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-[11px] text-[#52525B] group-hover:text-[#71717A] transition-colors">
                Ver solicitações <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </div>
        </a>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        <div class="card lg:col-span-2">
            <div class="flex items-center justify-between p-5 border-b border-[#1F1F23]">
                <div>
                    <h3 class="text-sm font-semibold text-white">Receita vs Inadimplência</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">Últimos 12 meses</p>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#22C55E]"></span>
                        <span class="text-[#A1A1AA]">Recebido</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#F43F5E]"></span>
                        <span class="text-[#A1A1AA]">Em atraso</span>
                    </div>
                </div>
            </div>
            <div class="p-5" wire:ignore>
                <canvas id="revenueChart" class="max-h-72" x-init="
                    new Chart($el, {
                        type: 'line',
                        data: {
                            labels: {{ json_encode($revenueChart['labels']) }},
                            datasets: [
                                {
                                    label: 'Recebido',
                                    data: {{ json_encode($revenueChart['paid']) }},
                                    borderColor: '#22C55E',
                                    backgroundColor: (ctx) => {
                                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 250);
                                        gradient.addColorStop(0, 'rgba(34, 197, 94, 0.20)');
                                        gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');
                                        return gradient;
                                    },
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 0,
                                    pointHoverRadius: 5,
                                    pointBackgroundColor: '#22C55E',
                                    pointBorderColor: '#08080A',
                                    pointBorderWidth: 2,
                                },
                                {
                                    label: 'Em atraso',
                                    data: {{ json_encode($revenueChart['overdue']) }},
                                    borderColor: '#F43F5E',
                                    backgroundColor: (ctx) => {
                                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 250);
                                        gradient.addColorStop(0, 'rgba(244, 63, 94, 0.10)');
                                        gradient.addColorStop(1, 'rgba(244, 63, 94, 0)');
                                        return gradient;
                                    },
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 0,
                                    pointHoverRadius: 5,
                                    pointBackgroundColor: '#F43F5E',
                                    pointBorderColor: '#08080A',
                                    pointBorderWidth: 2,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#0F0F12', borderColor: '#27272A', borderWidth: 1, padding: 12, cornerRadius: 8, titleColor: '#FFFFFF', bodyColor: '#A1A1AA' } },
                            scales: {
                                x: { grid: { display: false }, ticks: { color: '#71717A', font: { size: 11 } }, border: { display: false } },
                                y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#71717A', font: { size: 11 }, callback: (v) => 'R$ ' + (v/1000).toFixed(0) + 'k' }, border: { display: false } }
                            }
                        }
                    })
                "></canvas>
            </div>
        </div>

        <div class="card">
            <div class="p-5 border-b border-[#1F1F23]">
                <h3 class="text-sm font-semibold text-white">Imóveis por status</h3>
                <p class="text-xs text-[#71717A] mt-0.5">Distribuição atual</p>
            </div>
            <div class="p-5" wire:ignore>
                <canvas id="propertyStatusChart" class="max-h-72" x-init="
                    new Chart($el, {
                        type: 'doughnut',
                        data: {
                            labels: ['Disponível', 'Alugado', 'Manutenção', 'Reservado', 'Inativo'],
                            datasets: [{
                                data: {{ json_encode(array_values($propertyStatusChart)) }},
                                backgroundColor: ['#22C55E', '#3B82F6', '#F59E0B', '#A855F7', '#52525B'],
                                borderWidth: 3,
                                borderColor: '#0F0F12',
                                hoverOffset: 8,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '72%',
                            plugins: {
                                legend: { position: 'bottom', labels: { color: '#A1A1AA', font: { size: 11 }, boxWidth: 8, padding: 12, usePointStyle: true } },
                            }
                        }
                    })
                "></canvas>
            </div>
        </div>
    </div>

    {{-- Lists --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="card overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-[#1F1F23]">
                <div class="flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03]">
                        <i data-lucide="file-warning" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white">Contratos vencendo</h3>
                        <p class="text-xs text-[#71717A] mt-0.5">Próximos 90 dias</p>
                    </div>
                </div>
                <a href="{{ route('contracts.index') }}" class="text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium inline-flex items-center gap-1 transition-colors">
                    Ver todos <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="divide-y divide-[#1F1F23]">
                @forelse($upcomingContracts as $contract)
                    <a href="{{ route('contracts.show', $contract) }}" class="flex items-center gap-3 p-4 list-item-hover transition-colors">
                        <div class="avatar avatar-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03] text-xs flex-shrink-0">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-white truncate">{{ $contract->property->name }}</div>
                            <div class="text-xs text-[#71717A] truncate mt-0.5">{{ $contract->tenant->name }} · {{ $contract->number }}</div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-sm font-medium text-white">{{ $contract->end_date->format('d/m/Y') }}</div>
                            <div class="text-xs text-[#F59E0B] mt-0.5">{{ $contract->daysUntilExpiration() }} dias</div>
                        </div>
                    </a>
                @empty
                    <x-ui.empty-state icon="file-check" title="Nenhum contrato vencendo" description="Tudo em dia por aqui." />
                @endforelse
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-[#1F1F23]">
                <div class="flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white">Pagamentos recentes</h3>
                        <p class="text-xs text-[#71717A] mt-0.5">Últimas movimentações</p>
                    </div>
                </div>
                <a href="{{ route('payments.index') }}" class="text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium inline-flex items-center gap-1 transition-colors">
                    Ver todos <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="divide-y divide-[#1F1F23]">
                @forelse($recentPayments as $charge)
                    @php $payment = $charge->payments->first(); @endphp
                    <div class="flex items-center gap-3 p-4 list-item-hover transition-colors">
                        <div class="avatar avatar-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-white truncate">{{ $charge->tenant->name }}</div>
                            <div class="text-xs text-[#71717A] truncate mt-0.5">{{ $charge->property->name }} · {{ $payment?->method?->label() ?? '—' }}</div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-sm font-bold text-[#4ADE80]">R$ {{ number_format((float) $charge->total_amount, 2, ',', '.') }}</div>
                            <div class="text-xs text-[#71717A] mt-0.5">{{ $charge->paid_at?->format('d/m/Y') }}</div>
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state icon="credit-card" title="Nenhum pagamento recente" description="Os pagamentos aparecerão aqui." />
                @endforelse
            </div>
        </div>
    </div>

    {{-- Activity --}}
    <div class="card overflow-hidden mt-6">
        <div class="flex items-center justify-between p-5 border-b border-[#1F1F23]">
            <div class="flex items-center gap-3">
                <div class="icon-box icon-box-md bg-[#1F1F23] text-[#A1A1AA]">
                    <i data-lucide="activity" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">Atividade recente</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">Histórico de ações do sistema</p>
                </div>
            </div>
        </div>
        <div class="divide-y divide-[#1F1F23]">
            @forelse($activities as $activity)
                <div class="flex items-start gap-3 p-4 list-item-hover transition-colors">
                    <div class="icon-box icon-box-md bg-[#1A1A1F] border border-[#27272A] text-[#A1A1AA] flex-shrink-0">
                        <i data-lucide="{{ $activity->icon() }}" class="w-4 h-4"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm text-white">{{ $activity->description ?? $activity->action }}</div>
                        <div class="text-xs text-[#71717A] mt-0.5 flex items-center gap-1.5">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            {{ $activity->user?->name ?? 'Sistema' }}
                            <span class="text-[#3F3F46]">·</span>
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <x-ui.empty-state icon="activity" title="Nenhuma atividade" description="O histórico aparecerá aqui." />
            @endforelse
        </div>
    </div>
</div>
