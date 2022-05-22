@php
    /**
     * @var $name string
     * @var $obj \Illuminate\Database\Eloquent\Model|\WezomCms\Core\Traits\Model\FileAttachable
     */
    $locale = null;
    $field = $name;
    if (str_contains($name, '[')) {
        preg_match('#(.+?)\[(.+?)\]#', $name, $matched);
        $locale = array_get($matched, 1);
        $field = array_get($matched, 2);
    }

    $fileName = $obj->fileExists($field, $locale) ? ($obj->getOriginalFileName($field, $locale) ?: $obj->getFileName($field, $locale)) : null;
    $recommendResolution = $obj->getRecommendUploadVideoResolution($field);
    $maxSize = $obj->getRecommendUploadVideoMaxFileSize($field);
@endphp
@if($recommendResolution)
    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-html="true"
       title="@lang('cms-core::admin.video.The file must have the extension') {{ $options['accept'] ?? '.mp4' }}.
       @if($maxSize)@lang('cms-core::admin.video.File size must not exceed') {{ $maxSize . 'MB.'}}@endif
       @lang('cms-core::admin.video.The recommended resolution of the loaded video') {{ implode('x', $recommendResolution) }}px"
    ></i>
@endif
<div class="file-uploader">
    @if($obj->fileExists($field, $locale))
        <div class="__path">{{ sprintf('%s (%s)', $fileName, $obj->getFileSize(true, $field, $locale)) }}</div>
        <div class="__controls">
            <a href="{{ $obj->getFileUrl($field, $locale) }}" download="{{ $fileName }}" class="btn btn-info btn-sm"><i
                        class="fa fa-download"></i> @lang('cms-core::admin.layout.View / Download')</a>
            @if($deleteAction)
                <a href="{{ $deleteAction }}" class="btn btn-danger btn-sm"
                   onclick="return confirmDelete(this)"
                ><i class="fa fa-trash"></i> @lang('cms-core::admin.layout.Delete')</a>
            @endif
        </div>
    @else
        {!! Form::file($name) !!}
    @endif
</div>
