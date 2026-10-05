<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(244,63,94,0.05)] via-transparent to-[rgba(168,85,247,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#F43F5E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="trending-down" class="w-3 h-3"></i>
                        Financeiro
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Despesas</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Controle de despesas e custos operacionais</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-secondary">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar
                    </button>
                    <button wire:click="$set('showForm', true)" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                        <i data-lucide="plus" class="w-4 h-4"></i> Nova despesa
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Este mês</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F43F5E] to-[#BE123C] flex items-center justify-center shadow-lg shadow-[#F43F5E]/20">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['total_month'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['count_month'] }} {{ $this->stats['count_month'] == 1 ? 'lançamento' : 'lançamentos' }}</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Mês anterior</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="calendar-clock" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['total_last_month'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">comparação</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Acumulado no ano</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="trending-up" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['total_year'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">desde janeiro</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Ticket médio</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="calculator" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format((float) $this->stats['avg_month'], 2, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">por despesa</div>
                </div>
            </div>

            @if(count($this->categoryBreakdown) > 0)
                <div class="mt-5 pt-5 border-t border-[#1F1F23]">
                    <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-3">Distribuição por categoria (este mês)</div>
                    @php
                        $maxCat = collect($this->categoryBreakdown)->max('amount') ?: 1;
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($this->categoryBreakdown as $c)
                            @php
                                $percent = ($c['amount'] / $maxCat) * 100;
                            @endphp
                            <div class="flex items-center gap-3 p-2.5 rounded-lg bg-[#0F0F12] border border-[#1F1F23]">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-medium text-white truncate">{{ $c['label'] }}</span>
                                        <span class="text-xs font-semibold text-[#A1A1AA] ml-2 flex-shrink-0">R$ {{ number_format($c['amount'], 0, ',', '.') }}</span>
                                    </div>
                                    <div class="h-1.5 bg-[#1A1A1F] rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-[#F43F5E] to-[#A855F7] rounded-full transition-all" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-6">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar..." class="pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                <select wire:model.live="categoryFilter">
                    <option value="">Todas categorias</option>
                    @foreach(\App\Enums\ExpenseCategory::options() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3">
                @if($search || $categoryFilter)
                    <button wire:click="$set('search', ''); $set('categoryFilter', '')" class="btn btn-secondary w-full">
                        <i data-lucide="x" class="w-4 h-4"></i> Limpar filtros
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($this->expenses->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Imóvel</th>
                        <th class="text-right">Valor</th>
                        <th>Fornecedor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->expenses as $e)
                        <tr>
                            <td class="text-xs">
                                <div class="text-white">{{ $e->expense_date->format('d/m/Y') }}</div>
                                <div class="text-[10px] text-[#71717A] mt-0.5">{{ $e->expense_date->diffForHumans() }}</div>
                            </td>
                            <td class="font-medium text-white">{{ $e->description }}</td>
                            <td>
                                <span class="badge badge-neutral">{{ $e->category?->label() }}</span>
                            </td>
                            <td>
                                @if($e->property)
                                    <a href="{{ route('properties.show', $e->property) }}" class="text-[#A1A1AA] hover:text-white text-sm transition-colors inline-flex items-center gap-1.5">
                                        <i data-lucide="building-2" class="w-3 h-3 text-[#71717A]"></i>
                                        {{ $e->property->name }}
                                    </a>
                                @else
                                    <span class="text-[#52525B]">—</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <span class="font-bold text-[#FB7185]">R$ {{ number_format((float) $e->amount, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-xs text-[#A1A1AA]">{{ $e->vendor_name ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->expenses->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="trending-down" :title="$search || $categoryFilter ? 'Nenhuma despesa encontrada' : 'Nenhuma despesa'" :description="$search || $categoryFilter ? 'Ajuste os filtros para ver mais resultados.' : 'Cadastre a primeira despesa para começar.'" />
        </div>
    @endif

    @if($showForm)
        <x-ui.modal title="Nova despesa" :show="true">
            <form wire:submit="save" class="space-y-4">
                <x-ui.field label="Descrição" required>
                    <input type="text" wire:model="description" placeholder="Ex: Reparo de encanamento">
                </x-ui.field>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="Categoria" required>
                        <select wire:model="category">
                            @foreach(\App\Enums\ExpenseCategory::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Data" required>
                        <input type="date" wire:model="expense_date">
                    </x-ui.field>
                </div>
                <x-ui.field label="Valor" required>
                    <div class="relative max-w-xs">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                        <input type="number" wire:model="amount" step="0.01" min="0" class="pl-10">
                    </div>
                </x-ui.field>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Imóvel" optional>
                        <select wire:model="property_id">
                            <option value="">—</option>
                            @foreach($properties as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Fornecedor" optional>
                        <input type="text" wire:model="vendor_name">
                    </x-ui.field>
                </div>
            </form>
            <x-slot:footer>
                <button type="button" wire:click="$set('showForm', false)" class="btn btn-secondary">Cancelar</button>
                <button type="button" wire:click="save" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i> Salvar
                </button>
            </x-slot:footer>
        </x-ui.modal>
    @endif
</div>
