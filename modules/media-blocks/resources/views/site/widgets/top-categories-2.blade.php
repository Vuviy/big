<?php
/**
 * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\MediaBlocks\Models\MediaBlock[]
 */
?>

<div class="section section--bg-base-strong section--off-t-md section--off-b-md">
    <div class="container">
        <div class="text _fz-xl _fw-bold _color-white _mb-lg">
            @lang('cms-media-blocks::site.Скидки на гаджеты')
        </div>
        <div class="_grid _spacer _spacer--sm">
            @foreach($result as $card)
                @if($loop->iteration <= 4)
                    <div class="_cell _cell--12 _sm:cell--6 _md:cell--4 _df:cell--3">
                        @include('cms-ui::partials.cards.discount-card', [
                            'obj' => $card,
                            'classes' => 'discount-card--type-1 discount-card--stretch'
                        ])
                    </div>
                @else
                    <div class="_cell _cell--12 _sm:cell--6 _md:cell--4 _df:cell--6">
                        @include('cms-ui::partials.cards.discount-card', [
                            'obj' => $card,
                            'classes' => 'discount-card--type-2 discount-card--stretch'
                        ])
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
