<div>
    @include('cms-users::site.partials.edit-address-form')

    <button type="button" wire:click.prevent="add('{{ $i }}')" class="_flex _items-center _fz-sm _color-pantone-gray _fw-medium"><span class="_mr-xs">@lang('cms-users::site.Добавить ещё адрес')</span> @svg('common', 'plus-rounded', 20)</button>
    <div class="_grid _grid--1 _xs:grid--auto _spacer _spacer--sm _pt-sm">
        <div class="_cell">
            <button wire:click="save" {{ $submitDisabled ? 'disabled' : '' }} class="button button--theme-transparent-bordered _b-r-sm _control-height-md _px-md _fz-sm">@lang('cms-users::site.Сохранить')</button>
        </div>
    </div>
</div>
