<div>
    <div class="mb-6">
        <a href="{{ route('properties.show', $property) }}" class="text-xs text-[#71717A] hover:text-white inline-flex items-center gap-1.5 mb-3 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar
        </a>
        <div>
            <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">
                <i data-lucide="edit-2" class="w-3 h-3"></i> Editando
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Editar imóvel</h1>
            <p class="text-sm text-[#71717A] mt-1">{{ $property->name }}</p>
        </div>
    </div>

    <form wire:submit="save" class="space-y-5">
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1F1F23]">
                <h3 class="text-sm font-semibold text-white">Dados do imóvel</h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Nome" required>
                        <input type="text" wire:model="data.name">
                    </x-ui.field>
                    <x-ui.field label="Código">
                        <input type="text" wire:model="data.code">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Tipo">
                        <select wire:model="data.type">
                            @foreach(\App\Enums\PropertyType::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Status">
                        <select wire:model="data.status">
                            @foreach(\App\Enums\PropertyStatus::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Proprietário">
                        <select wire:model="data.owner_id">
                            <option value="">Selecione...</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <x-ui.field label="Quartos">
                        <input type="number" wire:model="data.bedrooms" min="0">
                    </x-ui.field>
                    <x-ui.field label="Banheiros">
                        <input type="number" wire:model="data.bathrooms" min="0">
                    </x-ui.field>
                    <x-ui.field label="Vagas">
                        <input type="number" wire:model="data.parking_spaces" min="0">
                    </x-ui.field>
                    <x-ui.field label="Área" hint="m²">
                        <input type="number" wire:model="data.area_total" step="0.01">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-4 border-t border-[#1F1F23]">
                    <x-ui.field label="Aluguel" required>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="data.rent_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Condomínio">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="data.condo_fee" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="IPTU">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="data.property_tax" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Seguro">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="data.insurance_amount" step="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                </div>
                <x-ui.field label="Descrição">
                    <textarea wire:model="data.description" rows="3"></textarea>
                </x-ui.field>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('properties.show', $property) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i> Salvar alterações
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <span class="spinner"></span> Salvando...
                </span>
            </button>
        </div>
    </form>
</div>
