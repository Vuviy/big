@php
    $labelId = uniqid($name . '-label');
    $inputId = uniqid($name . '-input');
@endphp
<div class="form-item form-item--textarea {{ $classes ?? '' }}" data-form-item>
    @if (isset($label))
        <label for="{{ $inputId }}" class="form-item__label _text _fz-xxxs _color-faint-strong">{{ $label }}</label>
    @endif
    <div class="form-item__body">
        <textarea
            name="{{ $name }}"
            id="{{ $inputId }}"
            @if (isset($attributes))
            @foreach ($attributes as $attribute)
            {{ $attribute }}
            @endforeach
            @endif
            placeholder="{!! isset($placeholder)?$placeholder:'' !!}"
            class="form-item__control {{ isset($class) ? $class : '' }}"
            data-form-el
        >{{ isset($slot) ? $slot : '' }}</textarea>
    </div>
    @error($name)
        <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
    @enderror
</div>
