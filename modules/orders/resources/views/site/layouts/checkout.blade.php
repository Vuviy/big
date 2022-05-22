<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    @include('cms-ui::partials.head.head')
    @widget('seo:metrics', ['position' => 'head'])
</head>
<body>
@widget('seo:metrics', ['position' => 'body'])
<div class="page">
    <div class="page__body">
        @include('cms-ui::widgets.header-basic', ['containerModification' => $containerModification ?? null])
        @yield('content')
    </div>
    <div class="page__footer">
        <div class="section section--bg-faint-weak section--off-t-md section--off-b-md">
            <div class="_flex _items-center _justify-center text _color-black _text-center">
                <span class="_fz-xl _lh-1" style="margin-top: 6px; margin-right: 3px">©</span>
                <span class="_fz-xxxs">2021 — Надёжный интернет супермаркет «Bigpayda.kz»</span>
            </div>
        </div>
    </div>
</div>
@widget('ui:hidden-data', ['checkoutPage' => true])
</body>
</html>
