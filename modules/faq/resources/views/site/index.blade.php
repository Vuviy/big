@extends('cms-ui::layouts.main', ['containerModification' => 'lg'])

@php
    /**
     * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\Faq\Models\FaqGroup[]|\WezomCms\Faq\Models\FaqQuestion[]
     */
$limit = settings('faq.site.limit', 10);
@endphp

@section('content')
    <div class="section section--off-b-lg">
        <div class="container container--lg">
            <div class="text _fz-xxl _fw-bold">{{ SEO::getH1() }}</div>

            @if($result->isNotEmpty())
                <div class="tabs"
                     x-data="app.alpine.tabs({ container: 'tabsContainer', nowOpen: 'accordion-{{ 0 }}' })"
                     x-init="$watch('nowOpen', () => setTimeout(() => $parent.resize(), 300)); moveUnderline()"
                >
                    <div class="tabs__header"
                         x-ref="tabsHeader"
                    >
                        <div class="tabs__header-inner">
                            @foreach($result as $key => $group)
                                <button class="tabs__button button"
                                        type="button"
                                        @click="open('accordion-{{ $loop->index }}')"
                                        :class="{ 'is-active': isOpen('accordion-{{ $loop->index }}') }"
                                        x-ref="button-accordion-{{ $loop->index }}"
                                >
                                <span class="button__text">
                                    {{ $group->name }}
                                </span>
                                </button>
                            @endforeach
                        </div>
                        <div class="tabs__bottom-line" x-ref="underline"></div>
                    </div>
                    <div class="tabs__body"
                         x-ref="tabsContainer"
                    >
                        <div class="tabs__body-inner">
                            @foreach($result as $key => $group)
                                <div class="tabs__block"
                                     x-ref="accordion-{{ $loop->index }}"
                                     x-show="isOpen('accordion-{{ $loop->index }}')" style="display: none"
                                >
                                    <div class="{{ 'js-questions-list' . $group->id }} _mb-xs">
                                        @include('cms-faq::site.partials.faq-list', ['questions' => $group->faqQuestions->take($limit)])
                                    </div>
                                    @if($group->faqQuestions->count() > $limit)
                                        <div class="_flex _justify-center">
                                            <button class="button button--theme-transparent _control-height-md _control-padding-xs _control-space-md"
                                                    type="button"
                                                    data-load-more="{{ json_encode([
                                                    'route' => route('faq.load-more', ['id' => $group->id, 'page' => 2]),
                                                    'appendTo' => '.js-questions-list' . $group->id,
                                                    'replaceRoute' => false
                                                 ], JSON_THROW_ON_ERROR) }}"
                                            >
                                                <span class="button__icon button__icon--left">
                                                    @svg('common', 'arrow-update', [23, 23])
                                                </span>
                                                <span class="button__text">
                                                    @lang('cms-core::site.Показать еще')
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                @emptyResult
            @endif
        </div>
    </div>
@endsection
