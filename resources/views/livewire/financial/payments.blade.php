<div>
    {{-- Hero header --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.06)] via-transparent to-[rgba(59,130,246,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        <div class="relative p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 text-[11px] text-[#71717A] uppercase tracking-wider font-semibold mb-2">
                        <i data-lucide="credit-card" class="w-3 h-3"></i>
                        Financeiro
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Pagamentos</h1>
                    <p class="text-sm text-[#71717A] mt-1.5">Histórico de todos os pagamentos recebidos</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-secondary">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="p-4 rounded-xl bg-gradient-to-br from-[rgba(34,197,94,0.06)] to-[rgba(34,197,94,0.01)] border border-[rgba(34,197,94,0.18)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#4ADE80] uppercase tracking-wider font-semibold">Recebido no mês</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/30">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">R$ {{ number_format($this->stats['month'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['count_month'] }} {{ $this->stats['count_month'] == 1 ? 'pagamento' : 'pagamentos' }}</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Total histórico</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] flex items-center justify-center shadow-lg shadow-[#3B82F6]/20">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['total'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">{{ $this->stats['count_total'] }} {{ $this->stats['count_total'] == 1 ? 'transação' : 'transações' }}</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Ticket médio</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#A855F7] to-[#7E22CE] flex items-center justify-center shadow-lg shadow-[#A855F7]/20">
                            <i data-lucide="calculator" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold text-white tracking-tight">R$ {{ number_format($this->stats['avg_ticket'], 2, ',', '.') }}</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">por transação</div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Taxa de cobrança</span>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#22C55E] to-[#15803D] flex items-center justify-center shadow-lg shadow-[#22C55E]/20">
                            <i data-lucide="percent" class="w-3.5 h-3.5 text-[#052E16]"></i>
                        </div>
                    </div>
                    @php
                        $totalExpected = (float) $this->stats['total'];
                        $totalPending = \App\Models\Charge::whereIn('status', ['pending', 'partially_paid', 'overdue'])->sum('total_amount');
                        $rate = $totalExpected + $totalPending > 0 ? round((float) $this->stats['total'] / ($totalExpected + $totalPending) * 100, 1) : 0;
                    @endphp
                    <div class="text-xl font-bold text-[#4ADE80] tracking-tight">{{ $rate }}%</div>
                    <div class="text-[11px] text-[#52525B] mt-0.5">eficiência</div>
                </div>
            </div>

            @if($this->methodBreakdown)
                <div class="mt-5 pt-5 border-t border-[#1F1F23]">
                    <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-3">Por método de pagamento</div>
                    <div class="flex items-center gap-2 flex-wrap">
                        @foreach($this->methodBreakdown as $m)
                            @php
                                $total = collect($this->methodBreakdown)->sum('amount');
                                $percent = $total > 0 ? round($m['amount'] / $total * 100, 1) : 0;
                            @endphp
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#0F0F12] border border-[#1F1F23]">
                                <span class="text-xs text-[#A1A1AA]">{{ $m['label'] }}</span>
                                <span class="text-xs font-semibold text-white">{{ $m['value'] }}</span>
                                <span class="text-[10px] text-[#71717A]">{{ $percent }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-9">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#52525B]"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Buscar por transação, inquilino..." class="pl-10">
                </div>
            </div>
            <div class="md:col-span-3">
                @if($search)
                    <button wire:click="$set('search', '')" class="btn btn-secondary w-full">
                        <i data-lucide="x" class="w-4 h-4"></i> Limpar busca
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($this->payments->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pago em</th>
                        <th>Inquilino</th>
                        <th>Imóvel</th>
                        <th>Método</th>
                        <th class="text-right">Valor</th>
                        <th>Transação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->payments as $p)
                        <tr>
                            <td>
                                <div class="text-white font-medium">{{ $p->paid_at->format('d/m/Y') }}</div>
                                <div class="text-[10px] text-[#71717A] mt-0.5">{{ $p->paid_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <a href="{{ route('tenants.show', $p->charge->tenant) }}" class="text-white hover:text-[#4ADE80] font-medium transition-colors">{{ $p->charge->tenant->name ?? '—' }}</a>
                            </td>
                            <td>
                                <a href="{{ route('properties.show', $p->charge->property) }}" class="text-[#A1A1AA] hover:text-white transition-colors inline-flex items-center gap-1.5">
                                    <i data-lucide="building-2" class="w-3 h-3 text-[#71717A]"></i>
                                    {{ $p->charge->property->name ?? '—' }}
                                </a>
                            </td>
                            <td>
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-medium bg-[#1F1F23] text-[#A1A1AA] border border-[#27272A]">
                                    <i data-lucide="{{ match($p->method?->value) { 'pix' => 'zap', 'cash' => 'banknote', 'transfer' => 'arrow-right-left', 'bank_slip' => 'file-text', 'credit_card' => 'credit-card', 'debit_card' => 'credit-card', default => 'circle' } }}" class="w-3 h-3"></i>
                                    {{ $p->method?->label() }}
                                </span>
                            </td>
                            <td class="text-right">
                                <span class="text-[#4ADE80] font-semibold">R$ {{ number_format((float) $p->amount, 2, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($p->transaction_id)
                                    <span class="font-mono text-[11px] text-[#A1A1AA]">{{ Str::limit($p->transaction_id, 18) }}</span>
                                @else
                                    <span class="text-[#52525B] text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $this->payments->links() }}</div>
    @else
        <div class="card p-12">
            <x-ui.empty-state icon="credit-card" :title="$search ? 'Nenhum resultado' : 'Nenhum pagamento registrado'" :description="$search ? 'Ajuste a busca para ver mais resultados.' : 'Os pagamentos aparecerão aqui conforme forem recebidos.'" />
        </div>
    @endif

    @if($showForm)
        <x-ui.modal title="Registrar pagamento" :show="true" name="payment-form">
            <form wire:submit="save" class="space-y-4">
                <div class="bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23] rounded-lg p-4">
                    <div class="text-[11px] text-[#71717A] uppercase tracking-wider font-semibold">Cobrança</div>
                    @php $ch = \App\Models\Charge::find($chargeId); @endphp
                    <div class="font-medium text-white mt-1">{{ $ch?->tenant?->name }} - {{ $ch?->property?->name }}</div>
                    <div class="text-sm text-[#4ADE80] mt-1">R$ {{ number_format((float) $ch?->remainingAmount(), 2, ',', '.') }} restante</div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.field label="Valor" required>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#52525B] font-medium">R$</span>
                            <input type="number" wire:model="amount" step="0.01" min="0.01" class="pl-10">
                        </div>
                    </x-ui.field>
                    <x-ui.field label="Data do pagamento" required>
                        <input type="date" wire:model="paid_at">
                    </x-ui.field>
                </div>
                <x-ui.field label="Método" required>
                    <select wire:model="method">
                        @foreach(\App\Enums\PaymentMethod::options() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </x-ui.field>
                <x-ui.field label="ID da transação" optional hint="Comprovante, ID PIX...">
                    <input type="text" wire:model="transaction_id">
                </x-ui.field>
                <x-ui.field label="Observações">
                    <textarea wire:model="notes" rows="2"></textarea>
                </x-ui.field>
            </form>
            <x-slot:footer>
                <button type="button" wire:click="$set('showForm', false)" class="btn btn-secondary">Cancelar</button>
                <button type="button" wire:click="save" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i> Confirmar pagamento
                </button>
            </x-slot:footer>
        </x-ui.modal>
    @endif
</div>
