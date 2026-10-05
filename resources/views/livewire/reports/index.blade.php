<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.05)] via-transparent to-[rgba(168,85,247,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="bar-chart-3" class="w-3 h-3"></i>
                        Análise
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Relatórios</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Análise consolidada da operação</p>
                </div>
                <div class="flex items-center gap-2">
                    <select wire:model.live="period" class="max-w-[200px]">
                        <option value="3">Últimos 3 meses</option>
                        <option value="6">Últimos 6 meses</option>
                        <option value="12">Últimos 12 meses</option>
                    </select>
                    <button class="btn btn-secondary">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar PDF
                    </button>
                </div>
            </div>

            {{-- KPI cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Receita total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="trending-up" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format($stats['total_received'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">recebido no período</div>
                </div>

                <div class="p-4 rounded-xl {{ $stats['profit'] >= 0 ? 'bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]' : 'bg-gradient-to-br from-[rgba(244,63,94,0.06)] to-[rgba(244,63,94,0.01)] border border-[rgba(244,63,94,0.18)]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $stats['profit'] >= 0 ? 'text-[#4ADE80]' : 'text-[#FB7185]' }} uppercase tracking-wider font-semibold">Lucro líquido</span>
                        <div class="w-7 h-7 rounded-lg {{ $stats['profit'] >= 0 ? 'bg-gradient-to-br from-[#22C55E] to-[#15803D]' : 'bg-gradient-to-br from-[#F43F5E] to-[#BE123C]' }} flex items-center justify-center shadow-lg {{ $stats['profit'] >= 0 ? 'shadow-[#22C55E]/30' : 'shadow-[#F43F5E]/30' }}">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold {{ $stats['profit'] >= 0 ? 'text-[#4ADE80]' : 'text-[#FB7185]' }} tracking-tight">
                        R$ {{ number_format($stats['profit'], 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">receita − despesas</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Taxa de ocupação</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="pie-chart" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $stats['occupancy_rate'] }}%</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $stats['rented'] }} de {{ $stats['total_properties'] }}</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Adimplência</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="percent" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $stats['collection_rate'] }}%</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">cobranças pagas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="card overflow-hidden mb-6">
        <div class="p-5 border-b border-[#1F1F23] flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">Receita vs Despesas</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">Comparativo mensal do período selecionado</p>
                </div>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#22C55E]"></span>
                    <span class="text-[#A1A1AA]">Receita</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#F43F5E]"></span>
                    <span class="text-[#A1A1AA]">Despesa</span>
                </div>
            </div>
        </div>
        <div class="p-5" wire:ignore>
            <canvas id="reportChart" class="max-h-72" x-init="
                new Chart($el, {
                    type: 'bar',
                    data: {
                        labels: {{ json_encode(array_column($revenueByMonth, 'label')) }},
                        datasets: [
                            { label: 'Receita', data: {{ json_encode(array_column($revenueByMonth, 'received')) }}, backgroundColor: '#22C55E', borderRadius: 6, barPercentage: 0.7 },
                            { label: 'Despesas', data: {{ json_encode(array_column($revenueByMonth, 'expenses')) }}, backgroundColor: '#F43F5E', borderRadius: 6, barPercentage: 0.7 }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: '#0F0F12', borderColor: '#27272A', borderWidth: 1, padding: 12, cornerRadius: 8, titleColor: '#FFFFFF', bodyColor: '#A1A1AA' }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: '#71717A' }, border: { display: false } },
                            y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#71717A', callback: v => 'R$ ' + (v/1000) + 'k' }, border: { display: false } }
                        }
                    }
                })
            "></canvas>
        </div>
    </div>

    {{-- Top properties + summary cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="trophy" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">Top imóveis</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">Por receita gerada</p>
                </div>
            </div>
            <div class="divide-y divide-[#1F1F23]">
                @forelse($topProperties as $i => $p)
                    @php
                        $max = $topProperties->first()?->revenue ?: 1;
                        $percent = ($p->revenue / $max) * 100;
                    @endphp
                    <a href="{{ route('properties.show', $p) }}" class="block p-4 list-item-hover transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] flex items-center justify-center font-bold text-xs flex-shrink-0">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-white truncate">{{ $p->name }}</div>
                                <div class="h-1.5 bg-[#1A1A1F] rounded-full overflow-hidden mt-1.5">
                                    <div class="h-full bg-gradient-to-r from-[#22C55E] to-[#4ADE80] rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div class="text-sm font-semibold text-[#4ADE80]">R$ {{ number_format($p->revenue, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-[#71717A] mt-0.5">{{ $p->paid_count ?? 0 }} cobranças</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-[#71717A]">Sem dados ainda.</div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white">
                        <i data-lucide="building-2" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Imóveis</h3>
                </div>
                <div class="p-5">
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Total de imóveis</dt>
                            <dd class="text-white font-semibold">{{ $stats['total_properties'] }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Alugados</dt>
                            <dd class="text-[#4ADE80] font-semibold">{{ $stats['rented'] }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Disponíveis</dt>
                            <dd class="text-white font-semibold">{{ $stats['available'] }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <dt class="text-[#71717A] text-sm">Aluguel médio</dt>
                            <dd class="text-white font-semibold">R$ {{ number_format($stats['avg_rent'], 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#A855F7] to-[#7E22CE] text-white">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Contratos</h3>
                </div>
                <div class="p-5">
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Ativos</dt>
                            <dd class="text-[#4ADE80] font-semibold">{{ $stats['active_contracts'] }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Vencendo (60d)</dt>
                            <dd class="text-[#FBBF24] font-semibold">{{ $stats['expiring_contracts'] }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Proprietários</dt>
                            <dd class="text-white font-semibold">{{ $stats['total_owners'] }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <dt class="text-[#71717A] text-sm">Inquilinos</dt>
                            <dd class="text-white font-semibold">{{ $stats['total_tenants'] }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03]">
                        <i data-lucide="banknote" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Financeiro</h3>
                </div>
                <div class="p-5">
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Receita total</dt>
                            <dd class="text-[#4ADE80] font-semibold">R$ {{ number_format($stats['total_received'], 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Despesas</dt>
                            <dd class="text-[#FB7185] font-semibold">R$ {{ number_format($stats['total_expenses'], 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Inadimplência</dt>
                            <dd class="text-[#FBBF24] font-semibold">R$ {{ number_format($stats['overdue_amount'], 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <dt class="text-[#71717A] text-sm">Lucro líquido</dt>
                            <dd class="text-white font-semibold">R$ {{ number_format($stats['profit'], 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#F43F5E] to-[#BE123C] text-white">
                        <i data-lucide="wrench" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Manutenção</h3>
                </div>
                <div class="p-5">
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-[#1F1F23]">
                            <dt class="text-[#71717A] text-sm">Em aberto</dt>
                            <dd class="text-[#FBBF24] font-semibold">{{ $stats['open_maintenance'] }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <dt class="text-[#71717A] text-sm">Custo total</dt>
                            <dd class="text-white font-semibold">R$ {{ number_format($stats['maintenance_cost'], 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
