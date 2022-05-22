<div class="_mb-md _lg:mb-df">
    <div class="text _fz-xl _fw-bold">
        @lang('cms-catalog::site.Характеристики')
    </div>
</div>
@if(count($specifications))
    <div class="specs _mb-md _lg:mb-df">
        @foreach($specifications as $name => $specification)
            <div class="specs__item">
                <div class="specs__cell specs__cell--left text _fz-xs">{{ $name }}</div>
                <div class="specs__cell specs__cell--right text _fz-xs _color-pantone-gray">{{ collect($specification['values'])->pluck('name')->implode(', ') }}</div>
            </div>
        @endforeach
    </div>
@endif

<div class="text _fz-xs">
    @lang('cms-catalog::site.Характеристики') {{ $product->name }} @lang('cms-catalog::site.и комплектация товара могут изменяться производителем без уведомления').
    @lang('cms-catalog::site.Проверяйте характеристики товара непосредственно перед заказом')!
</div>
