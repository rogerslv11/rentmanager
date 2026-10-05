<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#08080A">
    <title>{{ $title ?? 'Portal' }} · RentManager</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2322C55E' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'/%3E%3Cpath d='M9 22V12h6v10'/%3E%3C/svg%3E">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[#08080A] text-white min-h-screen antialiased mesh-bg">
    <header class="sticky top-0 z-30 bg-[#08080A]/80 backdrop-blur-xl border-b border-[#1F1F23]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] shadow-lg shadow-[#22C55E]/20 group-hover:shadow-[#22C55E]/40 transition-shadow">
                    <i data-lucide="home" class="w-4 h-4"></i>
                </div>
                <div>
                    <div class="text-sm font-bold text-white tracking-tight">RentManager</div>
                    <div class="text-[10px] text-[#71717A] uppercase tracking-wider font-medium">Portal</div>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2.5 px-3 py-1.5 rounded-lg bg-[#0F0F12] border border-[#1F1F23]">
                    <div class="avatar avatar-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] text-xs">
                        {{ auth()->user()->initials() }}
                    </div>
                    <div class="hidden md:block">
                        <div class="text-sm font-medium text-white leading-tight">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-[#71717A]">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="btn btn-ghost btn-icon tooltip" data-tooltip="Sair">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8 page-enter">
        {{ $slot }}
    </main>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', () => window.lucide.createIcons({ icons: window.lucide.icons }));
        document.addEventListener('livewire:init', () => {
            window.Livewire.hook('morph.updated', () => window.lucide.createIcons({ icons: window.lucide.icons }));
        });
    </script>
</body>
</html>
