@php
    /**
     * @var $slot string|null
     * @var $attributes \Illuminate\View\ComponentAttributeBag
     */
@endphp
<div {{ $attributes->merge(['class' => 'wysiwyg scrollbar js-wysiwyg']) }}>{!! $slot !!}</div>
