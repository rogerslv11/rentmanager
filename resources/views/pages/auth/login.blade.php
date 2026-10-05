<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    {{-- Background effects --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-1/3 -left-1/4 w-2/3 h-2/3 bg-[#22C55E]/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-1/3 -right-1/4 w-2/3 h-2/3 bg-[#22C55E]/8 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    <div class="relative w-full max-w-md page-enter">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#22C55E] to-[#15803D] shadow-2xl shadow-[#22C55E]/30 mb-5 relative">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-[#22C55E] to-[#15803D] blur-2xl opacity-40 -z-10"></div>
                <i data-lucide="home" class="w-8 h-8 text-[#052E16]"></i>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">RentManager</h1>
            <p class="text-sm text-[#71717A] mt-1.5">Plataforma de gestão imobiliária</p>
        </div>

        {{-- Card --}}
        <div class="card shadow-card-lg overflow-hidden">
            <div class="px-7 pt-7 pb-2">
                <h2 class="text-xl font-semibold text-white">Bem-vindo de volta</h2>
                <p class="text-sm text-[#71717A] mt-1">Entre com sua conta para acessar a plataforma</p>
            </div>

            <div class="p-7 pt-5">
                {{-- Quick demo login --}}
                <button
                    type="button"
                    wire:click="loginAsDemo"
                    wire:loading.attr="disabled"
                    wire:target="loginAsDemo"
                    class="w-full mb-5 px-4 py-3 bg-gradient-to-r from-[#22C55E] to-[#16A34A] hover:from-[#4ADE80] hover:to-[#22C55E] text-[#052E16] font-semibold rounded-lg shadow-lg shadow-[#22C55E]/20 transition-all flex items-center justify-center gap-2 group">
                    <span wire:loading.remove wire:target="loginAsDemo" class="flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                        Entrar como Demo
                    </span>
                    <span wire:loading wire:target="loginAsDemo" class="flex items-center gap-2">
                        <span class="spinner"></span>
                        Entrando...
                    </span>
                </button>

                <div class="relative my-5">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#1F1F23]"></div>
                    </div>
                    <div class="relative flex justify-center text-[10px]">
                        <span class="bg-[#0F0F12] px-3 text-[#52525B] uppercase tracking-wider font-semibold">ou use suas credenciais</span>
                    </div>
                </div>

                <form wire:submit="login" class="space-y-4">
                    <x-ui.field label="Email" required :error="$errors->first('email')">
                        <input type="email" wire:model="email" placeholder="seu@email.com" autofocus required>
                    </x-ui.field>

                    <x-ui.field label="Senha" required :error="$errors->first('password')">
                        <input type="password" wire:model="password" placeholder="••••••••" required>
                    </x-ui.field>

                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="flex items-center gap-2 text-[#A1A1AA] cursor-pointer select-none">
                            <input type="checkbox" wire:model="remember" class="rounded border-[#27272A] bg-[#0A0A0C] text-[#22C55E] focus:ring-[#22C55E] focus:ring-offset-0">
                            <span>Lembrar-me</span>
                        </label>
                        <a href="#" class="text-[#4ADE80] hover:text-[#22C55E] font-medium transition-colors">
                            Esqueceu a senha?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-secondary w-full" wire:loading.attr="disabled" wire:target="login">
                        <span wire:loading.remove wire:target="login">Entrar</span>
                        <span wire:loading wire:target="login" class="flex items-center gap-2">
                            <span class="spinner"></span> Entrando...
                        </span>
                    </button>
                </form>
            </div>

            <div class="px-7 pb-7">
                <div class="bg-gradient-to-br from-[#16161A] to-[#0F0F12] border border-[#1F1F23] rounded-lg p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="icon-box icon-box-sm bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                            <i data-lucide="key" class="w-3 h-3"></i>
                        </div>
                        <span class="text-[10px] font-bold text-[#4ADE80] uppercase tracking-wider">Conta demo</span>
                    </div>
                    <div class="text-xs text-[#A1A1AA] space-y-0.5 font-mono">
                        <div>Email: <span class="text-white">demo@rentmanager.test</span></div>
                        <div>Senha: <span class="text-white">password</span></div>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-[#52525B] mt-6">
            © {{ date('Y') }} RentManager. Todos os direitos reservados.
        </p>
    </div>
</div>
