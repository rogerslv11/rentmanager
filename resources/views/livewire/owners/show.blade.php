<div x-data="{ tab: 'properties' }">
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.08)] via-transparent to-[rgba(59,130,246,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <a href="{{ route('owners.index') }}" class="inline-flex items-center gap-1.5 text-xs text-[#A1A1AA] hover:text-white mb-6 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar para proprietários
            </a>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
                <div class="flex items-end gap-5">
                    <div class="avatar avatar-xl bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] text-xl shadow-xl shadow-[#22C55E]/30 flex-shrink-0">
                        {{ $owner->initials() }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                            <i data-lucide="user-round" class="w-3 h-3"></i>
                            Proprietário
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">{{ $owner->name }}</h1>
                        <p class="text-sm text-[#71717A] mt-1.5">{{ $owner->tax_id ?? '—' }} · {{ $owner->email ?? '—' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($owner->phone || $owner->mobile)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $owner->mobile ?? $owner->phone) }}" target="_blank" class="btn btn-secondary">
                            <i data-lucide="message-circle" class="w-4 h-4"></i> WhatsApp
                        </a>
                    @endif
                    @if($owner->email)
                        <a href="mailto:{{ $owner->email }}" class="btn btn-secondary">
                            <i data-lucide="mail" class="w-4 h-4"></i> Email
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Imóveis</span>
                        <i data-lucide="building-2" class="w-3.5 h-3.5 text-[#52525B]"></i>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $owner->properties->count() }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">vinculados</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.05)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Receita mensal</span>
                        <i data-lucide="trending-up" class="w-3.5 h-3.5 text-[#4ADE80]"></i>
                    </div>
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format($owner->monthlyRevenue(), 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">recorrente</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">A repassar</span>
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-[#52525B]"></i>
                    </div>
                    <div class="text-xl font-bold text-[#F59E0B] tracking-tight">R$ {{ number_format($owner->pendingPayoutsAmount(), 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">pendente</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total recebido</span>
                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-[#52525B]"></i>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($owner->totalReceived(), 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">histórico</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="card overflow-hidden">
        <div class="border-b border-[#1F1F23] bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
            <nav class="tabs-nav">
                @foreach(['properties' => ['Imóveis', 'building-2', $owner->properties->count()], 'contracts' => ['Contratos', 'file-text', $owner->contracts->count()], 'payouts' => ['Repasses', 'banknote', $owner->payouts->count()]] as $key => $info)
                    <button type="button" @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ? 'active' : ''"
                            class="tab-btn inline-flex items-center gap-2">
                        <i data-lucide="{{ $info[1] }}" class="w-3.5 h-3.5"></i>
                        {{ $info[0] }}
                        <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === $key ? 'bg-[#22C55E]/20 text-[#4ADE80]' : 'bg-[#1F1F23] text-[#71717A]' }}">{{ $info[2] }}</span>
                    </button>
                @endforeach
            </nav>
        </div>

        <div x-show="tab === 'properties'" class="p-6">
            @if($owner->properties->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($owner->properties as $property)
                        <a href="{{ route('properties.show', $property) }}" class="card card-hover p-4 group">
                            <div class="flex items-start justify-between mb-3">
                                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                                    <i data-lucide="{{ $property->type->icon() }}" class="w-4 h-4"></i>
                                </div>
                                <x-ui.badge :variant="$property->status->color()" size="sm">{{ $property->status->label() }}</x-ui.badge>
                            </div>
                            <div class="font-medium text-white truncate group-hover:text-[#4ADE80] transition-colors">{{ $property->name }}</div>
                            <div class="text-xs text-[#71717A] mt-0.5">{{ $property->type->label() }}</div>
                            <div class="mt-3 pt-3 border-t border-[#1F1F23] flex items-center justify-between">
                                <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Aluguel</span>
                                <span class="text-sm text-[#4ADE80] font-semibold">R$ {{ number_format((float) $property->rent_amount, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state icon="building-2" title="Nenhum imóvel vinculado" />
            @endif
        </div>

        <div x-show="tab === 'contracts'" class="p-6" x-cloak>
            @if($owner->contracts->count())
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr><th>Número</th><th>Imóvel</th><th>Inquilino</th><th>Período</th><th>Valor</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach($owner->contracts as $c)
                                <tr>
                                    <td><a href="{{ route('contracts.show', $c) }}" class="text-white hover:text-[#4ADE80] font-medium transition-colors">{{ $c->number }}</a></td>
                                    <td>{{ $c->property->name }}</td>
                                    <td>{{ $c->tenant->name }}</td>
                                    <td class="text-xs">{{ $c->start_date->format('d/m/Y') }} → {{ $c->end_date->format('d/m/Y') }}</td>
                                    <td class="text-[#4ADE80] font-semibold">R$ {{ number_format((float) $c->rent_amount, 0, ',', '.') }}</td>
                                    <td><x-ui.badge :variant="$c->status->color()">{{ $c->status->label() }}</x-ui.badge></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-ui.empty-state icon="file-text" title="Sem contratos" />
            @endif
        </div>

        <div x-show="tab === 'payouts'" class="p-6" x-cloak>
            @if($owner->payouts->count())
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr><th>Referência</th><th>Período</th><th>Bruto</th><th>Taxa</th><th>Líquido</th><th>Status</th><th>Pago em</th></tr>
                        </thead>
                        <tbody>
                            @foreach($owner->payouts as $p)
                                <tr>
                                    <td>{{ $p->reference ?? '—' }}</td>
                                    <td class="text-xs">{{ $p->period_start?->format('d/m/Y') }} → {{ $p->period_end?->format('d/m/Y') }}</td>
                                    <td>R$ {{ number_format((float) $p->gross_amount, 2, ',', '.') }}</td>
                                    <td class="text-[#F43F5E]">R$ {{ number_format((float) $p->admin_fee, 2, ',', '.') }}</td>
                                    <td class="text-[#4ADE80] font-semibold">R$ {{ number_format((float) $p->net_amount, 2, ',', '.') }}</td>
                                    <td><x-ui.badge :variant="$p->status->color()">{{ $p->status->label() }}</x-ui.badge></td>
                                    <td>{{ $p->paid_at?->format('d/m/Y') ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-ui.empty-state icon="banknote" title="Sem repasses" />
            @endif
        </div>
    </div>
</div>
