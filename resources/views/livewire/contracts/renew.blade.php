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
            <p class="text-sm text-[#71717A] mt-1">{{ $contract->number }} · {{ $contract->property->name }}</p>
        </div>
    </div>

    <form wire:submit="renew" class="space-y-5">
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23]">
                <h3 class="text-sm font-semibold text-white">Dados da renovação</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Data início" required>
                        <input type="date" wire:model="start_date">
                    </x-ui.field>
                    <x-ui.field label="Data final" required>
                        <input type="date" wire:model="end_date">
                    </x-ui.field>
                    <x-ui.field label="Novo aluguel" required>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="rent_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Taxa administrativa" hint="% sobre o aluguel">
                        <div class="relative">
                            <input type="number" wire:model="admin_fee_percent" step="0.01" class="pr-8">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">%</span>
                        </div>
                    </x-ui.field>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('contracts.show', $contract) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Renovar contrato
            </button>
        </div>
    </form>
</div>
