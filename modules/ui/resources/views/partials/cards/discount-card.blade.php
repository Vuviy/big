<a href="{{ $obj->url }}" class="discount-card {{ $classes }}" @if($obj->open_in_new_tab) target="_blank" @endif >
    <span class="discount-card__body">
        <span class="discount-card__img">
            <img src="{{ $obj->getImageUrl() }}" alt="{{ $obj->name }}">
        </span>
    </span>
    <span class="discount-card__footer {{ isset($obj -> description) && $obj -> description ? 'discount-card__footer--description' : '' }}">
        <span class="discount-card__title text _fz-def _fw-bold">
            {{ $obj->name }}
        </span>
        @if(isset($obj -> description) && $obj -> description)
            <span class="discount-card__description text _fz-xs _color-pantone-gray">{{ $obj -> description }}</span>
        @endif
    </span>
</a>
