<div>
    <div class="mb-6">
        <a href="{{ route('maintenance.index') }}" class="text-xs text-[#71717A] hover:text-white inline-flex items-center gap-1.5 mb-3 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar
        </a>
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <x-ui.badge :variant="$maintenance->status->color()">{{ $maintenance->status->label() }}</x-ui.badge>
                    <x-ui.badge :variant="$maintenance->priority->color()">{{ $maintenance->priority->label() }}</x-ui.badge>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">{{ $maintenance->title }}</h1>
                <p class="text-sm text-[#71717A] mt-1">{{ $maintenance->property->name }} · {{ $maintenance->category?->label() }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 space-y-4">
            <div class="card overflow-hidden">
                <div class="px-5 py-3 border-b border-[#1F1F23]">
                    <h3 class="text-sm font-semibold text-white">Descrição</h3>
                </div>
                <div class="p-5">
                    <p class="text-sm text-[#A1A1AA] leading-relaxed">{{ $maintenance->description }}</p>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="px-5 py-3 border-b border-[#1F1F23]">
                    <h3 class="text-sm font-semibold text-white">Mudar status</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                        @foreach(\App\Enums\MaintenanceStatus::cases() as $s)
                            <button wire:click="changeStatus('{{ $s->value }}')"
                                    class="px-3 py-2 rounded-lg text-xs font-medium transition-all {{ $maintenance->status === $s ? 'bg-gradient-to-br from-[#22C55E] to-[#16A34A] text-[#052E16] shadow-lg shadow-[#22C55E]/20' : 'bg-[#0A0A0C] border border-[#1F1F23] text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white' }}">
                                {{ $s->label() }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($maintenance->photos->count())
                <div class="card overflow-hidden">
                    <div class="px-5 py-3 border-b border-[#1F1F23]">
                        <h3 class="text-sm font-semibold text-white">Fotos</h3>
                    </div>
                    <div class="p-5">
                        <div class="photo-grid">
                            @foreach($maintenance->photos as $p)
                                <div class="photo-tile hover-lift">
                                    <img src="{{ asset('storage/' . $p->path) }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="card overflow-hidden">
                <div class="px-5 py-3 border-b border-[#1F1F23]">
                    <h3 class="text-sm font-semibold text-white">Detalhes</h3>
                </div>
                <div class="p-5">
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <dt class="text-[#71717A]">Inquilino</dt>
                            <dd class="text-white font-medium">{{ $maintenance->tenant?->name ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-[#71717A]">Fornecedor</dt>
                            <dd class="text-white font-medium">{{ $maintenance->vendor?->name ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-[#71717A]">Aberto em</dt>
                            <dd class="text-white font-medium">{{ $maintenance->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-[#71717A]">Concluído em</dt>
                            <dd class="text-white font-medium">{{ $maintenance->completed_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                        </div>
                        <div class="pt-3 border-t border-[#1F1F23] flex justify-between items-center">
                            <dt class="text-[#71717A]">Custo estimado</dt>
                            <dd class="text-white font-semibold">R$ {{ number_format((float) $maintenance->estimated_cost, 2, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-[#71717A]">Custo final</dt>
                            <dd class="text-[#4ADE80] font-semibold">R$ {{ number_format((float) $maintenance->final_cost, 2, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($maintenance->quotes->count())
                <div class="card overflow-hidden">
                    <div class="px-5 py-3 border-b border-[#1F1F23]">
                        <h3 class="text-sm font-semibold text-white">Orçamentos</h3>
                    </div>
                    <div class="p-5 space-y-2">
                        @foreach($maintenance->quotes as $q)
                            <div class="p-3 rounded-lg bg-[#0A0A0C] border border-[#1F1F23] hover:border-[#27272A] transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-medium text-white">{{ $q->vendor->name }}</div>
                                    <div class="text-sm text-[#4ADE80] font-semibold">R$ {{ number_format((float) $q->amount, 2, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
