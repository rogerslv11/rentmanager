<div>
    <div class="mb-6">
        <a href="{{ route('tenants.index') }}" class="text-xs text-[#71717A] hover:text-white inline-flex items-center gap-1.5 mb-3 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar
        </a>
        <div>
            <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">
                <i data-lucide="user-round" class="w-3 h-3"></i> Carteira
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Novo inquilino</h1>
            <p class="text-sm text-[#71717A] mt-1">Cadastre um novo locatário na sua base</p>
        </div>
    </div>

    <form wire:submit="save" class="space-y-5">
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Dados pessoais</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Nome completo" required>
                        <input type="text" wire:model="name">
                    </x-ui.field>
                    <x-ui.field label="CPF">
                        <input type="text" wire:model="tax_id">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Email">
                        <input type="email" wire:model="email">
                    </x-ui.field>
                    <x-ui.field label="Telefone">
                        <input type="text" wire:model="phone">
                    </x-ui.field>
                    <x-ui.field label="Celular">
                        <input type="text" wire:model="mobile">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <x-ui.field label="Data de nascimento">
                        <input type="date" wire:model="birth_date">
                    </x-ui.field>
                    <x-ui.field label="Nacionalidade">
                        <input type="text" wire:model="nationality">
                    </x-ui.field>
                    <x-ui.field label="Estado civil">
                        <select wire:model="marital_status">
                            <option value="">—</option>
                            <option>Solteiro(a)</option>
                            <option>Casado(a)</option>
                            <option>Divorciado(a)</option>
                            <option>Viúvo(a)</option>
                            <option>União Estável</option>
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Profissão">
                        <input type="text" wire:model="profession">
                    </x-ui.field>
                </div>
                <x-ui.field label="Renda mensal">
                    <div class="relative max-w-md">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                        <input type="number" wire:model="monthly_income" step="0.01" class="pl-10">
                    </div>
                </x-ui.field>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#A855F7] to-[#7E22CE] text-white">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Endereço</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <x-ui.field label="CEP">
                        <input type="text" wire:model="zip_code" x-mask="99999-999">
                    </x-ui.field>
                    <div class="md:col-span-3">
                        <x-ui.field label="Endereço">
                            <input type="text" wire:model="address">
                        </x-ui.field>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03]">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Contato de emergência</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Nome">
                        <input type="text" wire:model="emergency_contact_name">
                    </x-ui.field>
                    <x-ui.field label="Telefone">
                        <input type="text" wire:model="emergency_contact_phone">
                    </x-ui.field>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23] flex items-center gap-3">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                    <i data-lucide="key" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-semibold text-white">Acesso ao portal</h3>
            </div>
            <div class="p-6 space-y-4">
                <label class="flex items-center gap-3 p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23] cursor-pointer hover:border-[#27272A] transition-colors">
                    <input type="checkbox" wire:model="create_portal_access" class="rounded border-[#27272A] bg-[#0A0A0C] text-[#22C55E] focus:ring-[#22C55E] focus:ring-offset-0 w-4 h-4">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-white">Criar acesso ao portal do inquilino</div>
                        <div class="text-xs text-[#71717A]">Permite ao inquilino acessar a plataforma para ver cobranças e contratos</div>
                    </div>
                </label>
                <x-ui.field label="Senha inicial do portal" optional :hint="(!$create_portal_access || !$email) ? 'Requer email e acesso ao portal ativo' : 'O inquilino poderá alterar após o primeiro login'">
                    <input type="text" wire:model="password" :disabled="!$create_portal_access || !$email">
                </x-ui.field>
            </div>
        </div>

        <div class="card p-6">
            <x-ui.field label="Observações">
                <textarea wire:model="notes" rows="3"></textarea>
            </x-ui.field>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Cancelar</a>
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
