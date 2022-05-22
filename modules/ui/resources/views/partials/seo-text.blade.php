@php
    $seoText = trim(strip_tags(SEO::getSeoText()));
@endphp
@if($seoText)
    <div class="section section--off-t-lg section--off-b-lg scrollbar">
        <div class="container">
            <x-ui-wysiwyg :class="'wysiwyg--seo-text scrollbar'">{!! $seoText !!}</x-ui-wysiwyg>
        </div>
    </div>
@endif
