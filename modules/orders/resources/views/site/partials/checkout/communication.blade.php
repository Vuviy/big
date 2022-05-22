@php
    /** @var $communications \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\Communication[] */
@endphp

<div class="_mb-md">
    <div class="text _fz-xxxs _color-faint-strong _mb-xs">
        @lang('cms-orders::site.communication.Convenient way of communication')
    </div>
    <div class="_grid _spacer _spacer--sm _mb-none">
        @foreach($communications as $key => $value)
            <div class="checkbox checkbox--default {{!$loop->last ? '_mr-sm _df:mr-df' : null}}">
                <input class="checkbox__control"
                       type="checkbox"
                       id="user.communications-{{ $key }}"
                       name="user.communications.{{ $key }}"
                       wire:model.debounce.150ms="user.communications.{{ $key }}"
                       wire:key="user.communications.{{ $key }}"
                       wire:loading.attr="disabled"
                       value="{{ $key }}"
                >
                <label class="checkbox__label" for="user.communications-{{$key}}">
                        <span class="checkbox__checkmark">
                            @svg('common', 'checkmark', [12,12])
                        </span>
                    <span class="checkbox__text _fz-xs _color-pantone-gray">{{$value}}</span>
                </label>
            </div>
        @endforeach
    </div>
</div>

<div>
    @component('cms-ui::components.form.textarea', [
        'name' => 'comment',
        'attributes' => [
            'wire:model.lazy=comment',
            'wire:key=comment'
        ],
        'label' => __('cms-orders::site.checkout.Комментарий к заказу'),
        'classes' => 'form-item--theme-base-weak _control-padding-xxs',
        'type' => 'text'
    ])@endcomponent
</div>
