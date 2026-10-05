<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(59,130,246,0.06)] via-transparent to-[rgba(34,197,94,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#3B82F6] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="user-round" class="w-3 h-3"></i>
                        Carteira
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Inquilinos</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Gerencie todos os locatários e seus contratos</p>
                </div>
                <a href="{{ route('tenants.create') }}" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Novo inquilino
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="users" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">inquilinos cadastrados</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.05)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Com contrato</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="file-check" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['active'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">ativos</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Com portal</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="key" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['withPortal'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">acesso ativo</div>
                </div>

                <div class="p-4 rounded-xl {{ $this->stats['withDebt'] > 0 ? 'bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $this->stats['withDebt'] > 0 ? 'text-[#FBBF24]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Pendências</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold {{ $this->stats['withDebt'] > 0 ? 'text-[#FBBF24]' : 'text-white' }} tracking-tight">R$ {{ number_format($this->stats['totalDebt'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['withDebt'] }} com pendência</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-9">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome, CPF ou email..." class="pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                @if($search)
                    <button wire:click="$set('search', '')" class="btn btn-secondary w-full">
                        <i data-lucide="x" class="w-4 h-4"></i> Limpar busca
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($this->tenants->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Inquilino</th>
                        <th>CPF</th>
                        <th>Contato</th>
                        <th>Imóvel atual</th>
                        <th>Pendências</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->tenants as $tenant)
                        <tr>
                            <td>
                                <a href="{{ route('tenants.show', $tenant) }}" class="flex items-center gap-3 group">
                                    <div class="avatar avatar-md bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white text-xs shadow-lg shadow-[#3B82F6]/10">
                                        {{ $tenant->initials() }}
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-medium text-white group-hover:text-[#60A5FA] transition-colors block">{{ $tenant->name }}</span>
                                        <div class="text-xs text-[#71717A] mt-0.5">{{ $tenant->profession ?? '—' }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="font-mono text-xs text-[#A1A1AA]">{{ $tenant->tax_id ?? '—' }}</td>
                            <td>
                                <div class="text-sm text-white">{{ $tenant->email ?? '—' }}</div>
                                <div class="text-xs text-[#71717A]">{{ $tenant->phone ?? '—' }}</div>
                            </td>
                            <td>
                                @if($tenant->activeContract)
                                    <a href="{{ route('properties.show', $tenant->activeContract->property) }}" class="text-[#A1A1AA] hover:text-white text-sm transition-colors inline-flex items-center gap-1.5">
                                        <i data-lucide="building" class="w-3 h-3"></i>
                                        {{ $tenant->activeContract->property->name }}
                                    </a>
                                @else
                                    <span class="text-[#52525B] inline-flex items-center gap-1.5">
                                        <i data-lucide="minus" class="w-3 h-3"></i>
                                        Sem contrato
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($tenant->totalPending() > 0)
                                    <span class="badge badge-warning font-semibold">R$ {{ number_format($tenant->totalPending(), 0, ',', '.') }}</span>
                                @else
                                    <span class="badge badge-success">
                                        <i data-lucide="check" class="w-3 h-3"></i> Em dia
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('tenants.show', $tenant) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#4ADE80] hover:text-[#22C55E] transition-colors">
                                    Ver perfil
                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->tenants->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="user-round" :title="$search ? 'Nenhum resultado' : 'Nenhum inquilino'" :description="$search ? 'Ajuste a busca para ver mais resultados.' : 'Cadastre o primeiro inquilino.'">
                <x-slot:action>
                    @if($search)
                        <button wire:click="$set('search', '')" class="btn btn-secondary">
                            <i data-lucide="x" class="w-4 h-4"></i> Limpar busca
                        </button>
                    @else
                        <a href="{{ route('tenants.create') }}" class="btn btn-primary">
                            <i data-lucide="plus" class="w-4 h-4"></i> Cadastrar
                        </a>
                    @endif
                </x-slot:action>
            </x-ui.empty-state>
        </div>
    @endif
</div>
