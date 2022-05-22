@php
    /**
     * @var $socials array
     */
@endphp
<ul class="socials-list list">
    @if(!empty($socials['telegram']))
        <li class="socials-list__item">
            <a class="socials-list__link"
               href="{{ $socials['telegram'] }}"
               target="_blank"
               rel="nofollow"
               title="Telegram"
            >
            <span class="icon icon--social icon--social-telegram">
                @svg('socials', 'telegram-stroke', [18, 15])
            </span>
            </a>
        </li>
    @endif
    @if(!empty($socials['viber']))
        <li class="socials-list__item">
            <a class="socials-list__link"
               href="{{ $socials['viber'] }}"
               target="_blank"
               rel="nofollow"
               title="Viber"
            >
            <span class="icon icon--social icon--social-viber">
                @svg('socials', 'viber-stroke', [15, 16])
            </span>
            </a>
        </li>
    @endif
</ul>
