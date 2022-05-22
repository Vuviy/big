@extends('cms-ui::layouts.main')

@php
    /**
     * @var $items array
     */
@endphp

@section('content')
    <h1>{{ SEO::getH1() }}</h1>
    <ul>
        @foreach($items[0] ?? [] as $item)
            @include('cms-sitemap::site.recursive-item', ['items' => $items, 'item' => $item])
        @endforeach
    </ul>
@endsection
