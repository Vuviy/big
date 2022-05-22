@extends('cms-ui::layouts.main', ['containerModification' => 'lg'])

@php
    /**
     * @var $obj \WezomCms\News\Models\News
     */
@endphp

@section('content')
    <div class="section section--off-b-lg">
        <div class="container container--lg">
            <div class="_grid _justify-between _spacer _spacer--md">
                <div class="_cell _cell--12 _md:cell--9 _lg:cell--10 _lg:pr-lg">
                    <div class="_mb-md">
                        <div class="text _fz-xxl _fw-bold _mb-sm">{{ SEO::getH1() }}</div>
                        <div class="text _color-pantone-gray">{{ localizedDate($obj->published_at) }}</div>
                    </div>
                    <div class="wysiwyg js-import" data-wrap-media data-draggable-table>{!! $obj->text !!}</div>
                </div>
                <div class="_cell _cell--12 _md:cell--3 _lg:cell--1 _df:pl-lg _lg:pl-none">
                    @widget('ui:share')
                </div>
            </div>
        </div>
    </div>
@endsection
