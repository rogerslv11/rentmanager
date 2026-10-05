<div>
    <div class="mb-6">
        <a href="{{ route('contracts.index') }}" class="text-xs text-[#71717A] hover:text-white inline-flex items-center gap-1.5 mb-3 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar
        </a>
        <div>
            <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">
                <i data-lucide="file-plus" class="w-3 h-3"></i> Carteira
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Novo contrato</h1>
            <p class="text-sm text-[#71717A] mt-1">Crie um novo contrato de locação</p>
        </div>
    </div>

    <form wire:submit="save" class="space-y-5">
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="file-plus" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Vínculo</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Imóvel" required>
                        <select wire:model.live="property_id">
                            <option value="">Selecione...</option>
                            @foreach($properties as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} - {{ $p->code }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Inquilino" required>
                        <select wire:model="tenant_id">
                            <option value="">Selecione...</option>
                            @foreach($tenants as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Data início" required>
                        <input type="date" wire:model="start_date">
                    </x-ui.field>
                    <x-ui.field label="Data final" required>
                        <input type="date" wire:model="end_date">
                    </x-ui.field>
                    <x-ui.field label="Dia de vencimento" required>
                        <input type="number" wire:model="due_day" min="1" max="31">
                    </x-ui.field>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#4ADE80] to-[#22C55E] text-[#052E16]">
                    <i data-lucide="banknote" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Valores mensais</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <x-ui.field label="Aluguel" required>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="rent_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Condomínio" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="condo_fee" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="IPTU" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="property_tax" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Seguro" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="insurance_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-[#1F1F23]">
                    <x-ui.field label="Taxa administrativa" hint="% sobre o aluguel">
                        <div class="relative">
                            <input type="number" wire:model="admin_fee_percent" step="0.01" class="pr-8">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">%</span>
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Taxa fixa" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="admin_fee_fixed" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Desconto" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="discount_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Multa" hint="% por atraso">
                        <div class="relative">
                            <input type="number" wire:model="late_fee_percent" step="0.01" class="pr-8">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">%</span>
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Juros mensal" hint="% ao mês">
                        <div class="relative">
                            <input type="number" wire:model="interest_percent" step="0.01" class="pr-8">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">%</span>
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Caução" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="deposit_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui-field>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03]">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Reajuste e renovação</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Índice de reajuste">
                        <select wire:model="adjustment_index">
                            <option value="IGPM">IGPM</option>
                            <option value="IPCA">IPCA</option>
                            <option value="INPC">INPC</option>
                            <option value="fixo">Fixo</option>
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Periodicidade">
                        <select wire:model="adjustment_periodicity">
                            <option value="yearly">Anual</option>
                            <option value="biannual">Semestral</option>
                            <option value="monthly">Mensal</option>
                        </select>
                    </x-ui.field>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center gap-3 w-full p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23] cursor-pointer hover:border-[#27272A] transition-colors">
                            <input type="checkbox" wire:model="auto_renew" class="rounded border-[#27272A] bg-[#0A0A0C] text-[#22C55E] focus:ring-[#22C55E] focus:ring-offset-0 w-4 h-4">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-white">Auto-renovar</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <x-ui.field label="Observações">
                <textarea wire:model="notes" rows="3"></textarea>
            </x-ui.field>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i> Criar contrato
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <span class="spinner"></span> Criando...
                </span>
            </button>
        </div>
    </form>
</div>
