<a href="{{ $obj->url }}" class="media-card {{ $classes }}" @if($obj->open_in_new_tab) target="_blank" @endif>
    <span class="media-card__body">
        <span class="media-card__img">
            @if($type === 'image')
                <img src="{{ $obj->getImageUrl() }}" alt="{{ $obj->name }}">
            @else
                <video src="{{ $obj->getFileUrl('video') }}" autoplay playsinline muted loop></video>
            @endif
        </span>
    </span>
    <span class="media-card__footer">
        <span class="media-card__title text _fz-def _fw-bold">
            {{ $obj->name }}
        </span>
        @if(!empty($obj->description))
            <span class="media-card__text text _fz-xs _lg:show">
                {{ $obj->description }}
            </span>
        @endif
    </span>
</a>
