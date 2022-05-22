@php
/**
 * @var $product \WezomCms\Catalog\Models\Product
 */
@endphp

@if($showFavoritesCheck ?? false)
    <label class="checkbox checkbox--default _mb-sm">
        <input class="checkbox__control"
               type="checkbox"
               wire:model="selected" value="{{ $product->favorablePayload() }}"
        >
        <span class="checkbox__label">
            <span class="checkbox__checkmark">
                @svg('common', 'checkmark', [12,12])
            </span>
        </span>
    </label>
@else
    <livewire:favorites.product-list-button :favorable="$product" :key="uniqid($product->id)" />
@endif
