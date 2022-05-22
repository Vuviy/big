@php
    /**
     * @var $slot string|null
     * @var $attributes \Illuminate\View\ComponentAttributeBag
     */
@endphp
<div {{ $attributes->merge(['class' => 'wysiwyg wysiwyg_mini']) }}>{!! $slot !!}</div>
