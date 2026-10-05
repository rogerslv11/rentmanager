@props([
    'name' => null,
    'show' => false,
    'maxWidth' => 'lg',
    'title' => null,
    'description' => null,
])

@php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        '2xl' => 'max-w-6xl',
        default => 'max-w-2xl',
    };
@endphp

<div
    x-data="{ open: @js($show) }"
    x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') open = true"
    x-on:close-modal.window="if ($event.detail.name === '{{ $name }}') open = false"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="fixed inset-0 modal-backdrop"></div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full {{ $maxWidthClass }} bg-[#0F0F12] border border-[#27272A] rounded-xl shadow-2xl my-8 overflow-hidden">

            @if($title || $description)
                <div class="flex items-start justify-between px-6 py-4 border-b border-[#1F1F23]">
                    <div class="min-w-0">
                        @if($title)
                            <h3 class="text-base font-semibold text-white">{{ $title }}</h3>
                        @endif
                        @if($description)
                            <p class="text-sm text-[#71717A] mt-0.5">{{ $description }}</p>
                        @endif
                    </div>
                    <button @click="open = false" class="text-[#71717A] hover:text-white transition-colors p-1 -mr-1 -mt-1 rounded hover:bg-[#1F1F23]">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            <div class="p-6">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-[#1F1F23] bg-[#0A0A0C]">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
