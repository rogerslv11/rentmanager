<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.05)] via-transparent to-[rgba(168,85,247,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="users-round" class="w-3 h-3"></i>
                        Carteira
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Proprietários</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Gerencie todos os donos de imóveis da sua carteira</p>
                </div>
                <a href="{{ route('owners.create') }}" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Novo proprietário
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/20">
                            <i data-lucide="users-round" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">proprietários</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Receita total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="trending-up" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['totalRevenue'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">mensal combinada</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.05)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Com PIX</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="zap" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['withPix'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">prontos para repasse</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Dados completos</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['withBank'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">com dados bancários</div>
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
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome, CPF/CNPJ ou email..." class="pl-10">
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

    @if($this->owners->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Proprietário</th>
                        <th>Documento</th>
                        <th>Contato</th>
                        <th class="text-center">Imóveis</th>
                        <th class="text-center">Repasses</th>
                        <th class="text-right">Receita mensal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->owners as $owner)
                        <tr>
                            <td>
                                <a href="{{ route('owners.show', $owner) }}" class="flex items-center gap-3 group">
                                    <div class="avatar avatar-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] text-xs shadow-lg shadow-[#22C55E]/10">
                                        {{ $owner->initials() }}
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-medium text-white group-hover:text-[#4ADE80] transition-colors block">{{ $owner->name }}</span>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($owner->pix_key)
                                                <span class="inline-flex items-center gap-1 text-[10px] text-[#4ADE80]">
                                                    <i data-lucide="zap" class="w-3 h-3"></i> PIX
                                                </span>
                                            @endif
                                            @if($owner->bank_name)
                                                <span class="inline-flex items-center gap-1 text-[10px] text-[#71717A]">
                                                    <i data-lucide="banknote" class="w-3 h-3"></i> {{ $owner->bank_name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td class="font-mono text-xs text-[#A1A1AA]">{{ $owner->tax_id ?? '—' }}</td>
                            <td>
                                <div class="text-sm text-white">{{ $owner->email ?? '—' }}</div>
                                <div class="text-xs text-[#71717A]">{{ $owner->phone ?? '—' }}</div>
                            </td>
                            <td class="text-center"><x-ui.badge variant="info">{{ $owner->properties_count }}</x-ui.badge></td>
                            <td class="text-center"><x-ui.badge variant="success">{{ $owner->payouts_count }}</x-ui.badge></td>
                            <td class="text-right">
                                <span class="text-[#4ADE80] font-semibold">R$ {{ number_format($owner->monthlyRevenue(), 0, ',', '.') }}</span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('owners.show', $owner) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#4ADE80] hover:text-[#22C55E] transition-colors">
                                    Ver perfil
                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->owners->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="users-round" :title="$search ? 'Nenhum resultado' : 'Nenhum proprietário'" :description="$search ? 'Ajuste a busca para ver mais resultados.' : 'Cadastre o primeiro proprietário.'">
                <x-slot:action>
                    @if($search)
                        <button wire:click="$set('search', '')" class="btn btn-secondary">
                            <i data-lucide="x" class="w-4 h-4"></i> Limpar busca
                        </button>
                    @else
                        <a href="{{ route('owners.create') }}" class="btn btn-primary">
                            <i data-lucide="plus" class="w-4 h-4"></i> Cadastrar
                        </a>
                    @endif
                </x-slot:action>
            </x-ui.empty-state>
        </div>
    @endif
</div>
