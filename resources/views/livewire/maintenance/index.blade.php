<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(245,158,11,0.06)] via-transparent to-[rgba(34,197,94,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#F59E0B] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="wrench" class="w-3 h-3"></i>
                        Operações
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Manutenção</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Solicitações e ordens de serviço</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="bg-[#0F0F12] border border-[#1F1F23] rounded-lg p-1 flex">
                        <button wire:click="$set('view', 'list')" class="px-2.5 py-1.5 rounded text-xs font-medium transition-colors {{ $view === 'list' ? 'bg-[#22C55E] text-[#052E16]' : 'text-[#A1A1AA] hover:text-white' }}" title="Lista">
                            <i data-lucide="list" class="w-3.5 h-3.5"></i>
                        </button>
                        <button wire:click="$set('view', 'kanban')" class="px-2.5 py-1.5 rounded text-xs font-medium transition-colors {{ $view === 'kanban' ? 'bg-[#22C55E] text-[#052E16]' : 'text-[#A1A1AA] hover:text-white' }}" title="Kanban">
                            <i data-lucide="kanban" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                    <button wire:click="$set('showForm', true)" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                        <i data-lucide="plus" class="w-4 h-4"></i> Nova solicitação
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#FBBF24] uppercase tracking-wider font-semibold">Em aberto</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="wrench" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#FBBF24] tracking-tight">{{ $this->stats['open'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">solicitações pendentes</div>
                </div>

                <div class="p-4 rounded-xl {{ $this->stats['urgent'] > 0 ? 'bg-gradient-to-br from-[rgba(244,63,94,0.06)] to-[rgba(244,63,94,0.01)] border border-[rgba(244,63,94,0.18)]' : 'bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] {{ $this->stats['urgent'] > 0 ? 'text-[#FB7185]' : 'text-[#71717A]' }} uppercase tracking-wider font-semibold">Urgentes</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F43F5E] to-[#BE123C] flex items-center justify-center shadow-lg shadow-[#F43F5E]/20">
                            <i data-lucide="zap" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold {{ $this->stats['urgent'] > 0 ? 'text-[#FB7185]' : 'text-white' }} tracking-tight">{{ $this->stats['urgent'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">requerem atenção</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Concluídas no mês</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['completed_month'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">em {{ now()->translatedFormat('F') }}</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Custo total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['total_cost'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">acumulado</div>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-wrap mt-5">
                <button wire:click="$set('statusFilter', '')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                    {{ $statusFilter === '' ? 'bg-white text-[#09090B] border-white' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                    <span>Todas</span>
                </button>
                @foreach($this->priorityBreakdown as $s)
                    @php
                        $isActive = $statusFilter === $s['status'];
                        $activeColor = match($s['color']) {
                            'gray' => 'bg-[#52525B] text-white border-[#52525B]',
                            'blue' => 'bg-[#3B82F6] text-white border-[#3B82F6]',
                            'purple' => 'bg-[#A855F7] text-white border-[#A855F7]',
                            'yellow' => 'bg-[#F59E0B] text-[#451A03] border-[#F59E0B]',
                            'green' => 'bg-[#22C55E] text-[#052E16] border-[#22C55E]',
                            'red' => 'bg-[#F43F5E] text-white border-[#F43F5E]',
                            default => 'bg-[#52525B] text-white border-[#52525B]',
                        };
                        $inactiveColor = match($s['color']) {
                            'gray' => 'bg-[#1F1F23] text-[#A1A1AA] border-[#27272A] hover:bg-[#27272A]',
                            'blue' => 'bg-[rgba(59,130,246,0.08)] text-[#60A5FA] border-[rgba(59,130,246,0.18)] hover:bg-[rgba(59,130,246,0.15)]',
                            'purple' => 'bg-[rgba(168,85,247,0.08)] text-[#C084FC] border-[rgba(168,85,247,0.18)] hover:bg-[rgba(168,85,247,0.15)]',
                            'yellow' => 'bg-[rgba(245,158,11,0.08)] text-[#FBBF24] border-[rgba(245,158,11,0.18)] hover:bg-[rgba(245,158,11,0.15)]',
                            'green' => 'bg-[rgba(34,197,94,0.08)] text-[#4ADE80] border-[rgba(34,197,94,0.18)] hover:bg-[rgba(34,197,94,0.15)]',
                            'red' => 'bg-[rgba(244,63,94,0.08)] text-[#FB7185] border-[rgba(244,63,94,0.18)] hover:bg-[rgba(244,63,94,0.15)]',
                            default => 'bg-[#1F1F23] text-[#A1A1AA] border-[#27272A]',
                        };
                    @endphp
                    <button wire:click="$set('statusFilter', '{{ $s['status'] }}')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                        {{ $isActive ? $activeColor : $inactiveColor }}">
                        <i data-lucide="{{ $s['icon'] }}" class="w-3 h-3"></i>
                        <span>{{ $s['label'] }}</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] {{ $isActive ? 'bg-black/15' : 'bg-black/20' }}">{{ $s['value'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-9">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por título ou imóvel..." class="pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                @if($search || $statusFilter)
                    <button wire:click="$set('search', ''); $set('statusFilter', '')" class="btn btn-secondary w-full">
                        <i data-lucide="x" class="w-4 h-4"></i> Limpar filtros
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($view === 'list')
        @if($this->requests->count())
            <div class="space-y-2">
                @foreach($this->requests as $r)
                    <a href="{{ route('maintenance.show', $r) }}" class="block card card-hover p-4 group">
                        <div class="flex items-center gap-4">
                            <div class="icon-box icon-box-md bg-[#1A1A1F] border border-[#27272A] text-[#A1A1AA] flex-shrink-0 group-hover:border-[#F59E0B]/30 group-hover:text-[#FBBF24] transition-colors">
                                <i data-lucide="{{ $r->category?->icon() ?? 'wrench' }}" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-sm font-semibold text-white truncate group-hover:text-[#4ADE80] transition-colors">{{ $r->title }}</h3>
                                    <x-ui.badge :variant="$r->priority->color()" size="sm">
                                        <i data-lucide="flag" class="w-3 h-3"></i> {{ $r->priority->label() }}
                                    </x-ui.badge>
                                </div>
                                <p class="text-xs text-[#71717A] truncate mt-1 flex items-center gap-1.5">
                                    <i data-lucide="building-2" class="w-3 h-3"></i>
                                    {{ $r->property->name }}
                                    <span class="text-[#3F3F46]">·</span>
                                    {{ $r->category?->label() }}
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <x-ui.badge :variant="$r->status->color()">{{ $r->status->label() }}</x-ui.badge>
                                <div class="text-xs text-[#71717A] mt-1.5 flex items-center gap-1 justify-end">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    {{ $r->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">{{ $this->requests->links() }}</div>
        @else
            <div class="card p-12">
                <x-ui.empty-state icon="wrench" title="Nenhuma solicitação" :description="$search || $statusFilter ? 'Ajuste os filtros para ver mais resultados.' : 'Crie sua primeira solicitação para começar.'" />
            </div>
        @endif
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 overflow-x-auto">
            @foreach($this->kanbanData as $status => $data)
                <div class="card overflow-hidden min-h-[400px]">
                    <div class="px-4 py-3 border-b border-[#1F1F23] flex items-center justify-between bg-gradient-to-r from-[#16161A] to-[#0F0F12]">
                        <div class="flex items-center gap-2">
                            <x-ui.badge :variant="$data['color']">{{ $data['label'] }}</x-ui.badge>
                            <span class="text-xs text-[#71717A] font-medium">{{ count($data['items']) }}</span>
                        </div>
                    </div>
                    <div class="p-3 space-y-2 min-h-[300px]">
                        @forelse($data['items'] as $r)
                            <a href="{{ route('maintenance.show', $r) }}" class="block p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23] hover:border-[#27272A] hover:bg-[#0F0F12] transition-all">
                                <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1.5">{{ $r->category?->label() }}</div>
                                <div class="text-sm font-medium text-white line-clamp-2">{{ $r->title }}</div>
                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-[#1F1F23]">
                                    <span class="text-xs text-[#71717A] truncate">{{ $r->property->name }}</span>
                                    <x-ui.badge :variant="$r->priority->color()" size="sm">{{ $r->priority->label() }}</x-ui.badge>
                                </div>
                            </a>
                        @empty
                            <div class="text-xs text-[#52525B] text-center py-8 flex flex-col items-center gap-1">
                                <i data-lucide="inbox" class="w-5 h-5 opacity-50"></i>
                                Vazio
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($showForm)
        <x-ui.modal title="Nova solicitação de manutenção" :show="true">
            <form wire:submit="save" class="space-y-4">
                <x-ui.field label="Imóvel" required>
                    <select wire:model="property_id">
                        <option value="">Selecione...</option>
                        @foreach($properties as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </x-ui.field>
                <x-ui.field label="Título" required>
                    <input type="text" wire:model="title" placeholder="Ex: Vazamento no banheiro">
                </x-ui.field>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="Categoria" required>
                        <select wire:model="category">
                            @foreach(\App\Enums\MaintenanceCategory::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Prioridade" required>
                        <select wire:model="priority">
                            @foreach(\App\Enums\MaintenancePriority::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                </div>
                <x-ui.field label="Fornecedor" optional>
                    <select wire:model="vendor_id">
                        <option value="">—</option>
                        @foreach($vendors as $v)
                            <option value="{{ $v->id }}">{{ $v->name }} - {{ $v->category }}</option>
                        @endforeach
                    </select>
                </x-ui.field>
                <x-ui.field label="Descrição" required>
                    <textarea wire:model="description" rows="3"></textarea>
                </x-ui.field>
            </form>
            <x-slot:footer>
                <button type="button" wire:click="$set('showForm', false)" class="btn btn-secondary">Cancelar</button>
                <button type="button" wire:click="save" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i> Criar solicitação
                </button>
            </x-slot:footer>
        </x-ui.modal>
    @endif
</div>
