<div>
    <div class="mb-6">
        <a href="{{ route('owners.index') }}" class="text-xs text-[#71717A] hover:text-white inline-flex items-center gap-1.5 mb-3 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar
        </a>
        <div>
            <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">
                <i data-lucide="users-round" class="w-3 h-3"></i> Carteira
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Novo proprietário</h1>
            <p class="text-sm text-[#71717A] mt-1">Cadastre um novo proprietário na sua base</p>
        </div>
    </div>

    <form wire:submit="save" class="space-y-5">
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Dados pessoais</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Nome completo" required :error="$errors->first('name')">
                        <input type="text" wire:model="name">
                    </x-ui.field>
                    <x-ui.field label="CPF/CNPJ" :error="$errors->first('tax_id')">
                        <input type="text" wire:model="tax_id">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Email" :error="$errors->first('email')">
                        <input type="email" wire:model="email">
                    </x-ui.field>
                    <x-ui.field label="Telefone">
                        <input type="text" wire:model="phone">
                    </x-ui.field>
                    <x-ui.field label="Celular">
                        <input type="text" wire:model="mobile">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Endereço">
                        <input type="text" wire:model="address">
                    </x-ui.field>
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
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white">
                    <i data-lucide="banknote" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Dados bancários</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <x-ui.field label="Banco">
                        <input type="text" wire:model="bank_name">
                    </x-ui.field>
                    <x-ui.field label="Agência">
                        <input type="text" wire:model="bank_agency">
                    </x-ui.field>
                    <x-ui.field label="Conta">
                        <input type="text" wire:model="bank_account">
                    </x-ui.field>
                    <x-ui.field label="Tipo">
                        <select wire:model="bank_account_type">
                            <option value="">—</option>
                            <option value="Corrente">Corrente</option>
                            <option value="Poupança">Poupança</option>
                        </select>
                    </x-ui.field>
                </div>
                <x-ui.field label="Chave PIX" optional hint="CPF, CNPJ, email, telefone ou chave aleatória">
                    <input type="text" wire:model="pix_key" placeholder="Ex: 11999998888">
                </x-ui.field>
            </div>
        </div>

        <div class="card p-6">
            <x-ui.field label="Observações">
                <textarea wire:model="notes" rows="3" placeholder="Anotações sobre o proprietário..."></textarea>
            </x-ui.field>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('owners.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i> Salvar
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <span class="spinner"></span> Salvando...
                </span>
            </button>
        </div>
    </form>
</div>
