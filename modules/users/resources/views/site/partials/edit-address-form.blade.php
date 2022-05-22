<div>
    <form wire:submit.prevent="save" class="cabinet-form js-dmi">
        @foreach($addresses as $key => $address)
            <div class="_my-sm">
                <div class="_mb-sm">
                    <div class="radio-button">
                        <input class="radio-button__control"
                               type="radio"
                               name="primary"
                               id="primary.{{$key}}"
                               value="{{ $key}}"
                               wire:model="primary"
                               wire:key="primary.{{$key}}"
                        >
                        <label class="radio-button__label" for="primary.{{$key}}">
                            <span class="radio-button__checkmark _mr-xs"></span>
                            <span class="radio-button__text text _fz-xs _color-faint-strong">
                       @lang('cms-users::site.cabinet.Сделать основным адресом доставки')
                    </span>
                        </label>
                    </div>
                </div>
                <div class="cabinet-form__grid">
                    <div>
                        <div class="form-item form-item--select2 _control-height-md _control-width-select _control-padding-xxs _fz-xs">
                            @php($inputId = uniqid('addresses.' . $key . '.locality_id'))
                            <div class="form-item__header">
                                <label for="{{ $inputId }}" class="form-item__label _text _fz-xxxs _color-faint-strong">
                                    @lang('cms-users::site.Населенный пункт')
                                </label>
                            </div>

                            <select
                                class="js-dmi js-select select-input"
                                name="addresses.{{$key}}.locality_id"
                                wire:model="addresses.{{$key}}.locality_id"
                                wire:key="locality_id"
                                id="{{ $inputId }}"
                            >
                                <option value="">@lang('cms-core::site.layout.Not set')</option>
                                @foreach($this->localities as $locality)
                                    <option value="{{ $locality->id }}">{{ $locality->city->name . ', ' . $locality->name }}</option>
                                @endforeach
                            </select>
                            @error('addresses.' . $key . '.locality_id')
                                <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div>
                        @component('cms-ui::components.form.input', [
                            'name' => 'addresses.'.$key.'.street',
                            'attributes' => [
                                'spellcheck' => true,
                                'wire:key' => 'street',
                                'wire:model.lazy=addresses.'.$key.'.street'
                            ],
                            'value' => $address['street'],
                            'label' => __('cms-users::site.Улица'),
                            'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                            'type' => 'text'
                        ])@endcomponent
                    </div>
                    <div class="cabinet-form__grid cabinet-form__grid--small">
                        <div>
                            @component('cms-ui::components.form.input', [
                                'name' => 'addresses.'.$key.'.house',
                                'attributes' => [
                                    'spellcheck' => true,
                                    'wire:key' => 'house',
                                    'wire:model.lazy=addresses.'.$key.'.house'
                                ],
                                'value' => $address['house'],
                                'label' => __('cms-users::site.Дом'),
                                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                                'type' => 'text'
                            ])@endcomponent
                        </div>
                        <div>
                            @component('cms-ui::components.form.input', [
                                'name' => 'addresses.'.$key.'.room',
                                'attributes' => [
                                    'spellcheck' => true,
                                    'wire:key' => 'room',
                                    'wire:model.lazy=addresses.'.$key.'.room'
                                ],
                                'value' => $address['room'],
                                'label' => __('cms-users::site.Квартира'),
                                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                                'type' => 'text'
                            ])@endcomponent
                        </div>
                        <div class="_flex _flex-column">
                            <label class="form-item__label _text _fz-xxxs _color-faint-strong _md:show">&nbsp;</label>
                            <button class="cabinet-form__remove-button _md:self-center _my-auto _fz-sm" wire:click.prevent="remove({{$key}})" title="@lang('cms-users::site.Удалить адрес')">
                                @svg('common', 'cross', [20, 20])
                                <span class="_fz-xs _color-pantone-gray _ml-xs _fw-medium">@lang('cms-users::site.Удалить адрес')</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="separator separator--theme-faint-weak separator--horizontal _my-sm">

        @endforeach
    </form>
</div>
