@props(['align' => 'right', 'width' => 'w-56'])

<div x-data="{ open: false }" @click.away="open = false" class="relative inline-block">
    <div @click="open = !open">
        {{ $trigger }}
    </div>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        class="absolute z-50 mt-2 {{ $width }} bg-[#18181B] border border-[#27272A] rounded-lg shadow-xl overflow-hidden {{ $align === 'right' ? 'right-0' : 'left-0' }}">
        {{ $slot }}
    </div>
</div>
