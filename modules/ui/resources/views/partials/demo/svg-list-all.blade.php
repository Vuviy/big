@php
    $svgManifest = json_decode(file_get_contents(config('cms.ui.ui.manifest_path.svg')));
@endphp

@foreach($svgManifest as $key => $sprite)
    <div class="_mb-df">
        <div class="text _fz-lg _mb-sm">Sprite name: <code>{{ $key }}</code></div>
        @include('cms-ui::partials.demo.svg-list', [
            'path' => $key,
        ])
    </div>
@endforeach
