@php
    /**
     * @var $branches \Illuminate\Database\Eloquent\Collection|\WezomCms\Branches\Models\Branch[]
     */
@endphp
<div class="container">
    <h1>{{ SEO::getH1() }}</h1>
    <div class="grid">
        @foreach($branches as $branch)
            <div class="gcell">
                <div>
                    <div>{{ $branch->name }}</div>
                    <div>
                        <div class="grid">
                            @if($branch->address)
                                <div class="gcell">
                                    <div>@lang('cms-branches::site.Адрес')</div>
                                    <div>{{ $branch->address }}</div>
                                </div>
                            @endif
                            @if($branch->phones)
                                <div class="gcell">
                                    <div>@lang('cms-branches::site.Телефон')</div>
                                    <div>
                                        @foreach($branch->phones as $phone)
                                            <a href="tel:{{ preg_replace('/[^\d\+]/', '', $phone) }}">{{ $phone }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($branch->email)
                                <div class="gcell">
                                    <div>@lang('cms-branches::site.Email')</div>
                                    <div>
                                        <a href="mailto:{{ $branch->email }}">{{ $branch->email }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="gglm gglm--small js-import" data-gglm data-no-xhr="true"
                         data-options="{{ json_encode($branch->map) }}">
                        <div class="gglm__display" data-gglm-display></div>
                        <div class="gglm__overlay js-init" data-gglm-stub
                             data-lozad="{{ url('assets/css/static/pic/google-map-overlay.jpg') }}">
                            <div class="gglm__overlay-text">
                                <svg viewBox="0 0 20 32" width="20" height="32">
                                    <use xlink:href="{{ url('assets/images/sprites/icons.svg#tap') }}"></use>
                                </svg>
                                <div>
                                    <span class="_i-mobile">@lang('cms-branches::site.Нажмите')</span>
                                    <span class="_i-desktop">@lang('cms-branches::site.Кликните')</span>
                                    <span>@lang('cms-branches::site.для отображения карты')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
