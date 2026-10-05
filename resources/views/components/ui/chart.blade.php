@props([
    'title' => null,
    'model' => null,
    'onclick' => null,
])

<div class="card p-5" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    @if($title)
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-white">{{ $title }}</h3>
        </div>
    @endif
    <div wire:ignore>
        <canvas
            x-ref="canvas"
            x-init="
                const chart = new Chart($refs.canvas, {{ $model }});
                $watch('show', () => chart.resize());
            "
            @if($onclick)
                @click="{{ $onclick }}"
            @endif
            class="max-h-72"></canvas>
    </div>
</div>
