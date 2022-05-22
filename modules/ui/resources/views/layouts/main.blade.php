@extends('cms-ui::layouts.base', ['containerModification' => $containerModification ?? null])

@section('main')
    <main class="content">
        @widget('ui:breadcrumbs', ['containerModification' => $containerModification ?? null])
        @yield('content', '')
    </main>
    @include('cms-ui::partials.seo-text')
    @yield('after_content', '')
@endsection
