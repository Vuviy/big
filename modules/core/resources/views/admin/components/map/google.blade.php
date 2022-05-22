@php
    /**
     * @var $assetManager \WezomCms\Core\Contracts\Assets\AssetManagerInterface
     */

    use WezomCms\Core\Foundation\Assets\Items\ExternalAssetItem;

    $assetManager->addJs((new ExternalAssetItem())
                ->setContent('https://maps.googleapis.com/maps/api/js?' . http_build_query(['key' => settings('settings.site.google_map_key')]))
                ->setName('google_map')
        )->once()->group(\WezomCms\Core\Contracts\Assets\AssetManagerInterface::GROUP_ADMIN);
@endphp
<div class="js-google-map" data-multiple="{{ $multiple ? 'true' : 'false' }}">
    @if(!$multiple)
        <div class="form-group">
            <input type="text" class="js-search-input form-control" onkeydown="return event.key != 'Enter';"
                   placeholder="@lang('cms-core::admin.layout.Search address')">
        </div>
    @endif
    <input type="hidden" class="js-input" name="{{ $name }}" value="{{ json_encode($value) }}" {!! Html::attributes($attributes) !!}>
    <div class="js-map-container"
         data-config="{{ json_encode(['center' => $center]) }}"
         style="height: {{ $height }}px;"></div>
</div>
