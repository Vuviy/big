
<div class="about-advantages">
    <div class="container container--def">
        <div class="about-advantages__title">
            @lang('cms-advantages::site.Our favorite credo is a convenient and reliable service')

        </div>
        <div class="about-advantages__grid">
            @foreach($result as $item)
                <div class="about-advantages__item">
                    <div class="about-advantages__item-title">
                        <div class="about-advantages__item-icon">
                            @svg('features', $item->icon)
                        </div>
                        <span>
                            {{ $item->name }}
                        </span>
                    </div>
                    <div class="about-advantages__item-text">
                        {{ $item->description }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
