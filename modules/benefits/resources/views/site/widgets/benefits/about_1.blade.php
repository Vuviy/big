<div class="about-benefits">
    <div class="container container--def">
        <div class="about-benefits__title">
            @lang('cms-benefits::site.Bigpayda leaders in Apple Premium sales and services')
        </div>
        <div class="about-benefits__grid">
            @foreach($result as $item)
                <div class="about-benefits__item">
                    <div class="about-benefits__item-icon">
                        @svg('features', $item->icon)
                    </div>
                    <div>
                        <div class="about-benefits__item-title">
                            {{ $item->name }}
                        </div>
                        <div class="about-benefits__item-text">
                            {{ $item->description }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
