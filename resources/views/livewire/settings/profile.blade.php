<div>
    {{-- Hero header with profile banner --}}
    <div class="card overflow-hidden mb-6 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-[rgba(34,197,94,0.08)] via-transparent to-[rgba(59,130,246,0.04)] pointer-events-none"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#22C55E] to-transparent opacity-60"></div>

        {{-- Banner background --}}
        <div class="relative h-32 bg-gradient-to-br from-[#22C55E] via-[#15803D] to-[#15803D] overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyB2aWV3Qm94PSIwIDAgNjAgNjAiPjxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGcgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA4KSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNIDAgMCBMIDAgNjAgTTYwIDAgTDYwIDYwIi8+PC9nPjwvZz48L3N2Zz4=')] opacity-50"></div>
        </div>

        <div class="relative px-6 lg:px-8 pb-6 -mt-16">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div class="flex items-end gap-5">
                    <div class="avatar avatar-xl bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] text-2xl ring-4 ring-[#0F0F12] shadow-2xl shadow-[#22C55E]/30">
                        {{ auth()->user()->initials() }}
                    </div>
                    <div class="min-w-0 pb-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">{{ auth()->user()->name }}</h1>
                        <p class="text-sm text-[#A1A1AA] mt-1">{{ auth()->user()->email }}</p>
                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            @if($stats['role'])
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[rgba(34,197,94,0.08)] border border-[rgba(34,197,94,0.18)] text-[#4ADE80] rounded-full text-xs font-medium">
                                    <i data-lucide="shield-check" class="w-3 h-3"></i> {{ $stats['role'] }}
                                </span>
                            @endif
                            @if($stats['organization'] && $stats['organization'] !== '—')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#1A1A1F] border border-[#27272A] text-[#A1A1AA] rounded-full text-xs">
                                    <i data-lucide="building" class="w-3 h-3"></i> {{ $stats['organization'] }}
                                </span>
                            @endif
                            @if(auth()->user()->email_verified_at)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[rgba(34,197,94,0.06)] border border-[rgba(34,197,94,0.15)] text-[#4ADE80] rounded-full text-xs">
                                    <i data-lucide="badge-check" class="w-3 h-3"></i> Verificado
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 lg:pb-2">
                    <div class="text-right">
                        <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Conta criada</div>
                        <div class="text-sm font-semibold text-white">{{ $stats['created_at']->format('d/m/Y') }}</div>
                    </div>
                    <div class="w-px h-10 bg-[#1F1F23]"></div>
                    <div class="text-right">
                        <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold">Último acesso</div>
                        <div class="text-sm font-semibold text-white">{{ $stats['last_login']->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Quick info sidebar --}}
        <div class="space-y-4">
            <div class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Informações da conta</h3>
                </div>
                <div class="p-5 space-y-3">
                    <div>
                        <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">E-mail</div>
                        <div class="flex items-center gap-2 text-sm text-white">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-[#52525B]"></i>
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                    @if(auth()->user()->phone)
                        <div>
                            <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Telefone</div>
                            <div class="flex items-center gap-2 text-sm text-white">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-[#52525B]"></i>
                                {{ auth()->user()->phone }}
                            </div>
                        </div>
                    @endif
                    <div>
                        <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Função</div>
                        <div class="flex items-center gap-2 text-sm text-white">
                            <i data-lucide="user-cog" class="w-3.5 h-3.5 text-[#52525B]"></i>
                            {{ $stats['role'] }}
                        </div>
                    </div>
                    @if($stats['organization'] !== '—')
                        <div>
                            <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Organização</div>
                            <div class="flex items-center gap-2 text-sm text-white">
                                <i data-lucide="building" class="w-3.5 h-3.5 text-[#52525B]"></i>
                                {{ $stats['organization'] }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#A855F7] to-[#7E22CE] text-white">
                        <i data-lucide="activity" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Atividade</h3>
                </div>
                <div class="p-5 space-y-3">
                    <div>
                        <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Conta criada</div>
                        <div class="text-sm text-white">{{ $stats['created_at']->format('d/m/Y H:i') }}</div>
                        <div class="text-[10px] text-[#71717A] mt-0.5">{{ $stats['created_at']->diffForHumans() }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-semibold mb-1">Último acesso</div>
                        <div class="text-sm text-white">{{ $stats['last_login']->format('d/m/Y H:i') }}</div>
                        <div class="text-[10px] text-[#71717A] mt-0.5">{{ $stats['last_login']->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Forms --}}
        <div class="lg:col-span-2 space-y-5">
            <form wire:submit="updateProfile" class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-white">Informações pessoais</h3>
                        <p class="text-xs text-[#71717A] mt-0.5">Atualize seu nome, email e telefone</p>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    <x-ui.field label="Nome completo" required>
                        <input type="text" wire:model="name">
                    </x-ui.field>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.field label="Email" required>
                            <input type="email" wire:model="email">
                        </x-ui.field>
                        <x-ui.field label="Telefone" optional>
                            <input type="text" wire:model="phone" placeholder="(11) 99999-9999">
                        </x-ui.field>
                    </div>
                    <div class="flex items-center justify-end pt-2 border-t border-[#1F1F23]">
                        <button type="submit" class="btn btn-primary shadow-lg shadow-[#22C55E]/10">
                            <i data-lucide="check" class="w-4 h-4"></i> Salvar alterações
                        </button>
                    </div>
                </div>
            </form>

            <form wire:submit="updatePassword" class="card overflow-hidden">
                <div class="p-5 border-b border-[#1F1F23] flex items-center gap-3">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03]">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-white">Alterar senha</h3>
                        <p class="text-xs text-[#71717A] mt-0.5">Use uma senha forte com pelo menos 8 caracteres</p>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    <x-ui.field label="Senha atual" required>
                        <input type="password" wire:model="current_password" autocomplete="current-password">
                    </x-ui.field>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.field label="Nova senha" required hint="Mínimo 8 caracteres">
                            <input type="password" wire:model="new_password" autocomplete="new-password">
                        </x-ui.field>
                        <x-ui.field label="Confirmar nova senha" required>
                            <input type="password" wire:model="new_password_confirmation" autocomplete="new-password">
                        </x-ui.field>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-[#1F1F23]">
                        <div class="flex items-center gap-2 text-xs text-[#71717A]">
                            <i data-lucide="shield" class="w-3.5 h-3.5 text-[#52525B]"></i>
                            <span>Sua senha é criptografada e nunca armazenada em texto puro.</span>
                        </div>
                        <button type="submit" class="btn btn-secondary">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Alterar senha
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
