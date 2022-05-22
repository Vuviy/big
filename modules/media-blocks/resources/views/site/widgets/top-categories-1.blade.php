<?php
/**
 * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\MediaBlocks\Models\MediaBlock[]
 */
?>

<div class="section section--off-t-xs section--off-b-sm _pb-none">
    <div class="container container--full _p-none">
        <div class="grid grid--top-categories _grid _spacer _spacer--xs _md:spacer--sm _mb-none _px-sm">
            @foreach($result as $card)
                <div class="grid__cell @if($card->fileExists('video')) _md:show @endif _cell _cell--12 _sm:cell--6 _md:cell--4 _df:cell--3 ">
                    @if($card->fileExists('video'))
                        @include('cms-ui::partials.cards.media-card', [
                            'obj' => $card,
                            'type' => 'video',
                            'classes' => 'media-card--type-2 media-card--stretch'
                        ])
                    @else
                        @include('cms-ui::partials.cards.media-card', [
                            'obj' => $card,
                            'type' => 'image',
                            'classes' => 'media-card--type-1 media-card--stretch'
                        ])
                    @endif
                </div>
            @endforeach
        </div>
        <div class="_grid _md:hide _pt-xs">
            @foreach($result as $card)
                @if($card->fileExists('video'))
                    <div class="_cell _cell--12">
                        @include('cms-ui::partials.cards.media-card', [
                            'obj' => $card,
                            'type' => 'video',
                            'classes' => 'media-card--type-2 media-card--stretch media-card--no-border'
                        ])
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
