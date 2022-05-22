@auth
    @if(isset($menu))
        @foreach($menu->roots() as $item)
            <?php $counter = array_get($item->attributes, 'counter') ?>
            @if($item->isActive)
                <li class="mobile-menu__item list__item">
                        <span class="mobile-menu__link list__link link _no-underline _cursor-default">
                            <span class="link__text text _fz-xs _fw-bold _color-black _mr-xs">{{ $item->title }}</span>
                            @if($counter)
                                <span class="link__counter text _fz-xs _fw-bold _color-black">@livewire($counter)</span>
                            @endif
                        </span>
                </li>
            @elseif($item->url())
                <li class="mobile-menu__item list__item">
                    <a href="{{ $item->url() }}"
                       class="mobile-menu__link list__link link _no-underline"
                    >
                        <span class="link__text text _fz-xs _color-faint-strong _mr-xs">{{ $item->title }}</span>
                        @if($counter)
                            <span class="link__counter text _fz-xs _color-faint-strong">@livewire($counter)</span>
                        @endif
                    </a>
                </li>
            @endif
        @endforeach
    @endif
    <li class="mobile-menu__item list__item">
        <a href="#" onclick="event.preventDefault();document.forms['logout-form'].submit();"
           class="mobile-menu__link list__link_fz-xxs _fw-medium _no-underline">
            <span class="link__text text _fz-xs _color-faint-strong">@lang('cms-users::site.cabinet.Logout')</span>
        </a>
    </li>

    <li class="separator separator--horizontal separator--offset-sm"></li>
@endauth
