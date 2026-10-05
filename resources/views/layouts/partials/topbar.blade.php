<header class="sticky-header h-16 flex items-center px-4 sm:px-6 gap-3">

    <button @click="$dispatch('toggle-sidebar')" class="lg:hidden text-[#A1A1AA] hover:text-white transition-colors p-1.5 rounded-lg hover:bg-[#1A1A1F]">
        <i data-lucide="menu" class="w-5 h-5"></i>
    </button>

    <button
        x-data
        @click="$dispatch('open-command-palette')"
        class="flex-1 max-w-md flex items-center gap-2.5 px-3.5 py-2 bg-[#0F0F12] hover:bg-[#16161A] border border-[#1F1F23] hover:border-[#27272A] rounded-lg text-[#71717A] text-sm transition-all">
        <i data-lucide="search" class="w-4 h-4"></i>
        <span class="flex-1 text-left truncate">Buscar imóveis, inquilinos, contratos...</span>
        <kbd class="hidden sm:flex items-center gap-0.5 px-1.5 py-0.5 text-[10px] font-medium bg-[#1A1A1F] border border-[#27272A] rounded text-[#71717A]">
            ⌘K
        </kbd>
    </button>

    <div class="flex-1"></div>

    @auth
        @if(auth()->user()->can('create properties'))
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="btn btn-primary h-9 px-3 shadow-lg shadow-[#22C55E]/10">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Novo</span>
                </button>
                <div x-show="open" x-transition x-cloak @click.away="open = false"
                     class="absolute right-0 mt-2 w-60 bg-[#0F0F12] border border-[#27272A] rounded-xl shadow-2xl overflow-hidden z-50">
                    <div class="px-3 py-2 border-b border-[#1F1F23]">
                        <div class="text-[10px] uppercase tracking-wider text-[#52525B] font-semibold">Criar novo</div>
                    </div>
                    <a href="{{ route('properties.create') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white transition-colors">
                        <i data-lucide="building-2" class="w-4 h-4"></i> Imóvel
                    </a>
                    <a href="{{ route('owners.create') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white transition-colors">
                        <i data-lucide="user-plus" class="w-4 h-4"></i> Proprietário
                    </a>
                    <a href="{{ route('tenants.create') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white transition-colors">
                        <i data-lucide="user-round-plus" class="w-4 h-4"></i> Inquilino
                    </a>
                    <a href="{{ route('contracts.create') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white transition-colors">
                        <i data-lucide="file-plus" class="w-4 h-4"></i> Contrato
                    </a>
                    <a href="{{ route('maintenance.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white transition-colors">
                        <i data-lucide="wrench" class="w-4 h-4"></i> Manutenção
                    </a>
                </div>
            </div>
        @endif

        <livewire:notifications.dropdown />

        <a href="{{ route('profile.edit') }}" class="hidden sm:flex items-center justify-center w-9 h-9 rounded-lg hover:bg-[#1A1A1F] text-[#A1A1AA] hover:text-white transition-colors tooltip" data-tooltip="Perfil e configurações">
            <i data-lucide="settings" class="w-4 h-4"></i>
        </a>
    @endauth
</header>
