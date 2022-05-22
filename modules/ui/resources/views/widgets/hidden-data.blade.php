@php
    /**
     * @var $assetManager \WezomCms\Core\Contracts\Assets\AssetManagerInterface
     */
@endphp

@foreach($assetManager->getCss(\WezomCms\Core\Contracts\Assets\AssetManagerInterface::GROUP_SITE, \WezomCms\Core\Contracts\Assets\AssetManagerInterface::POSITION_END_BODY) as $style)
    {!! $style !!}
@endforeach

@auth
    <form id="logout-form" action="{{ route('cabinet.logout') }}" method="POST" hidden>@csrf</form>
@endauth

<div class="page-fixed-panel">
    <div class="link-to-top js-link-to-top" title="@lang('cms-ui::site.Вверх')">
        @svg('common', 'arrow-up', 20)
    </div>
    @widget('contacts:socials-widget')
</div>

<script>
    (function () {
        window.app = {
            mask: {
                phone: '{{ config('cms.core.phone.mask') }}'
            },
            maps: {
                source: 'https://maps.googleapis.com/maps/api/js',
                query: {
                    key: '{{ settings('settings.site.google_map_key') }}',
                    language: '{{ app()->getLocale() }}'
                }
            },
            route: {
                component: '{{ route('render-component') }}'
            },
            i18n: {
                select: {
                    searchPlaceholder: '{{ __('cms-ui::site.Поиск') }}'
                },
                confirmReloadPage: '{{ __('cms-ui::site.Yes, reload page') }}',
                csrfExpires: '{{ __('cms-ui::site.This page has expired due to inactivity') }}',
                error503: '{{  __('cms-ui::site.Sorry, we do some service') }}',
                error503HelpText: '{{  __('cms-ui::site.Please check back soon') }}',
                no: '{{ __('cms-ui::site.No') }}',
                ok: '{{ __('cms-ui::site.ok') }}',
                pleaseTryAgainLater: '{{ __('cms-ui::site.Please try again later') }}',
                serverError: '{{ __('cms-core::site.Server error') }}',
                wouldYourLikeRefreshPage: '{{ __('cms-ui::site.Would you like to refresh the page?') }}'
            }
        };
    })();
</script>

@include('cms-ui::partials.modal')

@livewireScripts

@stack('scripts')

@foreach($assetManager->getJs(\WezomCms\Core\Contracts\Assets\AssetManagerInterface::GROUP_SITE, \WezomCms\Core\Contracts\Assets\AssetManagerInterface::POSITION_END_BODY) as $script)
    {!! $script !!}
@endforeach

<script src="https://cdn.jsdelivr.net/gh/alpine-collective/alpine-magic-helpers@1.2.x/dist/component.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

{{-- Render flash messages after redirect --}}
@if(session('flash-notifications'))
    <script>
        window.serverResponse.showNotices(@json(session('flash-notifications')));
    </script>
@endif
{{-- .Render flash messages after redirect --}}

@include('cms-ui::partials.hidden.noscript')
@include('cms-ui::partials.hidden.cookies')

@widget('ui:unsupported-browser')
