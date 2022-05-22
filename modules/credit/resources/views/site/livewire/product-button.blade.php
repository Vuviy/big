@php
    /**
     * @var $text string
     * @var $banks \Illuminate\Support\Collection|\WezomCms\Credit\Bank[]
     * @var $monthCount array
     * @var $availableMonthCount \Illuminate\Support\Collection|\Illuminate\Support\Collection[]
     */
@endphp

<div class="_flex _flex-grow">
    <button type="button"
            class="button button--theme-gray _b-r-sm _control-height-md _control-padding-xs _control-space-xs _flex-grow"
            wire:click="addToCart"
    >
        <span class="button__text">@lang('cms-orders::site.Купить в кредит')</span>
    </button>
</div>
