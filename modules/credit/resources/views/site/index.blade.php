@extends('cms-ui::layouts.main')
@php
    /**
     * @var $settings array
     */
@endphp
@section('content')
    @widget('ui:breadcrumbs')
    <div class="container">
        <div class="static-page static-page--columns">
            <div class="static-page__sidebar">
                @widget('ui:information-menu')
            </div>
            <div class="static-page__content _pb-xxl">
                <div class="static-page__content-width">
                    <h1>{{ SEO::getH1() }}</h1>
                    @component('ui-components::wysiwyg')
                        {!! array_get($settings, 'text') !!}
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
