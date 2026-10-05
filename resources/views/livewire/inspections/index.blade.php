<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(59,130,246,0.05)] via-transparent to-[rgba(168,85,247,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#3B82F6] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="clipboard-check" class="w-3 h-3"></i>
                        Operações
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Vistorias</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Entradas, saídas e vistorias periódicas</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-secondary">
                        <i data-lucide="calendar" class="w-4 h-4"></i> Calendário
                    </button>
                    <button wire:click="$set('showForm', true)" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                        <i data-lucide="plus" class="w-4 h-4"></i> Nova vistoria
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="clipboard-check" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">vistorias realizadas</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(245,158,11,0.06)] to-[rgba(245,158,11,0.01)] border border-[rgba(245,158,11,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#FBBF24] uppercase tracking-wider font-semibold">Agendadas</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="calendar-clock" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#FBBF24] tracking-tight">{{ $this->stats['scheduled'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">pendentes</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Concluídas</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['completed'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">finalizadas</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(168,85,247,0.06)] to-[rgba(168,85,247,0.01)] border border-[rgba(168,85,247,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#C084FC] uppercase tracking-wider font-semibold">Próximos 30 dias</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#C084FC] tracking-tight">{{ $this->stats['upcoming'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">agendadas</div>
                </div>
            </div>

            @if(count($this->typeBreakdown) > 0)
                <div class="flex items-center gap-2 flex-wrap mt-5">
                    <button wire:click="$set('typeFilter', '')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                        {{ $typeFilter === '' ? 'bg-white text-[#09090B] border-white' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                        <span>Todos tipos</span>
                    </button>
                    @foreach($this->typeBreakdown as $t)
                        @php $isActive = $typeFilter === $t['type']; @endphp
                        <button wire:click="$set('typeFilter', '{{ $t['type'] }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all
                            {{ $isActive ? 'bg-[#22C55E] text-[#052E16] border-[#22C55E]' : 'bg-[#0F0F12] text-[#A1A1AA] border-[#1F1F23] hover:border-[#27272A] hover:text-white' }}">
                            <span>{{ $t['label'] }}</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] {{ $isActive ? 'bg-black/15' : 'bg-black/20' }}">{{ $t['value'] }}</span>
                        </button>
                    @endforeach
                </div>
            @endif
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
                @if($search || $typeFilter)
                    <button wire:click="$set('search', ''); $set('typeFilter', '')" class="btn btn-secondary w-full">
                        <i data-lucide="x" class="w-4 h-4"></i> Limpar filtros
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($this->inspections->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Imóvel</th>
                        <th>Tipo</th>
                        <th>Título</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->inspections as $i)
                        <tr>
                            <td class="font-medium text-white">{{ $i->property->name }}</td>
                            <td><x-ui.badge variant="info">{{ $i->type?->label() }}</x-ui.badge></td>
                            <td class="text-[#A1A1AA]">{{ $i->title ?? '—' }}</td>
                            <td>
                                <div class="text-xs text-white">{{ $i->scheduled_for->format('d/m/Y') }}</div>
                                <div class="text-[10px] text-[#71717A] mt-0.5">{{ $i->scheduled_for->diffForHumans() }}</div>
                            </td>
                            <td>
                                <x-ui.badge :variant="$i->status === 'completed' ? 'success' : 'warning'">
                                    <i data-lucide="{{ $i->status === 'completed' ? 'check-circle-2' : 'clock' }}" class="w-3 h-3"></i>
                                    {{ $i->status === 'completed' ? 'Concluída' : 'Agendada' }}
                                </x-ui.badge>
                            </td>
                            <td class="text-right">
                                <button class="text-xs text-[#4ADE80] hover:text-[#22C55E] font-medium inline-flex items-center gap-1 transition-colors">
                                    <i data-lucide="eye" class="w-3 h-3"></i> Detalhes
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->inspections->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="clipboard-check" :title="$search || $typeFilter ? 'Nenhum resultado' : 'Nenhuma vistoria'" :description="$search || $typeFilter ? 'Ajuste os filtros para ver mais resultados.' : 'Agende a primeira vistoria.'" />
        </div>
    @endif

    @if($showForm)
        <x-ui.modal title="Nova vistoria" :show="true">
            <form wire:submit="save" class="space-y-4">
                <x-ui.field label="Imóvel" required>
                    <select wire:model="property_id">
                        <option value="">Selecione...</option>
                        @foreach($properties as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                    </select>
                </x-ui.field>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="Tipo" required>
                        <select wire:model="type">
                            @foreach(\App\Enums\InspectionType::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Data" required>
                        <input type="date" wire:model="scheduled_for">
                    </x-ui.field>
                </div>
                <x-ui.field label="Título" required>
                    <input type="text" wire:model="title" placeholder="Ex: Vistoria de entrada">
                </x-ui.field>
                <x-ui.field label="Observações">
                    <textarea wire:model="notes" rows="3"></textarea>
                </x-ui.field>
            </form>
            <x-slot:footer>
                <button type="button" wire:click="$set('showForm', false)" class="btn btn-secondary">Cancelar</button>
                <button type="button" wire:click="save" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i> Agendar
                </button>
            </x-slot:footer>
        </x-ui.modal>
    @endif
</div>
