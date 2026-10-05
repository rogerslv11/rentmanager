<div>
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('properties.index') }}" class="text-xs text-[#71717A] hover:text-white inline-flex items-center gap-1.5 mb-3 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar para imóveis
        </a>
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">
                    <i data-lucide="building-2" class="w-3 h-3"></i> Carteira
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Novo imóvel</h1>
                <p class="text-sm text-[#71717A] mt-1">Cadastre um novo imóvel na sua carteira</p>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-5">
        {{-- Tabs --}}
        <div x-data="{ tab: 'basic' }" class="card overflow-hidden">
            <div class="border-b border-[#1F1F23]">
                <nav class="tabs-nav">
                    @foreach(['basic' => 'Básico', 'address' => 'Endereço', 'features' => 'Características', 'financial' => 'Financeiro', 'photos' => 'Fotos'] as $key => $label)
                        <button type="button" @click="tab = '{{ $key }}'"
                                :class="tab === '{{ $key }}' ? 'active' : ''"
                                class="tab-btn inline-flex items-center gap-2">
                            @php
                                $tabIcons = ['basic' => 'home', 'address' => 'map-pin', 'features' => 'sparkles', 'financial' => 'banknote', 'photos' => 'image'];
                            @endphp
                            <i data-lucide="{{ $tabIcons[$key] ?? 'circle' }}" class="w-3.5 h-3.5"></i>
                            {{ $label }}
                        </button>
                    @endforeach
                </nav>
            </div>

            <div x-show="tab === 'basic'" class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Nome" required :error="$errors->first('name')">
                        <input type="text" wire:model="name" placeholder="Ex: Apto 101, Edifício Aurora">
                    </x-ui.field>
                    <x-ui.field label="Código" optional :error="$errors->first('code')" hint="Se vazio, será gerado automaticamente">
                        <input type="text" wire:model="code" placeholder="IMV-001">
                    </x-ui.field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="Tipo" required>
                        <select wire:model="type">
                            @foreach(\App\Enums\PropertyType::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Status" required>
                        <select wire:model="status">
                            @foreach(\App\Enums\PropertyStatus::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                    <x-ui.field label="Proprietário">
                        <select wire:model="owner_id">
                            <option value="">Selecione...</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                            @endforeach
                        </select>
                    </x-ui.field>
                </div>

                <x-ui.field label="Descrição">
                    <textarea wire:model="description" rows="4" placeholder="Descreva o imóvel, diferenciais, vizinhos..."></textarea>
                </x-ui.field>
            </div>

            <div x-show="tab === 'address'" class="p-6 space-y-5" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.field label="CEP" required>
                        <input type="text" wire:model="zip_code" placeholder="00000-000" x-mask="99999-999">
                    </x-ui.field>
                    <div class="md:col-span-2">
                        <x-ui.field label="Endereço" required>
                            <input type="text" wire:model="address" placeholder="Rua, avenida...">
                        </x-ui.field>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <x-ui.field label="Número">
                        <input type="text" wire:model="address_number">
                    </x-ui.field>
                    <div class="md:col-span-2">
                        <x-ui.field label="Complemento">
                            <input type="text" wire:model="address_complement" placeholder="Apto, bloco, sala...">
                        </x-ui.field>
                    </div>
                    <x-ui.field label="Bairro" required>
                        <input type="text" wire:model="neighborhood">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <x-ui.field label="Cidade" required>
                            <input type="text" wire:model="city">
                        </x-ui.field>
                    </div>
                    <x-ui.field label="Estado" required>
                        <input type="text" wire:model="state" maxlength="2" placeholder="SP" class="uppercase">
                    </x-ui.field>
                </div>
            </div>

            <div x-show="tab === 'features'" class="p-6 space-y-5" x-cloak>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <x-ui.field label="Área total" hint="m²">
                        <input type="number" wire:model="area_total" step="0.01" min="0">
                    </x-ui.field>
                    <x-ui.field label="Área construída" hint="m²">
                        <input type="number" wire:model="area_built" step="0.01" min="0">
                    </x-ui.field>
                    <x-ui.field label="Andar">
                        <input type="number" wire:model="floor" min="0">
                    </x-ui.field>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <x-ui.field label="Quartos">
                        <input type="number" wire:model="bedrooms" min="0">
                    </x-ui.field>
                    <x-ui.field label="Banheiros">
                        <input type="number" wire:model="bathrooms" min="0">
                    </x-ui.field>
                    <x-ui.field label="Vagas">
                        <input type="number" wire:model="parking_spaces" min="0">
                    </x-ui.field>
                </div>
                <div class="pt-4 border-t border-[#1F1F23] space-y-2">
                    <label class="flex items-center gap-3 p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23] hover:border-[#27272A] cursor-pointer transition-colors">
                        <input type="checkbox" wire:model="is_furnished" class="rounded border-[#27272A] bg-[#0A0A0C] text-[#22C55E] focus:ring-[#22C55E] focus:ring-offset-0 w-4 h-4">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-white">Mobiliado</div>
                            <div class="text-xs text-[#71717A]">Imóvel contém mobília</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23] hover:border-[#27272A] cursor-pointer transition-colors">
                        <input type="checkbox" wire:model="pets_allowed" class="rounded border-[#27272A] bg-[#0A0A0C] text-[#22C55E] focus:ring-[#22C55E] focus:ring-offset-0 w-4 h-4">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-white">Aceita pets</div>
                            <div class="text-xs text-[#71717A]">Permite animais de estimação</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23] hover:border-[#27272A] cursor-pointer transition-colors">
                        <input type="checkbox" wire:model="is_published" class="rounded border-[#27272A] bg-[#0A0A0C] text-[#22C55E] focus:ring-[#22C55E] focus:ring-offset-0 w-4 h-4">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-white">Publicar no portal público</div>
                            <div class="text-xs text-[#71717A]">Disponibiliza página pública do imóvel</div>
                        </div>
                    </label>
                </div>
            </div>

            <div x-show="tab === 'financial'" class="p-6 space-y-5" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field label="Valor do aluguel" required>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="rent_amount" step="0.01" min="0" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Condomínio" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="condo_fee" step="0.01" min="0" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="IPTU mensal" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="property_tax" step="0.01" min="0" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Seguro" optional>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="insurance_amount" step="0.01" min="0" class="pl-10">
                        </div>
                    </x-ui.field>
                </div>
            </div>

            <div x-show="tab === 'photos'" class="p-6 space-y-5" x-cloak>
                <div>
                    <label class="block text-xs font-medium text-[#A1A1AA] uppercase tracking-wider mb-2">Fotos do imóvel</label>
                    <div class="border-2 border-dashed border-[#1F1F23] rounded-xl p-10 text-center hover:border-[#22C55E] hover:bg-[rgba(34,197,94,0.02)] transition-all cursor-pointer"
                         x-on:click="$refs.fileInput.click()"
                         x-on:dragover.prevent="$el.classList.add('border-[#22C55E]', 'bg-[rgba(34,197,94,0.04)]')"
                         x-on:dragleave="$el.classList.remove('border-[#22C55E]', 'bg-[rgba(34,197,94,0.04)]')"
                         x-on:drop.prevent="
                            $el.classList.remove('border-[#22C55E]', 'bg-[rgba(34,197,94,0.04)]');
                            $refs.fileInput.files = $event.dataTransfer.files;
                            $refs.fileInput.dispatchEvent(new Event('change'));
                         ">
                        <input type="file" x-ref="fileInput" wire:model="photos" multiple accept="image/*" class="hidden">
                        <div class="icon-box icon-box-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] mx-auto mb-3">
                            <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                        </div>
                        <p class="text-sm font-medium text-white">Clique ou arraste fotos aqui</p>
                        <p class="text-xs text-[#71717A] mt-1">PNG, JPG até 5MB cada · A primeira será a capa</p>
                    </div>
                </div>

                @if($photos)
                    <div class="photo-grid">
                        @foreach($photos as $index => $photo)
                            <div class="photo-tile hover-lift relative">
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                @if($index === 0)
                                    <div class="absolute top-2 left-2">
                                        <span class="badge badge-success backdrop-blur shadow-lg">Capa</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-3">
            <div class="text-xs text-[#71717A]">
                <i data-lucide="info" class="w-3.5 h-3.5 inline -mt-0.5"></i>
                Todos os campos marcados com * são obrigatórios
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('properties.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary shadow-lg shadow-[#22C55E]/10" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i> Criar imóvel
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <span class="spinner"></span> Salvando...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
