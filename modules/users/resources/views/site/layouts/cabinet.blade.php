@extends('cms-ui::layouts.base')

@section('main')
    <div class="cabinet">
        <div class="container container--lg">
            <div class="cabinet__grid">
                <div class="cabinet__sidebar">
                    @widget('cabinet-menu')
                </div>
                <div class="cabinet__body">
                    <h1 class="_fz-xxl _fw-bold _mb-sm _md:mb-df _mt-none">{{ SEO::getH1() }}</h1>
                    @yield('content', '')
                </div>
            </div>
        </div>
    </div>
    @yield('after_content', '')
@endsection
