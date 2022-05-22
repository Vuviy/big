@php
    $inputId = uniqid($name);
@endphp
<div class="form-item form-item--checkbox {{ isset($class)? $class : '' }}">
    <input
        id="{{ $inputId }}"
        name="{{ $name }}"
        @if (isset($attributes))
        @foreach ($attributes as $attribute)
        {{ $attribute }}
        @endforeach
        @endif
        type="checkbox"
        class="form-item__control  {!! isset($class) ? $class : '' !!}"
    >
    <label for="{{$inputId}}" class="form-item__control-label">
        <span class="form-item__icon"></span>
        <span class="form-item__label">{{ isset($slot) ? $slot : '' }}</span>
    </label>
    @if ($errors->has($name))
        <label id="{{$inputId}}-error" class="has-error" for="{{$inputId}}">{{ $errors->first($name) }}</label>
    @endif
</div>
