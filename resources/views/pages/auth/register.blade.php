<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-1/3 -left-1/4 w-2/3 h-2/3 bg-[#22C55E]/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-1/3 -right-1/4 w-2/3 h-2/3 bg-[#22C55E]/8 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    <div class="relative w-full max-w-md page-enter">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#22C55E] to-[#15803D] shadow-2xl shadow-[#22C55E]/30 mb-5 relative">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-[#22C55E] to-[#15803D] blur-2xl opacity-40 -z-10"></div>
                <i data-lucide="home" class="w-8 h-8 text-[#052E16]"></i>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Crie sua conta</h1>
            <p class="text-sm text-[#71717A] mt-1.5">Comece a gerenciar seus imóveis hoje mesmo</p>
        </div>

        <div class="card shadow-card-lg p-7">
            <form wire:submit="register" class="space-y-4">
                <x-ui.field label="Nome completo" required :error="$errors->first('name')">
                    <input type="text" wire:model="name" required autofocus placeholder="Seu nome">
                </x-ui.field>

                <x-ui.field label="Email" required :error="$errors->first('email')">
                    <input type="email" wire:model="email" required placeholder="seu@email.com">
                </x-ui.field>

                <x-ui.field label="Nome da imobiliária/empresa" required :error="$errors->first('organization_name')">
                    <input type="text" wire:model="organization_name" required placeholder="Ex: Imobiliária Aurora">
                </x-ui.field>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-ui.field label="Senha" required :error="$errors->first('password')" hint="Mínimo 8 caracteres">
                        <input type="password" wire:model="password" required>
                    </x-ui.field>

                    <x-ui.field label="Confirmar" required :error="$errors->first('password_confirmation')">
                        <input type="password" wire:model="password_confirmation" required>
                    </x-ui.field>
                </div>

                <button type="submit" class="btn btn-primary w-full mt-2" wire:loading.attr="disabled">
                    <span wire:loading.remove class="flex items-center gap-2">
                        <i data-lucide="user-plus" class="w-4 h-4"></i> Criar conta
                    </span>
                    <span wire:loading class="flex items-center gap-2">
                        <span class="spinner"></span> Criando...
                    </span>
                </button>

                <div class="relative my-5">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#1F1F23]"></div>
                    </div>
                    <div class="relative flex justify-center text-[10px]">
                        <span class="bg-[#0F0F12] px-3 text-[#52525B] uppercase tracking-wider font-semibold">Já tem conta?</span>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn btn-outline w-full">
                    <i data-lucide="log-in" class="w-4 h-4"></i> Entrar
                </a>
            </form>
        </div>

        <p class="text-center text-xs text-[#52525B] mt-6">
            © {{ date('Y') }} RentManager. Todos os direitos reservados.
        </p>
    </div>
</div>
