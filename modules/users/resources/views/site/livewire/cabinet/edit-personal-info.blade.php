<div>
    <form wire:submit.prevent="submit" class="cabinet-form js-dmi">
        <div class="cabinet-form__grid">
            @component('cms-ui::components.form.input', [
            'name' => 'name',
            'attributes' => [
                'wire:model.lazy=name',
                'wire:key=name'
            ],
            'label' => __('cms-users::site.Имя'),
            'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
            'type' => 'text'
        ])@endcomponent
        @component('cms-ui::components.form.input', [
            'name' => 'surname',
            'attributes' => [
                'wire:model.lazy=surname',
                'wire:key=surname'
            ],
            'label' => __('cms-users::site.Фамилия'),
            'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
            'type' => 'text'
        ])@endcomponent
        @component('cms-ui::components.form.input', [
            'name' => 'birthday',
            'attributes' => [
                'wire:model.lazy=birthday',
                'wire:key=birthday'
            ],
            'label' => __('cms-users::site.Дата рождения'),
            'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
            'type' => 'text'
        ])@endcomponent
        </div>
        <div class="_grid _grid--1 _xs:grid--auto _spacer _spacer--sm _pt-sm">
            <div class="_cell">
                <button type="submit" class="button button--theme-transparent-bordered _b-r-sm _control-height-md _px-md _fz-sm {{ $disabled ? 'is-disabled' : '' }}" @if($disabled) disabled @endif>
                    @lang('cms-users::site.Сохранить')
                </button>
            </div>
        </div>
    </form>
</div>
