<div class="_mb-md _lg:mb-df">
    <div class="text _fz-xl _fw-bold">
        @lang('cms-catalog::site.Аксессуары')
    </div>
</div>
<div class="_grid _grid--1 _sm:grid--2 _df:grid--3 _spacer _spacer--sm">
    @foreach($accessories as $accessory)
        <div class="_cell">
            @include('cms-catalog::site.partials.cards.product-card', ['item' => $accessory])
        </div>
    @endforeach
</div>
