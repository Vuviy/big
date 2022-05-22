@php
/**
 * @var $updateBrowserLink string
 * @var $assetManager \WezomCms\Core\Contracts\Assets\AssetManagerInterface
 */
@endphp
<link rel="stylesheet" href="{{ $assetManager->addVersion(asset('build/unsupported-browser.css')) }}">

<div id="unsupported-browsers-block" class="unsupported-browsers" hidden>
    <div role="status" aria-live="polite">
        <div class="unsupported-browsers-message">
            <strong>@lang('cms-ui::site.Ваш браузер устарел').</strong>
            <span>@lang('cms-ui::site.Обновите ваш браузер для повышения уровня безопасности, скорости и комфорта пользования сайтом').</span>
        </div>
        <div class="unsupported-browsers-buttons">
            <a href="{{ $updateBrowserLink }}" rel="noopener nofollow" target="_blank">@lang('cms-ui::site.Обновить браузер')</a>
            <a class="unsupported-message-button-close" id="unsupported-message-button-close" role="button" tabindex="0">@lang('cms-ui::site.Игнорировать')</a>
        </div>
    </div>
</div>

<script>
    (function (window) {
        var key = 'unsupported-browsers-message';
        var storageValue = window.localStorage.getItem(key);
        var expires = 60 * 60 * 24 * 1000; // one day in ms

        if (storageValue) {
            if (+storageValue + expires < Date.now()) {
                window.localStorage.removeItem(key);
                show();
            }
        } else {
            show();
        }

        function show() {
            var block = document.getElementById('unsupported-browsers-block');
            var closeButton = document.getElementById('unsupported-message-button-close');

            block.removeAttribute('hidden');
            closeButton.addEventListener('click', function (e) {
                e.preventDefault();
                block.setAttribute('hidden', '');
                window.localStorage.setItem(key, Date.now());
            }, false);
        }
    })(window);
</script>
