@props(['rows' => 1, 'height' => 'h-12'])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @for($i = 0; $i < $rows; $i++)
        <div class="skeleton rounded {{ $height }}"></div>
    @endfor
</div>
