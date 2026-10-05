<div x-data="{ tab: 'overview' }">
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        @php $cover = $property->photos->where('is_cover', true)->first() ?? $property->photos->first(); @endphp
        <div class="relative h-48 sm:h-56 overflow-hidden bg-gradient-to-br from-[#1F1F23] to-[#0F0F12]">
            @if($cover)
                <img src="{{ asset('storage/' . $cover->path) }}" class="w-full h-full object-cover opacity-50">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0F0F12] via-[#0F0F12]/60 to-transparent"></div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.10)] to-[rgba(168,85,247,0.05)]"></div>
            @endif
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyB2aWV3Qm94PSIwIDAgNjAgNjAiPjxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGcgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNIDAgMCBMIDAgNjAgTTYwIDAgTDYwIDYwIi8+PC9nPjwvZz48L3N2Zz4=')] opacity-30"></div>
        </div>

        <div class="relative px-6 lg:px-8 pb-6 -mt-24">
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-1.5 text-xs text-[#A1A1AA] hover:text-white mb-4 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar para imóveis
            </a>
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <div class="flex items-end gap-4">
                    <div class="icon-box icon-box-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] shadow-xl shadow-[#22C55E]/30 flex-shrink-0">
                        <i data-lucide="{{ $property->type->icon() }}" class="w-5 h-5"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">{{ $property->name }}</h1>
                            <x-ui.badge :variant="$property->status->color()">{{ $property->status->label() }}</x-ui.badge>
                        </div>
                        <p class="text-sm text-[#71717A] font-mono">{{ $property->code }} · {{ $property->type->label() }}</p>
                        <p class="text-sm text-[#A1A1AA] flex items-center gap-1.5 mt-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#52525B]"></i> {{ $property->fullAddress() }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('properties.edit', $property) }}" class="btn btn-secondary">
                        <i data-lucide="edit-2" class="w-4 h-4"></i> Editar
                    </a>
                    <a href="{{ route('contracts.create') }}?property_id={{ $property->id }}" class="btn btn-primary shadow-lg shadow-[#22C55E]/10">
                        <i data-lucide="file-plus" class="w-4 h-4"></i> Novo contrato
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
        <div class="card p-4 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Aluguel</span>
                <i data-lucide="banknote" class="w-3.5 h-3.5 text-[#52525B]"></i>
            </div>
            <p class="text-lg font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format((float) $property->rent_amount, 0, ',', '.') }}</p>
            <p class="text-[10px] text-[#52525B] mt-0.5">mensal</p>
        </div>
        <div class="card p-4 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Recebido</span>
                <i data-lucide="trending-up" class="w-3.5 h-3.5 text-[#52525B]"></i>
            </div>
            <p class="text-lg font-bold text-white tracking-tight">R$ {{ number_format((float) $stats['total_paid'], 0, ',', '.') }}</p>
            <p class="text-[10px] text-[#52525B] mt-0.5">total</p>
        </div>
        <div class="card p-4 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Contratos</span>
                <i data-lucide="file-text" class="w-3.5 h-3.5 text-[#52525B]"></i>
            </div>
            <p class="text-lg font-bold text-white tracking-tight">{{ $stats['active_contracts'] }}<span class="text-sm text-[#52525B]">/{{ $stats['total_contracts'] }}</span></p>
            <p class="text-[10px] text-[#52525B] mt-0.5">ativos/total</p>
        </div>
        <div class="card p-4 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Manutenções</span>
                <i data-lucide="wrench" class="w-3.5 h-3.5 text-[#52525B]"></i>
            </div>
            <p class="text-lg font-bold text-[#F59E0B] tracking-tight">{{ $stats['open_maintenance'] }} <span class="text-xs text-[#52525B]">abertas</span></p>
            <p class="text-[10px] text-[#52525B] mt-0.5">em andamento</p>
        </div>
        <div class="card p-4 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Área</span>
                <i data-lucide="maximize" class="w-3.5 h-3.5 text-[#52525B]"></i>
            </div>
            <p class="text-lg font-bold text-white tracking-tight">{{ $property->area_total ?? '—' }} <span class="text-xs text-[#52525B]">m²</span></p>
            <p class="text-[10px] text-[#52525B] mt-0.5">total</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="card overflow-hidden">
        <div class="border-b border-[#1F1F23] bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
            <nav class="tabs-nav">
                @foreach(['overview' => ['Visão Geral', 'layout-dashboard'], 'photos' => ['Fotos', 'image'], 'contract' => ['Contrato', 'file-text'], 'financial' => ['Financeiro', 'banknote'], 'maintenance' => ['Manutenção', 'wrench'], 'documents' => ['Documentos', 'folder']] as $key => $info)
                    <button type="button" @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ? 'active' : ''"
                            class="tab-btn inline-flex items-center gap-2">
                        <i data-lucide="{{ $info[1] }}" class="w-3.5 h-3.5"></i>
                        {{ $info[0] }}
                    </button>
                @endforeach
            </nav>
        </div>

        <div x-show="tab === 'overview'" class="p-6 lg:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-[#71717A] uppercase tracking-wider mb-3">Descrição</h3>
                        <p class="text-sm text-[#A1A1AA] leading-relaxed">{{ $property->description ?? 'Sem descrição cadastrada.' }}</p>
                    </div>

                    <div class="divider-dotted"></div>

                    <div>
                        <h3 class="text-xs font-bold text-[#71717A] uppercase tracking-wider mb-4">Características</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="p-3 rounded-lg bg-[#0F0F12] border border-[#1F1F23] text-center">
                                <i data-lucide="bed" class="w-5 h-5 text-[#71717A] mx-auto mb-1.5"></i>
                                <p class="text-lg font-bold text-white">{{ $property->bedrooms ?? '—' }}</p>
                                <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Quartos</p>
                            </div>
                            <div class="p-3 rounded-lg bg-[#0F0F12] border border-[#1F1F23] text-center">
                                <i data-lucide="bath" class="w-5 h-5 text-[#71717A] mx-auto mb-1.5"></i>
                                <p class="text-lg font-bold text-white">{{ $property->bathrooms ?? '—' }}</p>
                                <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Banheiros</p>
                            </div>
                            <div class="p-3 rounded-lg bg-[#0F0F12] border border-[#1F1F23] text-center">
                                <i data-lucide="car" class="w-5 h-5 text-[#71717A] mx-auto mb-1.5"></i>
                                <p class="text-lg font-bold text-white">{{ $property->parking_spaces ?? '—' }}</p>
                                <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Vagas</p>
                            </div>
                            <div class="p-3 rounded-lg bg-[#0F0F12] border border-[#1F1F23] text-center">
                                <i data-lucide="layers" class="w-5 h-5 text-[#71717A] mx-auto mb-1.5"></i>
                                <p class="text-lg font-bold text-white">{{ $property->floor ?? '—' }}</p>
                                <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Andar</p>
                            </div>
                        </div>
                    </div>

                    @if($property->is_furnished || $property->pets_allowed || $property->is_published)
                        <div class="divider-dotted"></div>
                        <div>
                            <h3 class="text-xs font-bold text-[#71717A] uppercase tracking-wider mb-3">Diferenciais</h3>
                            <div class="flex flex-wrap gap-2">
                                @if($property->is_furnished)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[rgba(34,197,94,0.08)] border border-[rgba(34,197,94,0.18)] text-[#4ADE80] rounded-full text-xs font-medium">
                                        <i data-lucide="sofa" class="w-3.5 h-3.5"></i> Mobiliado
                                    </span>
                                @endif
                                @if($property->pets_allowed)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[rgba(59,130,246,0.08)] border border-[rgba(59,130,246,0.18)] text-[#60A5FA] rounded-full text-xs font-medium">
                                        <i data-lucide="paw-print" class="w-3.5 h-3.5"></i> Aceita pets
                                    </span>
                                @endif
                                @if($property->is_published)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[rgba(168,85,247,0.08)] border border-[rgba(168,85,247,0.18)] text-[#C084FC] rounded-full text-xs font-medium">
                                        <i data-lucide="globe" class="w-3.5 h-3.5"></i> Publicado
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="space-y-4">
                    <x-ui.card title="Proprietário" icon="user-round">
                        @if($property->owner)
                            <div class="flex items-center gap-3">
                                <div class="avatar avatar-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                                    {{ $property->owner->initials() }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-white truncate">{{ $property->owner->name }}</div>
                                    <div class="text-xs text-[#71717A] truncate">{{ $property->owner->email }}</div>
                                </div>
                            </div>
                            <a href="{{ route('owners.show', $property->owner) }}" class="mt-4 text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium inline-flex items-center gap-1 transition-colors">
                                Ver proprietário <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        @else
                            <div class="flex items-center gap-3 text-[#71717A]">
                                <i data-lucide="user-x" class="w-5 h-5"></i>
                                <p class="text-sm">Sem proprietário vinculado.</p>
                            </div>
                        @endif
                    </x-ui.card>

                    @if($property->activeContract)
                        <x-ui.card title="Inquilino atual" icon="user">
                            <div class="flex items-center gap-3">
                                <div class="avatar avatar-md bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white">
                                    {{ $property->activeContract->tenant->initials() }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-white truncate">{{ $property->activeContract->tenant->name }}</div>
                                    <div class="text-xs text-[#71717A] truncate">{{ $property->activeContract->tenant->email }}</div>
                                </div>
                            </div>
                            <a href="{{ route('contracts.show', $property->activeContract) }}" class="mt-4 text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium inline-flex items-center gap-1 transition-colors">
                                Ver contrato <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </x-ui.card>
                    @endif
                </div>
            </div>
        </div>

        <div x-show="tab === 'photos'" class="p-6 lg:p-8" x-cloak>
            @if($property->photos->count())
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-white">{{ $property->photos->count() }} fotos cadastradas</h3>
                    <button class="text-xs text-[#71717A] hover:text-white transition-colors inline-flex items-center gap-1">
                        <i data-lucide="upload" class="w-3.5 h-3.5"></i> Adicionar fotos
                    </button>
                </div>
                <div class="photo-grid">
                    @foreach($property->photos as $photo)
                        <div class="photo-tile hover-lift relative group/photo">
                            <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-full object-cover">
                            @if($photo->is_cover)
                                <div class="absolute top-2 left-2">
                                    <span class="badge badge-success backdrop-blur shadow-lg">
                                        <i data-lucide="star" class="w-3 h-3"></i> Capa
                                    </span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/photo:opacity-100 transition-opacity flex items-center justify-center">
                                <button class="w-9 h-9 rounded-full bg-white/10 backdrop-blur flex items-center justify-center hover:bg-white/20 transition-colors">
                                    <i data-lucide="maximize-2" class="w-4 h-4 text-white"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state icon="image" title="Sem fotos" description="Adicione fotos deste imóvel para mostrá-lo melhor." />
            @endif
        </div>

        <div x-show="tab === 'contract'" class="p-6 lg:p-8" x-cloak>
            @if($property->activeContract)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 mb-6">
                    <div class="p-4 rounded-xl bg-[#0F0F12] border border-[#1F1F23]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Número do contrato</p>
                        <p class="text-base font-mono font-semibold text-white">{{ $property->activeContract->number }}</p>
                        <div class="mt-2"><x-ui.badge :variant="$property->activeContract->status->color()">{{ $property->activeContract->status->label() }}</x-ui.badge></div>
                    </div>
                    <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                        <p class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Valor mensal</p>
                        <p class="text-xl font-bold text-[#4ADE80]">R$ {{ number_format((float) $property->activeContract->rent_amount, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Início</p>
                        <p class="text-sm font-medium text-white">{{ $property->activeContract->start_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Vencimento</p>
                        <p class="text-sm font-medium text-white">{{ $property->activeContract->end_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Dia de vencimento</p>
                        <p class="text-sm font-medium text-white">Dia {{ $property->activeContract->due_day }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Duração</p>
                        <p class="text-sm font-medium text-white">{{ $property->activeContract->durationInMonths() }} meses</p>
                    </div>
                </div>
                <a href="{{ route('contracts.show', $property->activeContract) }}" class="btn btn-secondary">
                    <i data-lucide="external-link" class="w-4 h-4"></i> Ver contrato completo
                </a>
            @else
                <x-ui.empty-state icon="file" title="Sem contrato ativo" description="Crie um contrato para este imóvel.">
                    <x-slot:action>
                        <a href="{{ route('contracts.create') }}?property_id={{ $property->id }}" class="btn btn-primary">
                            <i data-lucide="plus" class="w-4 h-4"></i> Criar contrato
                        </a>
                    </x-slot:action>
                </x-ui.empty-state>
            @endif
        </div>

        <div x-show="tab === 'financial'" class="p-6 lg:p-8" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="card p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#22C55E]/10 rounded-full blur-3xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total recebido</span>
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-[#22C55E]"></i>
                        </div>
                        <p class="text-2xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format((float) $stats['total_paid'], 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="card p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">A receber</span>
                            <i data-lucide="clock" class="w-4 h-4 text-[#F59E0B]"></i>
                        </div>
                        <p class="text-2xl font-bold text-[#F59E0B] tracking-tight">R$ {{ number_format((float) ($stats['total_charges'] - $stats['total_paid']), 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="card p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#3B82F6]/10 rounded-full blur-3xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Taxa administrativa</span>
                            <i data-lucide="percent" class="w-4 h-4 text-[#3B82F6]"></i>
                        </div>
                        <p class="text-2xl font-bold text-white tracking-tight">{{ $property->activeContract?->admin_fee_percent ?? 8 }}%</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('charges.index') }}?property_id={{ $property->id }}" class="btn btn-secondary">
                <i data-lucide="receipt" class="w-4 h-4"></i> Ver todas as cobranças
            </a>
        </div>

        <div x-show="tab === 'maintenance'" class="p-6 lg:p-8" x-cloak>
            @if($property->maintenanceRequests->count())
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-white">{{ $property->maintenanceRequests->count() }} solicitações</h3>
                    <a href="{{ route('maintenance.index') }}?property_id={{ $property->id }}" class="text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium inline-flex items-center gap-1 transition-colors">
                        Ver todas <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="space-y-2">
                    @foreach($property->maintenanceRequests->take(10) as $req)
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
                <x-ui.empty-state icon="wrench" title="Sem manutenções" description="Nenhuma solicitação registrada." />
            @endif
        </div>

        <div x-show="tab === 'documents'" class="p-6 lg:p-8" x-cloak>
            @if($property->files->count())
                <div class="space-y-2">
                    @foreach($property->files as $file)
                        <div class="card card-hover p-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="icon-box icon-box-md bg-[#1A1A1F] border border-[#27272A] text-[#A1A1AA]">
                                    <i data-lucide="file" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm text-white">{{ $file->name }}</span>
                            </div>
                            <span class="text-xs text-[#71717A]">{{ $file->humanSize() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state icon="folder-open" title="Sem documentos" description="Faça upload de documentos do imóvel." />
            @endif
        </div>
    </div>
</div>
