@php
    $bordered = $bordered ?? false;
    $color = $color ?? null;
    $textColor = $textColor ?? null;
    $var = $var ?? null;
@endphp

<div class="_cell _pl-xs color-block {{ $bordered ? 'color-block--bordered' : null }}"
     style="background-color: {{ $color }}">
    <div style="color: {{ $textColor }}">{{ $var }}</div>
    <div style="color: {{ $textColor }}">{{ $color }}</div>
</div>
