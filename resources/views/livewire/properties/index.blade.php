<div>
    {{-- Hero stats header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.06)] via-transparent to-[rgba(168,85,247,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="building-2" class="w-3 h-3"></i>
                        Carteira de imóveis
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Imóveis</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Gerencie toda a sua carteira em um só lugar</p>
                </div>
                <a href="{{ route('properties.create') }}" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                    <i data-lucide="plus" class="w-4 h-4"></i> Cadastrar imóvel
                </a>
            </div>

            {{-- Hero stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                <div class="relative p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23] hover:border-[#27272A] transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="building-2" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">imóveis cadastrados</div>
                </div>

                <div class="relative p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.05)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Ocupação</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="pie-chart" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['occupancy'] }}%</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['rented'] }} de {{ $this->stats['total'] }} alugados</div>
                </div>

                <div class="relative p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23] hover:border-[#27272A] transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Receita potencial</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/20">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['monthlyRevenue'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">mensal</div>
                </div>

                <div class="relative p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23] hover:border-[#27272A] transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Aluguel médio</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="trending-up" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['avgRent'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">por imóvel</div>
                </div>
            </div>

            {{-- Status quick filter pills --}}
            <div class="flex items-center gap-2 flex-wrap">
                <button wire:click="$set('statusFilter', '')"
                    class="group inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                    {{ $statusFilter === '' ? 'bg-white text-[#09090B] border-white' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                    <span>Todos</span>
                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === '' ? 'bg-[#09090B]/10' : 'bg-[#1F1F23]' }}">{{ $this->stats['total'] }}</span>
                </button>
                @foreach($this->statusBreakdown as $s)
                    @if($s['value'] > 0)
                        @php
                            $activeColor = match($s['color']) {
                                'green' => 'bg-[#22C55E] text-[#052E16] border-[#22C55E]',
                                'blue' => 'bg-[#3B82F6] text-white border-[#3B82F6]',
                                'yellow' => 'bg-[#F59E0B] text-[#451A03] border-[#F59E0B]',
                                'purple' => 'bg-[#A855F7] text-white border-[#A855F7]',
                                'gray' => 'bg-[#52525B] text-white border-[#52525B]',
                                default => 'bg-[#52525B] text-white border-[#52525B]',
                            };
                            $inactiveColor = match($s['color']) {
                                'green' => 'bg-[rgba(34,197,94,0.08)] text-[#4ADE80] border-[rgba(34,197,94,0.18)] hover:bg-[rgba(34,197,94,0.15)]',
                                'blue' => 'bg-[rgba(59,130,246,0.08)] text-[#60A5FA] border-[rgba(59,130,246,0.18)] hover:bg-[rgba(59,130,246,0.15)]',
                                'yellow' => 'bg-[rgba(245,158,11,0.08)] text-[#FBBF24] border-[rgba(245,158,11,0.18)] hover:bg-[rgba(245,158,11,0.15)]',
                                'purple' => 'bg-[rgba(168,85,247,0.08)] text-[#C084FC] border-[rgba(168,85,247,0.18)] hover:bg-[rgba(168,85,247,0.15)]',
                                'gray' => 'bg-[#1F1F23] text-[#A1A1AA] border-[#27272A] hover:bg-[#27272A]',
                                default => 'bg-[#1F1F23] text-[#A1A1AA] border-[#27272A]',
                            };
                        @endphp
                        <button wire:click="$set('statusFilter', '{{ $s['status'] }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                            {{ $statusFilter === $s['status'] ? $activeColor : $inactiveColor }}">
                            <i data-lucide="{{ $s['icon'] }}" class="w-3 h-3"></i>
                            <span>{{ $s['label'] }}</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] {{ $statusFilter === $s['status'] ? 'bg-black/15' : 'bg-black/20' }}">{{ $s['value'] }}</span>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- Filters bar --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-6">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome, código, endereço..." class="pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                <select wire:model.live="typeFilter">
                    <option value="">Todos os tipos</option>
                    @foreach(\App\Enums\PropertyType::options() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <select wire:model.live="perPage">
                    <option value="12">12 por página</option>
                    <option value="24">24 por página</option>
                    <option value="48">48 por página</option>
                </select>
            </div>
            <div class="md:col-span-1">
                @if($search || $typeFilter || $statusFilter)
                    <button wire:click="$set('search', ''); $set('typeFilter', ''); $set('statusFilter', '')" class="btn btn-secondary w-full h-full tooltip" data-tooltip="Limpar filtros">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Grid --}}
    <div wire:loading.class="opacity-50 pointer-events-none" wire:target="search, typeFilter, statusFilter" class="transition-opacity">
        @if($this->properties->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($this->properties as $property)
                    <div class="card overflow-hidden card-hover group">
                        <a href="{{ route('properties.show', $property) }}" class="block relative aspect-[4/3] overflow-hidden bg-[#16161A]">
                            @php $cover = $property->photos->where('is_cover', true)->first() ?? $property->photos->first(); @endphp
                            <img src="{{ $cover ? asset('storage/' . $cover->path) : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600' }}"
                                 alt="{{ $property->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/30"></div>
                            <div class="absolute top-3 right-3">
                                <x-ui.badge :variant="$property->status->color()">{{ $property->status->label() }}</x-ui.badge>
                            </div>
                            <div class="absolute top-3 left-3">
                                <span class="badge badge-neutral bg-black/60 backdrop-blur-md border-white/10 text-white">{{ $property->type->label() }}</span>
                            </div>
                            <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between gap-2">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-white/60 uppercase tracking-wider font-semibold mb-0.5">Aluguel</span>
                                    <span class="px-2.5 py-1 bg-black/70 backdrop-blur-md rounded-md text-white text-sm font-bold tracking-tight">
                                        R$ {{ number_format((float) $property->rent_amount, 0, ',', '.') }}
                                    </span>
                                </div>
                                @if($property->code)
                                    <span class="px-2 py-1 bg-black/60 backdrop-blur-md rounded text-white/70 text-[10px] font-mono uppercase tracking-wider">{{ $property->code }}</span>
                                @endif
                            </div>
                            {{-- Quick view overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-[#22C55E]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <div class="p-4">
                            <a href="{{ route('properties.show', $property) }}" class="block">
                                <h3 class="text-sm font-semibold text-white truncate group-hover:text-[#4ADE80] transition-colors">{{ $property->name }}</h3>
                            </a>
                            <p class="text-xs text-[#71717A] mt-1 truncate flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3 h-3"></i>
                                {{ $property->neighborhood }}, {{ $property->city }}
                            </p>

                            {{-- Features row --}}
                            <div class="flex items-center gap-2.5 mt-3 text-xs text-[#71717A]">
                                @if($property->bedrooms)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-[#1A1A1F] border border-[#1F1F23]">
                                        <i data-lucide="bed" class="w-3 h-3"></i> {{ $property->bedrooms }}
                                    </span>
                                @endif
                                @if($property->bathrooms)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-[#1A1A1F] border border-[#1F1F23]">
                                        <i data-lucide="bath" class="w-3 h-3"></i> {{ $property->bathrooms }}
                                    </span>
                                @endif
                                @if($property->parking_spaces)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-[#1A1A1F] border border-[#1F1F23]">
                                        <i data-lucide="car" class="w-3 h-3"></i> {{ $property->parking_spaces }}
                                    </span>
                                @endif
                                @if($property->area_total)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-[#1A1A1F] border border-[#1F1F23]">
                                        <i data-lucide="maximize" class="w-3 h-3"></i> {{ $property->area_total }}m²
                                    </span>
                                @endif
                            </div>

                            <div class="mt-3 pt-3 border-t border-[#1F1F23] flex items-center justify-between">
                                <div class="flex items-center gap-2 min-w-0">
                                    @if($property->owner)
                                        <div class="avatar avatar-sm bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] text-[10px]" title="{{ $property->owner->name }}">
                                            {{ mb_substr($property->owner->name, 0, 1) }}
                                        </div>
                                        <span class="text-xs text-[#71717A] truncate">{{ $property->owner->name }}</span>
                                    @else
                                        <span class="text-xs text-[#52525B]">Sem proprietário</span>
                                    @endif
                                </div>
                                <a href="{{ route('properties.show', $property) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#4ADE80] hover:text-[#22C55E] transition-colors flex-shrink-0 group/btn">
                                    Ver
                                    <i data-lucide="arrow-right" class="w-3 h-3 group-hover/btn:translate-x-0.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $this->properties->links() }}</div>
        @else
            <div class="card p-12">
                <x-ui.empty-state
                    icon="building-2"
                    title="Nenhum imóvel encontrado"
                    :description="$search || $typeFilter || $statusFilter ? 'Ajuste os filtros para ver mais resultados.' : 'Comece cadastrando seu primeiro imóvel.'"
                    >
                    <x-slot:action>
                        @if($search || $typeFilter || $statusFilter)
                            <button wire:click="$set('search', ''); $set('typeFilter', ''); $set('statusFilter', '')" class="btn btn-secondary">
                                <i data-lucide="x" class="w-4 h-4"></i> Limpar filtros
                            </button>
                        @else
                            <a href="{{ route('properties.create') }}" class="btn btn-primary">
                                <i data-lucide="plus" class="w-4 h-4"></i> Cadastrar imóvel
                            </a>
                        @endif
                    </x-slot:action>
                </x-ui.empty-state>
            </div>
        @endif
    </div>
</div>
