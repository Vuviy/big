@php
/**
 * @var $title string|null
 * @var $url string|null
 */
@endphp
<div class="sticky-block sticky-block--top">
    <div class="share share--size-default _md:ml-auto">
        <div class="text _fz-xs _color-faint-strong">@lang('cms-ui::site.Поделиться в соцсетях')</div>
        <hr class="separator separator--horizontal separator--offset-sm">
        <ul class="share__grid list">
            <li class="share__item share__item--facebook">
                <a href="http://www.facebook.com/sharer.php?u={{ $url }}&quote={{ $title }}" class="share__link"
                   onclick="share(event, this);" target="_blank" rel="nofollow">
                    @svg('socials', 'facebook-share', [40, 40])
                </a>
            </li>
            <li class="share__item share__item--twitter">
                <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}" class="share__link"
                   onclick="share(event, this);" target="_blank" rel="nofollow">
                    @svg('socials', 'twitter-share', [40, 40])
                </a>
            </li>
            <li class="share__item share__item--telegram">
                <a href="https://t.me/share/url?url={{ $url }}&text={{ $title }}&to=" class="share__link"
                   onclick="share(event, this);" target="_blank" rel="nofollow">
                    @svg('socials', 'telegram-share', [40, 40])
                </a>
            </li>
            <li class="share__item share__item--linkedin">
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}&title={{ $title }}"
                   class="share__link" onclick="share(event, this);" target="_blank" rel="nofollow">
                    @svg('socials', 'linkedin-share', [40, 40])
                </a>
            </li>
        </ul>
    </div>
</div>
