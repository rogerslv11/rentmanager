@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'required' => false,
    'optional' => false,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if($label)
        <label class="flex items-center gap-2 text-xs font-medium text-[#A1A1AA] uppercase tracking-wider">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-[#22C55E] normal-case tracking-normal">*</span>
            @endif
            @if($optional)
                <span class="text-[10px] text-[#52525B] font-normal normal-case tracking-normal">(opcional)</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if($hint && !$error)
        <p class="text-xs text-[#71717A] flex items-center gap-1">
            <i data-lucide="info" class="w-3 h-3"></i>
            {{ $hint }}
        </p>
    @endif

    @if($error)
        <p class="text-xs text-[#F43F5E] flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3 h-3"></i>
            {{ $error }}
        </p>
    @endif
</div>
