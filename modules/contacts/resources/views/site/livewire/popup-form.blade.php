@php
    /**
     * @var $name string|null
     * @var $email string|null
     * @var $phone string|null
     * @var $comment string|null
     * @var $agree string|null
     */
@endphp
<div class="modal-content">
    <div>@lang('cms-contacts::site.Форма обратной связи')</div>
    <form wire:submit.prevent="submit">
        <div>
            <input type="text"
                   class="@if($errors->has('name')) has-error @elseif($name) is-valid @endif"
                   wire:model="name">
            <label class="@if($name) freeze @endif" for="name">
                @lang('cms-contacts::site.Имя')*
            </label>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <input type="email"
                   wire:model="email"
                   class="@if($errors->has('email')) has-error @elseif($email) is-valid @endif">
            <label class="@if($email) freeze @endif" for="email">
                @lang('cms-contacts::site.E-mail')*
            </label>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <x-ui-phone-input :value="$phone" :label="__('cms-contacts::site.Телефон')" />

        <div>
            <textarea wire:model="comment"
                      rows="3"
                      name="comment"
                      class="@if($errors->has('comment')) has-error @elseif($comment) is-valid @endif"></textarea>
            <label for="comment">
                @lang('cms-contacts::site.Текст')*
            </label>
            @error('comment') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>
                <input type="checkbox" name="agree" wire:model="agree" value="1">

                <span class="@if($errors->has('agree')) has-error @elseif($agree) is-valid @endif">
                        <span>
                            @lang('cms-contacts::site.Согласен на обработку персональных данных')
                        </span>
                    </span>
            </label>
            @error('agree') <span>{{ $message }}</span> @enderror
        </div>
        <button type="submit">
            <span>@lang('cms-vacancies::site.Отправить')</span>
        </button>
    </form>
</div>
