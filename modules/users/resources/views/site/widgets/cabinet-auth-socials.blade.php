@php
    /**
     * @var $socials array
     * @var $redirect string
     */
@endphp

<div class="text _fz-xxxs _text-center _color-faint-strong _mb-sm">@lang('cms-users::site.или войти с помощью')</div>

<div class="_grid _grid--2 _items-center _spacer _spacer--xs _mb-xs">
    @foreach($socials as $key => $name)
        <div class="_cell _flex">
            <a href="{{ route('auth.socialite', [$key, 'redirect' => $redirect]) }}"
               class="button button--theme-transparent-bordered _control-height-md _control-space-xs _b-r-sm _flex-grow"
               rel="nofollow"
               title="@lang('cms-users::site.Связать с :social', ['social' => $name])"
            >
                <span class="button__text">
                    {{ $key }}
                </span>
                   <span class="button__icon button__icon--right">
                     @svg('socials', $key, 20)
                </span>
            </a>
        </div>
    @endforeach
</div>
