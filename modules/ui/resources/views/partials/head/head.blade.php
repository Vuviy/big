<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">

@include('cms-ui::partials.head.fonts')

{!! SEO::generate() !!}

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="address=no">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
@stack('preload')

@include('cms-ui::partials.head.favicons')

@livewireStyles

{{-- Webpack output --}}
<style id="style-insert"></style>

@foreach($assetManager->getCss(\WezomCms\Core\Contracts\Assets\AssetManagerInterface::GROUP_SITE, \WezomCms\Core\Contracts\Assets\AssetManagerInterface::POSITION_HEAD) as $style)
    {!! $style !!}
@endforeach

@stack('styles')

@foreach($assetManager->getJs(\WezomCms\Core\Contracts\Assets\AssetManagerInterface::GROUP_SITE, \WezomCms\Core\Contracts\Assets\AssetManagerInterface::POSITION_HEAD) as $script)
    {!! $script !!}
@endforeach
