@extends('cms-ui::layouts.main')

@php
    /**
     * @var $obj \WezomCms\Pages\Models\Page
     */
@endphp

@section('content')
    <div class="section">
        <div class="container">
            <div class="text _fz-xxl _fw-bold">{{ SEO::getH1() }}</div>
            <div class="wysiwyg js-import" data-wrap-media data-draggable-table>
                {!! $obj->text !!}
            </div>
        </div>
    </div>
@endsection
