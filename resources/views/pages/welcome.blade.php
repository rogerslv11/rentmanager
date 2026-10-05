<div class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    {{-- Background mesh --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-1/3 -left-1/4 w-2/3 h-2/3 bg-[#22C55E]/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-1/3 -right-1/4 w-2/3 h-2/3 bg-[#3B82F6]/8 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 opacity-[0.015]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    <div class="relative text-center max-w-2xl">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-[#22C55E] to-[#15803D] shadow-2xl shadow-[#22C55E]/30 mb-6">
            <i data-lucide="home" class="w-10 h-10 text-[#052E16]"></i>
        </div>
        <h1 class="text-5xl sm:text-6xl font-bold text-white tracking-tight">RentManager</h1>
        <p class="text-lg text-[#A1A1AA] mt-4 max-w-lg mx-auto">Plataforma completa de gestão imobiliária para imobiliárias e administradoras.</p>

        <div class="flex items-center justify-center gap-3 mt-8 flex-wrap">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow-lg shadow-[#22C55E]/20">
                <i data-lucide="log-in" class="w-4 h-4"></i> Acessar plataforma
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline btn-lg">
                Criar conta grátis
            </a>
        </div>

        <div class="mt-12 grid grid-cols-2 sm:grid-cols-5 gap-3 max-w-2xl mx-auto text-xs text-[#71717A]">
            <div class="px-3 py-2 rounded-lg bg-[#0F0F12]/60 border border-[#1F1F23] backdrop-blur">Imóveis</div>
            <div class="px-3 py-2 rounded-lg bg-[#0F0F12]/60 border border-[#1F1F23] backdrop-blur">Contratos</div>
            <div class="px-3 py-2 rounded-lg bg-[#0F0F12]/60 border border-[#1F1F23] backdrop-blur">Cobranças</div>
            <div class="px-3 py-2 rounded-lg bg-[#0F0F12]/60 border border-[#1F1F23] backdrop-blur">Manutenção</div>
            <div class="px-3 py-2 rounded-lg bg-[#0F0F12]/60 border border-[#1F1F23] backdrop-blur">Repasses</div>
        </div>

        <div class="mt-10 inline-flex items-center gap-2 px-3 py-1.5 bg-[rgba(34,197,94,0.08)] border border-[rgba(34,197,94,0.18)] rounded-full text-xs">
            <span class="w-2 h-2 rounded-full bg-[#22C55E] pulse-green"></span>
            <span class="text-[#4ADE80] font-medium">Demo: demo@rentmanager.test / password</span>
        </div>
    </div>
</div>
