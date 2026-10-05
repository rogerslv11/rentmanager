<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(245,158,11,0.05)] via-transparent to-[rgba(34,197,94,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#F59E0B] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="hard-hat" class="w-3 h-3"></i>
                        Operações
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Fornecedores</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Prestadores de serviços cadastrados</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-secondary">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar
                    </button>
                    <button wire:click="$set('showForm', true)" class="btn btn-primary shadow-lg shadow-[#22C55E]/20 hover:shadow-[#22C55E]/40">
                        <i data-lucide="plus" class="w-4 h-4"></i> Novo fornecedor
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F59E0B] to-[#B45309] flex items-center justify-center shadow-lg shadow-[#F59E0B]/20">
                            <i data-lucide="hard-hat" class="w-3.5 h-3.5 text-[#451A03]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['total'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">fornecedores ativos</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Categorias</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="layers" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white tracking-tight">{{ $this->stats['categories'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">tipos de serviço</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Serviços prestados</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="wrench" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-[#4ADE80] tracking-tight">{{ $this->stats['total_jobs'] }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">total acumulado</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Valor/hora médio</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format((float) $this->stats['avg_rate'], 2, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">média geral</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-7">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome ou empresa..." class="pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                <select wire:model.live="categoryFilter">
                    <option value="">Todas categorias</option>
                    @foreach($categories as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                @if($search || $categoryFilter)
                    <button wire:click="$set('search', ''); $set('categoryFilter', '')" class="btn btn-secondary w-full">
                        <i data-lucide="x" class="w-4 h-4"></i> Limpar
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($this->vendors->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Fornecedor</th>
                        <th>Empresa</th>
                        <th>Categoria</th>
                        <th>Especialidade</th>
                        <th>Contato</th>
                        <th class="text-right">Valor/hora</th>
                        <th class="text-center">Serviços</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->vendors as $v)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-white text-xs flex-shrink-0">
                                        {{ $v->initials() }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-white">{{ $v->name }}</div>
                                        <div class="text-xs text-[#71717A] mt-0.5">{{ $v->phone ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-[#A1A1AA]">{{ $v->company_name ?? '—' }}</td>
                            <td>
                                <span class="badge badge-neutral">{{ $v->category }}</span>
                            </td>
                            <td class="text-[#A1A1AA]">{{ $v->specialty ?? '—' }}</td>
                            <td class="text-xs text-[#A1A1AA]">{{ $v->email ?? '—' }}</td>
                            <td class="text-right text-white font-medium">R$ {{ number_format((float) $v->hourly_rate, 2, ',', '.') }}</td>
                            <td class="text-center"><x-ui.badge variant="info">{{ $v->maintenance_requests_count }}</x-ui.badge></td>
                            <td class="text-right">
                                <button wire:click="delete({{ $v->id }})" wire:confirm="Excluir fornecedor?" class="inline-flex items-center gap-1 text-xs text-[#FB7185] hover:opacity-80 font-medium transition-opacity">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i> Excluir
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->vendors->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="hard-hat" :title="$search || $categoryFilter ? 'Nenhum resultado' : 'Nenhum fornecedor'" :description="$search || $categoryFilter ? 'Ajuste os filtros para ver mais resultados.' : 'Cadastre seu primeiro fornecedor.'">
                <x-slot:action>
                    @if($search || $categoryFilter)
                        <button wire:click="$set('search', ''); $set('categoryFilter', '')" class="btn btn-secondary">
                            <i data-lucide="x" class="w-4 h-4"></i> Limpar filtros
                        </button>
                    @else
                        <button wire:click="$set('showForm', true)" class="btn btn-primary">
                            <i data-lucide="plus" class="w-4 h-4"></i> Novo fornecedor
                        </button>
                    @endif
                </x-slot:action>
            </x-ui.empty-state>
        </div>
    @endif

    @if($showForm)
        <x-ui.modal title="Novo fornecedor" :show="true">
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="Nome" required><input type="text" wire:model="name"></x-ui.field>
                    <x-ui.field label="Empresa" optional><input type="text" wire:model="company_name"></x-ui.field>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="CPF/CNPJ" optional><input type="text" wire:model="tax_id"></x-ui.field>
                    <x-ui.field label="Telefone"><input type="text" wire:model="phone"></x-ui.field>
                </div>
                <x-ui.field label="Email" optional><input type="email" wire:model="email"></x-ui.field>
                <div class="grid grid-cols-3 gap-4">
                    <x-ui.field label="Categoria" required hint="Ex: Elétrica, Hidráulica..."><input type="text" wire:model="category"></x-ui.field>
                    <x-ui.field label="Especialidade" optional><input type="text" wire:model="specialty"></x-ui.field>
                    <x-ui.field label="Valor/hora" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="hourly_rate" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                </div>
                <x-ui.field label="Observações"><textarea wire:model="notes" rows="2"></textarea></x-ui.field>
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
