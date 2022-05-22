@php
    /**
     * @var $name string|null
     * @var $email string|null
     * @var $comment string|null
     */
@endphp
<div>
    <div class="text _fz-xxs _fw-bold _uppercase _mb-sm">
        @lang('cms-contacts::site.Форма обратной связи')
    </div>
    <form wire:submit.prevent="submit">
        <div class="_mb-sm">
            <div class="form-item form-item--theme-base-weak form-item--input _control-height-md _control-padding-xs
                @if($errors->has('name')) has-error @elseif($name) is-valid @endif"
            >
                <label for="name" class="form-item__label _fz-xxxs">
                    <span>@lang('cms-contacts::site.Ваше имя')</span>
                </label>
                <div class="form-item__body">
                    <input class="form-item__control"
                           type="text"
                           name="name"
                           spellcheck="true"
                           inputmode="text"
                           autocomplete="name"
                           wire:model.lazy="name"
                           wire:key="name" >
                </div>
                @error('name')
                    <span class="form-item__error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="_mb-sm">
            <div class="form-item form-item--theme-base-weak form-item--input _control-height-md _control-padding-xs
                @if($errors->has('email')) has-error @elseif($email) is-valid @endif"
            >
                <label for="email" class="form-item__label _fz-xxxs">
                    <span>@lang('cms-contacts::site.Эл. почта')</span>
                </label>
                <div class="form-item__body">
                    <input class="form-item__control"
                           type="email"
                           name="email"
                           id="email"
                           spellcheck="true"
                           inputmode="email"
                           autocomplete="email"
                           wire:model.lazy="email"
                           wire:key="email"
                    >
                </div>
                @error('email')
                    <span class="form-item__error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="_mb-sm">
            <div class="form-item form-item--theme-base-weak form-item--textarea form-item--squared form-item--textarea-big _control-height-md _control-padding-xs
                @if($errors->has('comment')) has-error @elseif($comment) is-valid @endif"
            >
                <label for="comment" class="form-item__label _fz-xxxs">@lang('cms-contacts::site.Комментарий')</label>
                <div class="form-item__body">
                <textarea class="form-item__control"
                          type="text"
                          name="comment"
                          id="comment"
                          wire:model.lazy="comment"
                          wire:key="comment"
                          spellcheck="true"
                          inputmode="text"
                >
                </textarea>
                </div>
                @error('comment')
                    <span class="form-item__error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="_flex">
            <button class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-xs _control-space-md _flex-grow"
                    type="submit"
            >
                <span class="button__text">
                    @lang('cms-contacts::site.Отправить')
                </span>
            </button>
        </div>
    </form>
</div>
