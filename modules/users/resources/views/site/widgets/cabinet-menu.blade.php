@php
    /**
     * @var $menu \Lavary\Menu\Builder
     * @var $highlightedUri string
     */
@endphp

@auth
    <div class="_mb-md _lg:mb-lg cabinet-menu__head">
        <div class="_fz-def _fw-bold _mb-sm">{{ Auth::user()->full_name }}</div>
        <a class="link _color-pantone-gray _fz-xs" href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
    </div>
    <div class="cabinet-menu">
        @foreach($menu->roots() as $item)
            <?php $counter = array_get($item->attributes, 'counter') ?>
            @if($item->isActive)
                <span class="cabinet-menu__item is-active _fz-xxs _fw-bold">{{ $item->title }}
                    @if($counter)
                        <span class="cabinet-menu__item-count _fz-xxxs">@livewire($counter)</span>
                    @endif
            </span>
            @elseif($item->url())
                <a href="{{ $item->url() }}"
                   class="cabinet-menu__item {{ $item->class }} _fz-xxs _fw-bold" {!! $item->el_attributes !!}>{{ $item->title }}
                    @if($counter)
                        <span class="cabinet-menu__item-count _fz-xxxs">@livewire($counter)</span>
                    @endif
                </a>
            @endif
        @endforeach
        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
           class="cabinet-menu__item cabinet-menu__item--leave _fz-xxs _fw-medium">
            @lang('cms-users::site.cabinet.Logout')
        </a>
    </div>
@endauth
