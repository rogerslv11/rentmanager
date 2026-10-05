<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    {{-- Header --}}
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs text-[#71717A] hover:text-white mb-6 transition-colors">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar
    </a>

    {{-- Cover --}}
    @php $cover = $property->photos->where('is_cover', true)->first() ?? $property->photos->first(); @endphp
    <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-[#16161A] mb-8 border border-[#1F1F23] relative group">
        <img src="{{ $cover ? asset('storage/' . $cover->path) : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1200' }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="mb-6">
                <x-ui.badge variant="success">{{ $property->status->label() }}</x-ui.badge>
                <h1 class="text-3xl sm:text-4xl font-bold text-white mt-3 tracking-tight">{{ $property->name }}</h1>
                <p class="text-sm text-[#A1A1AA] mt-2 flex items-center gap-1.5">
                    <i data-lucide="map-pin" class="w-4 h-4 text-[#52525B]"></i> {{ $property->fullAddress() }}
                </p>
            </div>

            <div class="card overflow-hidden mb-6">
                <div class="px-5 py-3 border-b border-[#1F1F23]">
                    <h2 class="text-sm font-semibold text-white">Características</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Tipo</p>
                            <p class="text-sm text-white mt-1">{{ $property->type->label() }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Área</p>
                            <p class="text-sm text-white mt-1">{{ $property->area_total }}m²</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Quartos</p>
                            <p class="text-sm text-white mt-1">{{ $property->bedrooms }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Banheiros</p>
                            <p class="text-sm text-white mt-1">{{ $property->bathrooms }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Vagas</p>
                            <p class="text-sm text-white mt-1">{{ $property->parking_spaces }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Mobiliado</p>
                            <p class="text-sm text-white mt-1">{{ $property->is_furnished ? 'Sim' : 'Não' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Pets</p>
                            <p class="text-sm text-white mt-1">{{ $property->pets_allowed ? 'Permitido' : 'Não permitido' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">IPTU</p>
                            <p class="text-sm text-white mt-1">R$ {{ number_format((float) $property->property_tax, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($property->features)
                <div class="card overflow-hidden mb-6">
                    <div class="px-5 py-3 border-b border-[#1F1F23]">
                        <h2 class="text-sm font-semibold text-white">Comodidades</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-2">
                            @foreach($property->features as $f)
                                <span class="px-3 py-1.5 bg-[rgba(34,197,94,0.08)] border border-[rgba(34,197,94,0.18)] text-[#4ADE80] rounded-full text-xs font-medium">{{ $f }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="card overflow-hidden">
                <div class="px-5 py-3 border-b border-[#1F1F23]">
                    <h2 class="text-sm font-semibold text-white">Descrição</h2>
                </div>
                <div class="p-5">
                    <p class="text-sm text-[#A1A1AA] leading-relaxed">{{ $property->description ?? 'Sem descrição.' }}</p>
                </div>
            </div>
        </div>

        {{-- Sidebar: Price + Contact --}}
        <div class="lg:col-span-1">
            <div class="card overflow-hidden sticky top-20">
                <div class="p-6 bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-transparent border-b border-[#1F1F23]">
                    <p class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Aluguel mensal</p>
                    <p class="text-3xl font-bold text-[#4ADE80] mt-2 tracking-tight">R$ {{ number_format((float) $property->rent_amount, 2, ',', '.') }}</p>
                    @if($property->condo_fee)
                        <p class="text-xs text-[#71717A] mt-1">+ Condomínio R$ {{ number_format((float) $property->condo_fee, 0, ',', '.') }}</p>
                    @endif
                </div>

                <div class="p-6">
                    @if($sent)
                        <div class="bg-[rgba(34,197,94,0.06)] border border-[rgba(34,197,94,0.18)] rounded-xl p-5 text-center">
                            <div class="icon-box icon-box-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] mx-auto mb-3 shadow-lg shadow-[#22C55E]/20">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </div>
                            <div class="text-sm font-semibold text-[#4ADE80]">Mensagem enviada!</div>
                            <div class="text-xs text-[#71717A] mt-1">Entraremos em contato em breve.</div>
                        </div>
                    @else
                        <form wire:submit="send" class="space-y-3">
                            <h3 class="text-sm font-semibold text-white">Tenho interesse</h3>
                            <x-ui.field label="Nome">
                                <input type="text" wire:model="name" placeholder="Seu nome" required>
                            </x-ui.field>
                            <x-ui.field label="Email">
                                <input type="email" wire:model="email" placeholder="seu@email.com" required>
                            </x-ui.field>
                            <x-ui.field label="Telefone" optional>
                                <input type="text" wire:model="phone" placeholder="(11) 99999-9999">
                            </x-ui.field>
                            <x-ui.field label="Mensagem" optional>
                                <textarea wire:model="message" rows="3" placeholder="Olá, tenho interesse neste imóvel..."></textarea>
                            </x-ui.field>
                            <button type="submit" class="btn btn-primary w-full shadow-lg shadow-[#22C55E]/10">
                                <i data-lucide="send" class="w-4 h-4"></i> Enviar mensagem
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
