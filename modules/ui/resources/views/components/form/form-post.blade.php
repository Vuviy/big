@php

    /**
     * @var string $id
     * @var string $route
     * @var string $class
     */

    $hasClass = isset($class);
    $classes = $hasClass ? $class . ' form js-import' : 'form js-import';

@endphp
{!! Form::open([
    'id' => $id,
    'route' => $route,
    'method' => 'POST',
    'class' => $classes,
]) !!}
<div class="form__body ">
    {!! $slot !!}
</div>
{!! Form::close() !!}
