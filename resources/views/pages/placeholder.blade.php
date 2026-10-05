<div class="min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-md">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#1A1A1F] to-[#0F0F12] border border-[#27272A] mb-4">
            <i data-lucide="{{ $icon ?? 'wrench' }}" class="w-8 h-8 text-[#71717A]"></i>
        </div>
        <h1 class="text-2xl font-bold text-white">{{ $title }}</h1>
        <p class="text-sm text-[#71717A] mt-2">Módulo em desenvolvimento. Em breve estará disponível.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-6">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Voltar ao dashboard
        </a>
    </div>
</div>
