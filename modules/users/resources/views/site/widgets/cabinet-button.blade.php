@php
    /**
     * @var $user \WezomCms\Users\Models\User|null
     */
@endphp
@auth
    <a class="cabinet-link" href="{{ route('cabinet') }}" title="@lang('cms-users::site.Перейти в личный кабинет')">
        @svg('common', 'user', [13,13], 'cabinet-link__icon icon icon--size-xs _mr-xs')
        <span class="cabinet-link__text">
            @lang('cms-users::site.Личный кабинет')
        </span>
    </a>
@else
    <div class="cabinet-link"
         x-data="app.alpine.openModal('users.auth-modal')"
         @click="open"
         @mouseenter="open"
    >
        @svg('common', 'user', [13,13], 'cabinet-link__icon icon icon--size-xs _mr-xs')
        <span class="cabinet-link__text">
            @lang('cms-users::site.Вход / Регистрация')
        </span>
    </div>
@endauth
