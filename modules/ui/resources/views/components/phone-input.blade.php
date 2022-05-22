@php
    /**
     * @var $name string
     * @var $label string|null
     * @var $placeholder string|null
     * @var $value string|null
     * @var $classes string|null
     * @var $attributes \Illuminate\View\ComponentAttributeBag
     */

        $inputId = uniqid($name . '-input');
@endphp

<div {{ $attributes->merge(['class' => 'form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="form-item__label _text _fz-xxxs _color-faint-strong">{{ $label }}</label>
    @endif

    <div class="form-item__body">
        <input
            id="{{ $inputId }}"
            class="form-item__control js-dmi js-input-mask text _fz-sm _color-pantone-gray  {{ $errors->has($name) ? 'with-error' : null }}"
            type="tel"
            inputmode="tel"
            placeholder="{{ $placeholder ?? '' }}"
            name="{{ $name }}"
            value="{{ $value }}"
        >
    </div>

    @error($name)
        <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
    @enderror

    {!! $slot !!}
</div>
