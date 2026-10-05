<div x-data="{ tab: 'contract' }">
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(59,130,246,0.08)] via-transparent to-[rgba(34,197,94,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#3B82F6] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <a href="{{ route('tenants.index') }}" class="inline-flex items-center gap-1.5 text-xs text-[#A1A1AA] hover:text-white mb-6 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar para inquilinos
            </a>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
                <div class="flex items-end gap-5">
                    <div class="avatar avatar-xl bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white text-xl shadow-xl shadow-[#3B82F6]/30 flex-shrink-0">
                        {{ $tenant->initials() }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                            <i data-lucide="user-round" class="w-3 h-3"></i>
                            Inquilino
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">{{ $tenant->name }}</h1>
                        <p class="text-sm text-[#71717A] mt-1.5">{{ $tenant->profession ?? '—' }} · {{ $tenant->email ?? '—' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($tenant->phone || $tenant->mobile)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $tenant->mobile ?? $tenant->phone) }}" target="_blank" class="btn btn-secondary">
                            <i data-lucide="message-circle" class="w-4 h-4"></i> WhatsApp
                        </a>
                    @endif
                    @if($tenant->email)
                        <a href="mailto:{{ $tenant->email }}" class="btn btn-secondary">
                            <i data-lucide="mail" class="w-4 h-4"></i> Email
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl {{ $tenant->totalPending() > 0 ? 'bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $tenant->totalPending() > 0 ? 'text-[#FBBF24]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Pendências</span>
                        <i data-lucide="clock" class="w-3.5 h-3.5 {{ $tenant->totalPending() > 0 ? 'text-[#FBBF24]' : 'text-[#52525B]' }}"></i>
                    </div>
                    <div class="text-xl font-bold {{ $tenant->totalPending() > 0 ? 'text-[#FBBF24]' : 'text-white' }} tracking-tight">R$ {{ number_format($tenant->totalPending(), 2, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">a pagar</div>
                </div>
                <div class="p-4 rounded-xl {{ $tenant->totalOverdue() > 0 ? 'bg-gradient-to-br from-[rgba(244,63,94,0.06)] to-[rgba(244,63,94,0.01)] border border-[rgba(244,63,94,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $tenant->totalOverdue() > 0 ? 'text-[#FB7185]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Em atraso</span>
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 {{ $tenant->totalOverdue() > 0 ? 'text-[#FB7185]' : 'text-[#52525B]' }}"></i>
                    </div>
                    <div class="text-xl font-bold {{ $tenant->totalOverdue() > 0 ? 'text-[#FB7185]' : 'text-white' }} tracking-tight">R$ {{ number_format($tenant->totalOverdue(), 2, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">vencido</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Renda mensal</span>
                        <i data-lucide="wallet" class="w-3.5 h-3.5 text-[#52525B]"></i>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format((float) $tenant->monthly_income, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">declarada</div>
                </div>
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Manutenções</span>
                        <i data-lucide="wrench" class="w-3.5 h-3.5 text-[#52525B]"></i>
                    </div>
                    <div class="text-2xl font-bold {{ $tenant->maintenanceRequests->count() > 0 ? 'text-[#F59E0B]' : 'text-white' }} tracking-tight">{{ $tenant->maintenanceRequests->count() }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">abertas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="card overflow-hidden">
        <div class="border-b border-[#1F1F23] bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
            <nav class="tabs-nav">
                @foreach(['contract' => ['Contrato', 'file-text'], 'charges' => ['Cobranças', 'receipt', $tenant->charges->count()], 'maintenance' => ['Manutenções', 'wrench', $tenant->maintenanceRequests->count()], 'info' => ['Informações', 'info']] as $key => $info)
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

        <div x-show="tab === 'contract'" class="p-6 lg:p-8">
            @if($tenant->activeContract)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="p-4 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Imóvel alugado</p>
                        <a href="{{ route('properties.show', $tenant->activeContract->property) }}" class="text-base font-medium text-white mt-1 hover:text-[#4ADE80] transition-colors inline-flex items-center gap-1.5">
                            <i data-lucide="building-2" class="w-4 h-4 text-[#71717A]"></i>
                            {{ $tenant->activeContract->property->name }}
                            <i data-lucide="external-link" class="w-3 h-3 text-[#71717A]"></i>
                        </a>
                    </div>
                    <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Status do contrato</p>
                        <div class="mt-2"><x-ui.badge :variant="$tenant->activeContract->status->color()">{{ $tenant->activeContract->status->label() }}</x-ui.badge></div>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Início</p>
                        <p class="text-base font-medium text-white mt-1">{{ $tenant->activeContract->start_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Vencimento</p>
                        <p class="text-base font-medium text-white mt-1">{{ $tenant->activeContract->end_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Aluguel</p>
                        <p class="text-lg font-bold text-[#4ADE80] mt-1">R$ {{ number_format((float) $tenant->activeContract->rent_amount, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Dia de vencimento</p>
                        <p class="text-base font-medium text-white mt-1">Dia {{ $tenant->activeContract->due_day }}</p>
                    </div>
                </div>
                <a href="{{ route('contracts.show', $tenant->activeContract) }}" class="btn btn-secondary">
                    <i data-lucide="external-link" class="w-4 h-4"></i> Ver contrato completo
                </a>
            @else
                <x-ui.empty-state icon="file" title="Sem contrato ativo" />
            @endif
        </div>

        <div x-show="tab === 'charges'" class="p-6 lg:p-8" x-cloak>
            @if($tenant->charges->count())
                <div class="table-wrapper">
                    <table class="table">
                        <thead><tr><th>Referência</th><th>Valor</th><th>Vencimento</th><th>Pago em</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($tenant->charges->take(20) as $charge)
                                <tr>
                                    <td class="font-mono text-xs">{{ $charge->reference }}</td>
                                    <td>R$ {{ number_format((float) $charge->total_amount, 2, ',', '.') }}</td>
                                    <td>{{ $charge->due_date->format('d/m/Y') }}</td>
                                    <td>{{ $charge->paid_at?->format('d/m/Y') ?? '—' }}</td>
                                    <td><x-ui.badge :variant="$charge->status->color()">{{ $charge->status->label() }}</x-ui.badge></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-ui.empty-state icon="receipt" title="Sem cobranças" />
            @endif
        </div>

        <div x-show="tab === 'maintenance'" class="p-6 lg:p-8" x-cloak>
            @if($tenant->maintenanceRequests->count())
                <div class="space-y-2">
                    @foreach($tenant->maintenanceRequests as $req)
                        <a href="{{ route('maintenance.show', $req) }}" class="block card card-hover p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="icon-box icon-box-md bg-[#1A1A1F] border border-[#27272A] text-[#A1A1AA] flex-shrink-0">
                                        <i data-lucide="{{ $req->category?->icon() ?? 'wrench' }}" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-white truncate">{{ $req->title }}</div>
                                        <div class="text-xs text-[#71717A] truncate mt-0.5">{{ $req->category?->label() }} · {{ $req->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                <x-ui.badge :variant="$req->status->color()">{{ $req->status->label() }}</x-ui.badge>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state icon="wrench" title="Sem manutenções" />
            @endif
        </div>

        <div x-show="tab === 'info'" class="p-6 lg:p-8" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">CPF</p>
                    <p class="text-sm text-white mt-1 font-mono">{{ $tenant->tax_id ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Data de nascimento</p>
                    <p class="text-sm text-white mt-1">{{ $tenant->birth_date?->format('d/m/Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Estado civil</p>
                    <p class="text-sm text-white mt-1">{{ $tenant->marital_status ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Profissão</p>
                    <p class="text-sm text-white mt-1">{{ $tenant->profession ?? '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Endereço</p>
                    <p class="text-sm text-white mt-1">{{ $tenant->address ?? '—' }}, {{ $tenant->city ?? '' }} - {{ $tenant->state ?? '' }}</p>
                </div>
                @if($tenant->emergency_contact_name)
                    <div class="md:col-span-2 pt-5 border-t border-[#1F1F23]">
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Contato de emergência</p>
                        <p class="text-sm text-white mt-1">{{ $tenant->emergency_contact_name }} · {{ $tenant->emergency_contact_phone }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
