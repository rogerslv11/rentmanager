<aside
    x-data="{ open: window.innerWidth >= 1024 }"
    x-init="() => {
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) open = true;
        });
    }"
    :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0A0A0C] border-r border-[#1F1F23] flex flex-col transition-transform duration-300 lg:translate-x-0">

    <div class="h-16 flex items-center justify-between px-5 border-b border-[#1F1F23] flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
            <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] shadow-lg shadow-[#22C55E]/20 group-hover:shadow-[#22C55E]/40 group-hover:scale-105 transition-all">
                <i data-lucide="home" class="w-4 h-4"></i>
            </div>
            <div class="min-w-0">
                <div class="font-bold text-white text-sm tracking-tight">RentManager</div>
                <div class="text-[10px] text-[#71717A] font-medium tracking-wider uppercase truncate">Gestão Imobiliária</div>
            </div>
        </a>
        <button @click="open = false" class="lg:hidden text-[#71717A] hover:text-white transition-colors p-1 rounded hover:bg-[#1A1A1F]">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-5">
        @php
            $navGroups = [
                'Principal' => [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'match' => 'dashboard'],
                ],
                'Carteira' => [
                    ['route' => 'properties.index', 'label' => 'Imóveis', 'icon' => 'building-2', 'match' => 'properties*'],
                    ['route' => 'owners.index', 'label' => 'Proprietários', 'icon' => 'users-round', 'match' => 'owners*'],
                    ['route' => 'tenants.index', 'label' => 'Inquilinos', 'icon' => 'user-round', 'match' => 'tenants*'],
                    ['route' => 'contracts.index', 'label' => 'Contratos', 'icon' => 'file-text', 'match' => 'contracts*'],
                ],
                'Financeiro' => [
                    ['route' => 'charges.index', 'label' => 'Cobranças', 'icon' => 'receipt', 'match' => 'charges*'],
                    ['route' => 'payments.index', 'label' => 'Pagamentos', 'icon' => 'credit-card', 'match' => 'payments*'],
                    ['route' => 'payouts.index', 'label' => 'Repasses', 'icon' => 'banknote', 'match' => 'payouts*'],
                    ['route' => 'expenses.index', 'label' => 'Despesas', 'icon' => 'trending-down', 'match' => 'expenses*'],
                ],
                'Operações' => [
                    ['route' => 'maintenance.index', 'label' => 'Manutenção', 'icon' => 'wrench', 'match' => 'maintenance*'],
                    ['route' => 'vendors.index', 'label' => 'Fornecedores', 'icon' => 'hard-hat', 'match' => 'vendors*'],
                    ['route' => 'inspections.index', 'label' => 'Vistorias', 'icon' => 'clipboard-check', 'match' => 'inspections*'],
                    ['route' => 'insurance.index', 'label' => 'Seguros', 'icon' => 'shield', 'match' => 'insurance*'],
                    ['route' => 'documents.index', 'label' => 'Documentos', 'icon' => 'folder-open', 'match' => 'documents*'],
                ],
                'Análise' => [
                    ['route' => 'calendar.index', 'label' => 'Calendário', 'icon' => 'calendar', 'match' => 'calendar*'],
                    ['route' => 'reports.index', 'label' => 'Relatórios', 'icon' => 'bar-chart-3', 'match' => 'reports*'],
                ],
            ];
        @endphp

        @foreach ($navGroups as $groupName => $items)
            <div>
                <div class="section-title mb-1">{{ $groupName }}</div>
                <div class="space-y-0.5">
                    @foreach ($items as $item)
                        @php
                            $isActive = request()->routeIs($item['match']) || (str_ends_with($item['match'], '*') && request()->routeIs(rtrim($item['match'], '*')));
                        @endphp
                        <a href="{{ route($item['route']) }}"
                           class="nav-item {{ $isActive ? 'active' : '' }}">
                            <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 {{ $isActive ? 'text-[#22C55E]' : '' }}"></i>
                            <span class="flex-1 truncate">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="p-3 border-t border-[#1F1F23] flex-shrink-0">
        @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-[#1A1A1F] transition-colors">
                    <div class="avatar avatar-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] text-xs">
                        {{ auth()->user()->initials() }}
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <div class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-[#71717A] truncate">{{ auth()->user()->email }}</div>
                    </div>
                    <i data-lucide="chevron-up" class="w-4 h-4 text-[#71717A] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-transition x-cloak @click.away="open = false"
                     class="absolute bottom-full left-0 right-0 mb-2 bg-[#0F0F12] border border-[#27272A] rounded-xl shadow-2xl overflow-hidden">
                    <div class="px-3 py-2.5 border-b border-[#1F1F23]">
                        <div class="text-[10px] uppercase tracking-wider text-[#52525B] font-semibold">Logado como</div>
                        <div class="text-sm font-medium text-white truncate mt-0.5">{{ auth()->user()->name }}</div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white transition-colors">
                        <i data-lucide="user" class="w-4 h-4"></i> Perfil
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#A1A1AA] hover:bg-[#1A1A1F] hover:text-white transition-colors">
                        <i data-lucide="settings" class="w-4 h-4"></i> Configurações
                    </a>
                    <div class="border-t border-[#1F1F23]"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm text-[#F43F5E] hover:bg-[rgba(244,63,94,0.08)] transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Sair
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</aside>

<div x-data x-show="$store?.mobileMenu ?? false" x-cloak @click="$store.mobileMenu = false"
     class="fixed inset-0 bg-black/70 z-40 lg:hidden backdrop-blur-sm"></div>
