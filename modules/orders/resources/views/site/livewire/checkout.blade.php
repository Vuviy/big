@php
    /**
     * @var $backUrl string
     * @var $cart array
     * @var $delivery \WezomCms\Orders\Models\Delivery|null
     * @var $hasUnavailableProducts bool
     */
@endphp
<div class="section section--off-t-md section--off-b-lg">
    <div class="container container--lg">
        <div class="_grid _spacer _spacer--md">
            <div class="_cell _cell--12 _md:cell--6 _df:cell--7 _lg:pr-xxl">
                <form wire:submit.prevent="send" id="checkout-form">
                    <div class="text _fz-xxl _fw-bold _color-black _mb-df _lg:mb-xl"> {{ SEO::getH1() }} </div>
                    @include('cms-orders::site.partials.checkout.contact-information')
                    @include('cms-orders::site.partials.checkout.delivery')
                    @include('cms-orders::site.partials.checkout.payment')
                    @include('cms-orders::site.partials.checkout.communication')
                </form>
            </div>
            <div class="_cell _cell--12 _md:cell--6 _df:cell--5 _lg:pl-md">
                @include('cms-orders::site.partials.checkout.result')
            </div>
        </div>
    </div>
</div>
