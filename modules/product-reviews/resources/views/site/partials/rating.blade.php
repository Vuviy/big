<?php
/**
 * @var int $rating
 * @var ?string $classes
 */
?>
<div class="rating {{ $classes ?? '' }}">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= (int)round($rating))
            @svg('common', 'star', 12, 'rating__star is-active')
        @else
            @svg('common', 'star', 12,'rating__star')
        @endif
    @endfor
</div>
