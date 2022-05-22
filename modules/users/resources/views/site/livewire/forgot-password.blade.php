<form wire:submit.prevent="submit">
    <div class="_grid _grid--1 _spacer _spacer--xs _mb-xs">
        <div class="_cell">
            @component('cms-ui::components.form.input', [
                'name' => 'email',
                'attributes' => [
                    'wire:model.lazy=email',
                    'wire:key=email',
                    'autocomplete=email',
                ],
                'label' => __('cms-users::site.Email'),
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'email',
                'errors' => $errors
            ])@endcomponent
        </div>
    </div>

    <div class="_flex _mb-sm">
        <button type="submit" class="button button--theme-yellow _control-height-md _b-r-sm _flex-grow">
            <span class="button__text">@lang('cms-users::site.Получить пароль')</span>
        </button>
    </div>

    <div class="_flex _justify-center _mb-sm">
        <div class="link link--theme-gray link--no-decoration" @click="open('auth')">@lang('cms-users::site.Я вспомнил пароль')</div>
    </div>
</form>
