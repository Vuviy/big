<div class="catalog-menu">
    <div class="container _flex-grow">
        <div class="catalog-menu__inner">
            <nav class="catalog-menu__nav">
                <ul class="catalog-menu__list list">
                    @foreach($categories as $root)
                        <li class="catalog-menu__item">
                            <a href="{{ $root->getFrontUrl() }}"
                               class="catalog-menu__link @if($loop->first) is-active @endif"
                               x-ref="menu-preview-item-{{$root->id}}"
                               @mouseover="setActiveCategory({{ $root->id }})"
                            >
                                {{ $root->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="catalog-menu__content">
                <div class="catalog-menu__content-inner">
                    @foreach($categories as $root)
                        <div class="catalog-menu__content-item @if($loop->first) is-active @endif"
                             x-ref="menu-item-{{$root->id}}"
                        >
                            <div class="catalog-menu__content-header">
                                <div class="catalog-menu__content-title">
                                    {{ $root->name }}
                                </div>
                            </div>
                            @if($root->children->isNotEmpty())
                                <div class="catalog-menu__content-body">
                                    @foreach($root->children as $level1)
                                        @if($level1->children->isNotEmpty())
                                            <div class="catalog-menu__group">
                                                <a href="{{ $level1->getFrontUrl() }}" class="catalog-menu__group-title">
                                                    {{ $level1->name }}
                                                </a>
                                                <ul class="catalog-menu__group-list list">
                                                    @foreach($level1->children as $level2)
                                                        <li class="catalog-menu__group-item">
                                                            <a href="{{ $level2->getFrontUrl() }}" class="catalog-menu__group-link">{{ $level2->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
