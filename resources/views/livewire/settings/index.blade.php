<div>
    <div class="mb-6">
        <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">
            <i data-lucide="settings" class="w-3 h-3"></i> Conta
        </div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Configurações</h1>
        <p class="text-sm text-[#71717A] mt-1">Personalize sua organização</p>
    </div>

    <form wire:submit="save" class="space-y-5">
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="building" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Dados da organização</h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Nome fantasia" required>
                        <input type="text" wire:model="name">
                    </x-ui.field>
                    <x-ui.field label="Razão social" optional>
                        <input type="text" wire:model="legal_name">
                    </x-ui.field>
                    <x-ui.field label="CNPJ/CPF">
                        <input type="text" wire:model="tax_id">
                    </x-ui.field>
                    <x-ui.field label="Email">
                        <input type="email" wire:model="email">
                    </x-ui.field>
                    <x-ui.field label="Telefone">
                        <input type="text" wire:model="phone">
                    </x-ui.field>
                    <x-ui.field label="CEP">
                        <input type="text" wire:model="zip_code" x-mask="99999-999">
                    </x-ui.field>
                </div>
                <x-ui.field label="Endereço">
                    <input type="text" wire:model="address">
                </x-ui.field>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Cidade">
                        <input type="text" wire:model="city">
                    </x-ui.field>
                    <x-ui.field label="Estado">
                        <input type="text" wire:model="state" maxlength="2" class="uppercase">
                    </x-ui.field>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#4ADE80] to-[#22C55E] text-[#052E16]">
                    <i data-lucide="percent" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Taxa administrativa padrão</h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Percentual" hint="Aplicado sobre o aluguel">
                        <div class="relative">
                            <input type="number" wire:model="default_admin_fee_percent" step="0.01" class="pr-8">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">%</span>
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Taxa fixa" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="default_admin_fee_fixed" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <button type="submit" class="btn btn-primary shadow-lg shadow-[#22C55E]/10">
                <i data-lucide="check" class="w-4 h-4"></i> Salvar configurações
            </button>
        </div>
    </form>
</div>
