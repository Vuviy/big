<?php
/** @var $settings array */
?>

@extends('cms-ui::layouts.main', ['containerModification' => 'lg'])

@section('content')
    <div class="section _pb-lg _df:pb-xxl">
        <div class="container container--lg">
            <div class="text _fz-xxl _fw-bold _mb-xs">{{ SEO::getH1() }}</div>
            <div class="_grid _spacer _spacer--sm">
                <div class="_cell _cell--12 _df:cell--6 _lg:cell--5">
                    <div class="_grid">
                        <div class="_cell _cell--12 _df:cell--12 _lg:cell--9 _lg:pr-sm">
                            <hr class="separator separator--horizontal separator--offset-sm">
                            @foreach($branches as $branch)
                                @if(isset($branch->address))
                                    <div class="text _fz-def _fw-bold">
                                        @lang('cms-contacts::site.Магазин'): {{ $branch->address }}
                                    </div>
                                    <hr class="separator separator--horizontal separator--offset-sm">
                                @endif
                            @endforeach
                            @if(!empty($settings['site']['work_time']))
                                <div class="text _fz-def _fw-bold">
                                    @lang('cms-contacts::site.График работы'): {{ $settings['site']['work_time'] }}
                                </div>
                                <hr class="separator separator--horizontal separator--offset-sm">
                            @endif
                            @if(!empty($settings['phones']['social_phone']))
                                <div class="_grid _spacer _spacer--xs _pt-sm">
                                    <div class="_cell _cell--auto">
                                        <div class="text _fz-def _fw-bold _lh-lg">
                                            {{ $settings['phones']['social_phone'] }}<br>
                                            @if(!empty($settings['phones']['phones']))
                                                {!! nl2br($settings['phones']['phones']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="_cell _cell--auto _pt-xs">
                                        @widget('contacts:phone-social-links')
                                    </div>
                                </div>
                            @endif
                            @if(!empty($settings['phones']['free_phone']))
                                <div class="_grid _items-center _spacer _spacer--xs _mb-md">
                                    <div class="_cell _cell--auto">
                                        <div class="text _fz-def _fw-bold _lh-lg">
                                            {{ $settings['phones']['free_phone'] }}
                                        </div>
                                    </div>
                                    <div class="_cell _cell--auto">
                                        <div class="text _color-pantone-gray _fz-xxxs">
                                            @lang('cms-contacts::site.Бесплатно по Казахстану')
                                        </div>
                                    </div>
                                </div>
                                <hr class="separator separator--horizontal separator--offset-sm">
                            @endif
                            <livewire:contacts.form/>
                        </div>
                    </div>
                </div>
                <div class="_cell _cell--12 _df:cell--6 _lg:cell--7">
                    <script data-gmap-data="1" type="application/json">@json($map)</script>
                    <div wire:ignore class="map js-dmi" data-gmap="locations" data-options='@json($map)' ata-gmap-id="1">
                        <div class="map__display" data-gmap-display></div>
                        @foreach($map as $locationInfo)
                            <template data-info-window="{{ $loop->index }}">
                                <div class="_color-white">
                                    <div class="_grid _grid--1 _spacer _spacer--xs">
                                        @if ($locationInfo['info']['name'])
                                            <div class="_cell">
                                                <div class="text _fz-sm _color-pantone-lemon">
                                                    {!! $locationInfo['info']['name'] !!}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($locationInfo['info']['address'])
                                            <div class="_cell">
                                                <div class="text _fz-xs">
                                                    {!! $locationInfo['info']['address'] !!}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($locationInfo['info']['phones'])
                                            <div class="_cell">
                                                <div class="info-window__phones">
                                                    @foreach($locationInfo['info']['phones'] as $phone)
                                                        <a class="link link--theme-yellow _color-white _no-underline"
                                                           href="tel:{{ $phone }}">
                                                            {{ $phone }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if ($locationInfo['info']['schedule'])
                                            <div class="_cell">
                                                <div class="text">
                                                    {!! $locationInfo['info']['schedule'] !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </template>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
