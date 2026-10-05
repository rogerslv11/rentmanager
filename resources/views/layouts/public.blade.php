<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Imóvel' }} · RentManager</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2322C55E' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'/%3E%3Cpath d='M9 22V12h6v10'/%3E%3C/svg%3E">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[#08080A] text-white antialiased font-sans min-h-screen mesh-bg">
    {{ $slot }}
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', () => window.lucide.createIcons({ icons: window.lucide.icons }));
        document.addEventListener('livewire:init', () => {
            window.Livewire.hook('morph.updated', () => window.lucide.createIcons({ icons: window.lucide.icons }));
        });
    </script>
</body>
</html>
