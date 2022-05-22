@php
    /**
     * @var $showEditForm bool
     * @var $showCreateForm bool
     * @var $address \WezomCms\Orders\Models\UserAddress
     * @var $editedRow array
     */
@endphp
<div>
    <article>
        <form wire:submit.prevent="save">
            <div>
                @if($showEditForm)
                    @lang('cms-orders::site.Редактирование адреса')
                @else
                    @lang('cms-orders::site.Добавление адреса')
                @endif
            </div>
            <div>
                <div>
                    <input type="text"
                           name="editedRow.city"
                           wire:model="editedRow.city"
                           class="@if($errors->has('editedRow.city')) has-error @elseif($editedRow['city']) is-valid @endif">
                    <label class="@if($editedRow['city']) freeze @endif" for="editedRow.city">
                        @lang('cms-orders::site.Город или населенный пункт')
                    </label>
                    @error('editedRow.city') <span>{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="text"
                           name="editedRow.street"
                           wire:model="editedRow.street"
                           class="@if($errors->has('editedRow.street')) has-error @elseif($editedRow['street']) is-valid @endif">
                    <label class="@if($editedRow['street']) freeze @endif" for="editedRow.street">
                        @lang('cms-orders::site.Улица')
                    </label>
                    @error('editedRow.street') <span>{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="text"
                           name="editedRow.house"
                           wire:model="editedRow.house"
                           class="@if($errors->has('editedRow.house')) has-error @elseif($editedRow['house']) is-valid @endif">
                    <label class="@if($editedRow['house']) freeze @endif" for="editedRow.house">
                        @lang('cms-orders::site.Номер дома')
                    </label>
                    @error('editedRow.house') <span>{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="number"
                           name="editedRow.room"
                           min="1"
                           wire:model="editedRow.room"
                           class="@if($errors->has('editedRow.room')) has-error @elseif($editedRow['room']) is-valid @endif">
                    <label class="@if($editedRow['room']) freeze @endif" for="editedRow.room">
                        @lang('cms-orders::site.Квартира')
                    </label>
                    @error('editedRow.room') <span>{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <button wire:click="cancel">
                    &Cross;
                    <span>@lang('cms-orders::site.Отменить')</span>
                </button>
                <button wire:click="save">
                    &Vee;
                    <span>@lang('cms-orders::site.Сохранить адрес')</span>
                </button>
            </div>
        </form>
    </article>
</div>
