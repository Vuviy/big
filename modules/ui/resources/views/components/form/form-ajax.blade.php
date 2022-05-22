@php

    /**
     * @var string $id
     * @var string $route
     * @var string $class
     */

    $hasClass = isset($class);
    $classes = $hasClass ? $class . ' form ajax-form js-import js-static' : 'form ajax-form js-import js-static';

@endphp
{!! Form::open([
    'id' => $id,
    'route' => $route,
    'method' => 'POST',
    'class' => $classes,
]) !!}2
<div class="form__body">
    {!! $slot !!}
</div>
{!! Form::close() !!}
