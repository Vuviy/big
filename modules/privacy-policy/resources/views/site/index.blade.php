@extends('cms-ui::layouts.main')
@php
    /**
     * @var $settings array
     */
@endphp
@section('content')
    <div class="container">
        <h1>{{ SEO::getH1() }}</h1>
        <div class="wysiwyg js-import" data-wrap-media data-draggable-table>
            {!! array_get($settings, 'text') !!}
        </div>
    </div>
@endsection
