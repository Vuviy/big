<div>
    <form wire:submit.prevent="submit" class="js-dmi">
        <div class="cabinet-form__grid cabinet-form__grid--alternative">
            @component('cms-ui::components.form.input', [
            'name' => 'email',
            'attributes' => [
                'wire:model.lazy=email',
                'wire:key=email'
            ],
            'label' => __('cms-users::site.E-mail'),
            'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
            'type' => 'email'
        ])@endcomponent
            <div class="form-control">
                <label class="form-item__label _text _fz-xxxs _color-faint-strong">@lang('cms-users::site.Телефон')</label>
                <x-ui-phone-input :value="$phone" name="phone" wire:model.defer="phone" wire:key="phone"/>
            </div>
            <div class="form-control _flex _flex-column">
                <label class="form-item__label _text _fz-xxxs _color-faint-strong">@lang('cms-users::site.cabinet.Удобный способ связи')</label>
                <div class="_flex _items-center _my-auto">
                    @foreach($communicationTypes as $key => $type)
                        <div class="checkbox checkbox--default {{!$loop->last ? '_mr-sm _df:mr-df' : null}}">
                                <input class="checkbox__control"
                                       type="checkbox"
                                       id="{{$key}}"
                                       name="communication[]"
                                       wire:model.debounce.150ms="communication"
                                       wire:key="{{$key}}"
                                       value="{{$key}}"
                                >
                                <label class="checkbox__label" for="{{$key}}">
                        <span class="checkbox__checkmark">
                            @svg('common', 'checkmark', [12,12])
                        </span>
                                    <span class="checkbox__text _fz-xs _color-black">{{$type}}</span>
                                </label>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="_grid _grid--1 _xs:grid--auto _spacer _spacer--sm _pt-md">
            <div class="_cell">
                <button type="submit" class="button button--theme-transparent-bordered _b-r-sm _control-height-md _px-md _fz-sm {{ $disabled ? 'is-disabled' : '' }}" @if($disabled) disabled @endif>
                    @lang('cms-users::site.Сохранить')
                </button>
            </div>
        </div>
    </form>
</div>
