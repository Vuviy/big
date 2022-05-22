@extends('cms-ui::layouts.main', ['containerModification' => 'lg'])

@php
    /**
     * @var $result \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\News[]
     * @var $currentTag null|string
     */
@endphp

@section('content')
    <div class="section section--off-b-lg">
        <div class="container container--lg">
            <div class="text _fz-xxl _fw-bold _mb-md">{{ SEO::getH1() }}</div>

            @if($result->isNotEmpty())
                <div class="_mb-df">
                    @include('cms-news::site.partials.news-list')
                </div>
                <div>
                    {!! $result->links() !!}
                </div>
            @else
                <div>
                    @emptyResult
                </div>
            @endif
        </div>
    </div>
@endsection
