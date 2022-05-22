@php
    /**
     * @var $assetManager \WezomCms\Core\Contracts\Assets\AssetManagerInterface
     */
@endphp
<noscript>
    <link rel="stylesheet" href="{{ $assetManager->addVersion(asset('build/noscript.css')) }}">
    <div class="noscript-msg">
        <input id="noscript-msg__input" class="noscript-msg__input" type="checkbox" title="@lang('cms-ui::site.Закрыть')">
        <div class="noscript-msg__box">
            <label class="noscript-msg__close" for="noscript-msg__input">&times;</label>
            <div class="noscript-msg__content">
                <strong>@lang('cms-ui::site.В Вашем браузере отключен JavaScript! Для корректной работы с сайтом необходима поддержка Javascript Мы рекомендуем Вам включить использование JavaScript в настройках вашего браузера')</strong>
            </div>
        </div>
    </div>
</noscript>
