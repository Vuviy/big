@php
    /**
     *
     * @var $name string
     * @var $label string|null
     * @var $placeholder string|null
     * @var $value string|null
     * @var $type string|null
     * @var $classes string|null
     * @var $attributes \Illuminate\View\ComponentAttributeBag
     *
    */

        $inputId = uniqid($name . '-input');
@endphp

<div class="form-item form-item--input {{ $classes ?? '' }}">
    <div class="form-item__header">
        @if (isset($label))
            <label for="{{ $inputId }}" class="form-item__label _text _fz-xxxs _color-faint-strong">{{ $label }}</label>
        @endif
    </div>
    <div class="form-item__body">
        <input
            name="{{ $name }}"
            id="{{ $inputId }}"
            type="{{ $type ?? 'text' }}"
            value="{{ $value ?? '' }}"
            placeholder="{{ $placeholder ?? '' }}"
            @foreach ($attributes ?? [] as $attribute)
            {{ $attribute }}
            @endforeach
            class="form-item__control text _fz-sm _color-pantone-gray {{ $errors->has($name) ? 'has-error' : null }}"
        >
    </div>
    @error($name)
        <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
    @enderror
</div>
