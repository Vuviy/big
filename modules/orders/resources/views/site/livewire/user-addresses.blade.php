@php
    /**
     * @var $user \WezomCms\Users\Models\User
     * @var $showEditForm bool
     * @var $showCreateForm bool
     * @var $addresses \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\UserAddress[]
     */
@endphp
<div>
    <strong>@lang('cms-orders::site.Адреса доставки')</strong>
    @if($showEditForm || $showCreateForm)
        @include('cms-orders::site.partials.edit-address-form')
    @elseif($addresses->isNotEmpty())
        <div>
            <ol>
                @foreach($addresses as $address)
                    <li>
                        <div>
                            <div>
                                <div>{{ $address->full_address }}</div>
                                <div>
                                    @if($address->primary)
                                        <div>
                                            @lang('cms-orders::site.Основной адрес')
                                        </div>
                                    @else
                                        <div>
                                            <div>
                                                <div wire:click="setPrimary({{ $address->id }})">
                                                    <input type="checkbox"
                                                           value="{{ $address->id }}">
                                                    <span>@lang('cms-orders::site.Сделать основным')</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <button wire:click="startEditAddress({{ $address->id }})">@lang('cms-orders::site.Редактировать')</button>
                            <button wire:click="deleteAddress({{ $address->id }})">
                                &Cross;
                            </button>
                        </div>
                    </li>
                @endforeach
            </ol>
            <div>
                <button wire:click="openCreateAddressForm">
                    +
                    <span>@lang('cms-orders::site.Добавить адрес')</span>
                </button>
            </div>
        </div>
    @else
        <article>
            <div>
                <div>
                    <p>@lang('cms-orders::site.Вы пока не создали ни одного адреса')</p>
                    <button data-cabinet-address
                            wire:click="openCreateAddressForm">
                        +
                        <span>@lang('cms-orders::site.Добавить адрес доставки')</span>
                    </button>
                </div>
            </div>
        </article>
    @endif
</div>
