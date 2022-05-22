@php
    /**
     * @var $isFavorite bool
     */
@endphp
<div>
    @if($isFavorite)
        <button class="button product-card__button product-card__button--favorite _b-r-sm is-active"
                wire:click="remove"
                wire:key="remove-fav-product-list-btn-{{ $payload }}"
                type="button"
                title="@lang('cms-favorites::site.Добавлено в избранное')">
            @svg('common', 'heart-fill', [20, 20])
        </button>
    @else
        <button class="button product-card__button product-card__button--favorite _b-r-sm"
                wire:click="add"
                wire:key="add-fav-product-list-btn-{{ $payload }}"
                title="@lang('cms-favorites::site.Добавить в избранное')">
            @svg('common', 'heart-stroke', [20, 20])
        </button>
    @endif
</div>
