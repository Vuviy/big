@php
    $inputId = uniqid($name . '-select');
@endphp
<div class="form-item form-item--select {{ $typeView ?? '' }}">
    @if (isset($label))
        <label for="{{ $inputId }}" class="form-item__label">{{ $label }}</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $inputId }}"
        class="form-item__control {{ isset($class) ? $class : '' }}"
        @if (isset($attributes))
             @foreach ($attributes as $attribute)
                     {{ $attribute }}
             @endforeach
        @endif
        placeholder="{!! isset($placeholder) ? $placeholder : '' !!}" >

        {{ $slot }}
    </select>
    @error($name)
    <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
    @enderror
</div>
