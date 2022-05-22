@php
    /**
     * @var $result \Illuminate\Support\Collection|\WezomCms\OurTeam\Models\Employee[]
     */
@endphp

<div class="team">
    <div class="container container--md _df:px-md">
        <div class="team__title">
            @lang('cms-about::site.Наша Команда')
            @lang('cms-about::site.Азиатские IT-компании могут догнать Apple в части инноваций, но они всё так же бесконечно близки в том, что касается пользовательского опыта')
        </div>
    </div>

    <div class=" _my-df _md:py-df _df:mt-lg _df:pt-lg _lg:mb-none _lg:pb-none">
        <div class="team__wrapper team__wrapper--desktop">
            @foreach($result->chunk(3) as $chunk)
                <div class="team__grid {{$loop->first ? 'team__grid--left' : 'team__grid--right'}}">
                    @foreach($chunk as $employee)
                        <div class="team__item">
                            <div class="team__item-decor">
                                @svg('common', 'team-item-decor', [26, 30])
                            </div>
                            <div class="team__item-grid">
                                <div>
                                    <div class="team__item-title">{{ $employee->name }}</div>
                                    <div class="team__item-position">{{ $employee->position }}</div>
                                </div>
                                @if($employee->imageExists())
                                    <div class="team__item-image-wrapper _flex-noshrink">
                                        <div class="team__item-image">
                                            <img src="{{ $employee->getImageUrl() }}" alt="{{ $employee->name }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="team__item-description">
                                <div class="team__item-decor">
                                    @svg('common', 'team-item-decor', [26, 30])
                                </div>
                                <div class="team__item-title">{{ $employee->name }}</div>
                                <div class="team__item-position">{!! $employee->description !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="team__wrapper team__wrapper--mobile">
            <div class="team__grid">
                @foreach($result as $employee)
                    <div class="team__item">
                        <div class="team__item-decor">
                            @svg('common', 'team-item-decor', [26, 30])
                        </div>
                        <div class="team__item-grid">
                            <div>
                                <div class="team__item-title">{{ $employee->name }}</div>
                                <div class="team__item-position">{{ $employee->position }}</div>
                            </div>
                            @if($employee->imageExists())
                                <div class="team__item-image-wrapper _flex-noshrink">
                                    <div class="team__item-image">
                                        <img src="{{ $employee->getImageUrl() }}" alt="{{ $employee->name }}">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="team__item-description">
                            <div class="team__item-decor">
                                @svg('common', 'team-item-decor', [26, 30])
                            </div>
                            <div class="team__item-title">{{ $employee->name }}</div>
                            <div class="team__item-position">{!! $employee->description !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="team__decor">
        <img src="{{ asset('images/about/banner-decor.svg') }}" alt="">
    </div>
</div>
