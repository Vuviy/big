@php
    /**
     * @var $isFavorite bool
     */
@endphp
<div class="_flex _flex-grow">
    @if($isFavorite)
        <button type="button"
                class="button button--theme-transparent _b-r-sm _control-height-md _control-padding-xs _flex-grow"
                wire:click="remove"
                title="@lang('cms-favorites::site.В избранном')"
        >
            <span class="button__icon icon icon--favorite is-active">
                @svg('common', 'heart-fill', [20, 16])
            </span>
        </button>
    @else
        <button type="button"
                class="button button--theme-transparent _b-r-sm _control-height-md _control-padding-xs _flex-grow"
                wire:click="add"
                title="@lang('cms-favorites::site.В избранное')"
        >
            <span class="button__icon icon icon--favorite">
                @svg('common', 'heart-stroke', [20, 16])
            </span>
        </button>
    @endif
</div>
