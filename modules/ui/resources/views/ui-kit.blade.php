@extends('cms-ui::layouts.base')

@section('main')
    <div class="container">
        <div class="ui-kit-block" id="titles">
            <div class="ui-kit-block__title">
                Titles
            </div>
            <div class="ui-kit-block__content">
                <div class="text _fz-xxl _mb-md">
                    Text XXL
                </div>
                <div class="text _fz-xl _mb-md">
                    Text XL
                </div>
                <div class="text _fz-lg _mb-md">
                    Text LG
                </div>
                <div class="text _fz-def _mb-md">
                    Text DEF
                </div>
                <div class="text _fz-sm _mb-md">
                    Text SM
                </div>
                <div class="text _fz-xs _mb-md">
                    Text XS
                </div>
            </div>
        </div>
        <div class="ui-kit-block" id="fonts">
            <div class="ui-kit-block__title">
                Fonts
            </div>
            <div class="ui-kit-block__content">
                <div class="_flex">
                    <div class="text _fz-def _mr-sm">
                        Name: <code>Google Sans</code>
                    </div>
                    <div class="text _fz-def">
                        Var: <code>$font-family-default</code>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui-kit-block" id="colors">
            <div class="ui-kit-block__title">
                Colors
            </div>
            <div class="ui-kit-block__content">
                @include('cms-ui::partials.demo.color-list-all')
            </div>
        </div>
        <div class="ui-kit-block" id="icons">
            <div class="ui-kit-block__title">
                Icons
            </div>
            <div class="ui-kit-block__content">
                @include('cms-ui::partials.demo.svg-list-all')
            </div>
        </div>
        <div class="ui-kit-block" id="form">
            <div class="ui-kit-block__title">
                Form
            </div>
            <div class="ui-kit-block__content">
                <form>
                    <div class="_grid _grid--1 _md:grid--2 _spacer _spacer--sm">
                        <div class="_cell">
                            <div class="form-item form-item--theme-default form-item--input _control-height-lg _control-padding-sm" data-control>
                                <label for="name60b3c5e4890a0" class="form-item__label">Name</label>
                                <div class="form-item__body">
                                    <input class="form-item__control"
                                           type="text"
                                           name="name"
                                           id="name60b3c5e4890a0"
                                           wire:model.defer="name"
                                           spellcheck="true"
                                           inputmode="text"
                                           data-field
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="_cell">
                            <div class="form-item form-item--select2 form-item--theme-default _control-height-lg _control-padding-sm">
                                <label for="choose_region" class="form-item__label">
                                    <span>Оберіть регіон</span>
                                </label>
                                <div class="form-item__body js-import" data-select2 data-initialize-select2="{{ json_encode((object)['Factory' => 'DefaultSelect2']) }}">
                                    <select class="form-item__control form-item__control--select2 select2-hidden-accessible"
                                            id="choose_region"
                                            name="choose_region"
                                            wire:model="choose_region"
                                            wire:key="choose_region"
                                    >
                                        @for($i = 0; $i < 4; $i++)
                                            <option value="demo{{$i}}">Demo Option {{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('choose_region')
                                <span class="form-item__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="ui-kit-block" id="checkbox">
            <div class="ui-kit-block__title">
                Checkbox / toggle switch / radio button
            </div>
            <div class="ui-kit-block__content">
                <form>
                    <div class="_flex _flex-wrap _spacer _spacer--df">
                        <div class="_cell">
                            <div class="checkbox  checkbox--theme-default ">
                                <input class="checkbox__control" type="checkbox" name="demo_checkbox" id="demo_checkbox" checked>
                                <label class="checkbox__label" for="demo_checkbox">
                                    <span class="checkbox__checkmark">
                                        @svg('common', 'checkmark', [12,12])
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="_cell">
                            <div class="toggle-switch  toggle-switch--theme-default ">
                                <input class="toggle-switch__control" type="checkbox" name="demo_toggle-switch" id="demo_toggle-switch" checked>
                                <label class="toggle-switch__label" for="demo_toggle-switch">
                                    <span class="toggle-switch__checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="_cell">
                            <div class="_flex">
                                <div class="_mr-sm">
                                    <div class="radio-button  radio-button--theme-default ">
                                        <input class="radio-button__control" type="radio" name="demo_radio" id="1" checked="">
                                        <label class="radio-button__label" for="1">
                                            <span class="radio-button__checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <div class="radio-button  radio-button--theme-default ">
                                        <input class="radio-button__control" type="radio" name="demo_radio" id="2">
                                        <label class="radio-button__label" for="2">
                                            <span class="radio-button__checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="ui-kit-block" id="buttons">
            <div class="ui-kit-block__title">
                Buttons
            </div>
            <div class="ui-kit-block__content">
                <div class="_grid _grid--1 _md:grid--2 _spacer _spacer--sm">
                    <div class="_cell">
                        <div class="_flex _flex-wrap _items-center _spacer _spacer--df">
                            <div class="_cell">
                                <button class="button button--outline button--color-accent _control-height-xl _control-padding-lg">
                                    <span class="button__text">button outline</span>
                                    <span class="button__icon button__icon--right">
                                        @svg('common', 'arrow-top-right', [8,8])
                                    </span>
                                </button>
                            </div>
                            <div class="_cell">
                                <button class="button button--fill button--color-accent _control-height-xl _control-padding-lg">
                                    <span class="button__text">button outline</span>
                                    <span class="button__icon button__icon--right">
                                        @svg('common', 'arrow-top-right', [8,8])
                                    </span>
                                </button>
                            </div>
                            <div class="_cell">
                                <button class="button button--fill button--color-main _control-height-xl _control-padding-lg">
                                    <span class="button__text">button outline</span>
                                    <span class="button__icon button__icon--right">
                                        @svg('common', 'arrow-top-right', [8,8])
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
