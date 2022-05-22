@php
    /**
     * @var $ratings array
     * @var $ratingText string
     * @var $replyToReview \WezomCms\ProductReviews\Models\ProductReview|null
     */
@endphp
<div class="modal-content modal-content--size-xxxl" @mousedown.away="isShow && close($event)">
    <div class="_flex _items-center _justify-between _mb-xs">
        <div class="text _fz-xxs _fw-bold _uppercase _color-base-strong">
            @lang('cms-product-reviews::site.оставить отзыв')
        </div>
    </div>

    <form novalidate="novalidate" wire:submit.prevent="submit">
        <div class="_grid _spacer _spacer--sm _mb-none">
            <div class="_cell _cell--12 _sm:cell--6">
                @component('cms-ui::components.form.input', [
                    'name' => 'name',
                    'attributes' => [
                        'required',
                        'wire:model.lazy=name',
                        'wire:key=name',
                        'autocomplete=name'
                    ],
                    'label' => __('cms-users::site.Имя') . '*',
                    'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                    'type' => 'text'
                ])@endcomponent
            </div>
            <div class="_cell _cell--12 _sm:cell--6">
                @component('cms-ui::components.form.input', [
                    'name' => 'email',
                    'attributes' => [
                        'required',
                        'wire:model.lazy=email',
                        'wire:key=email',
                        'autocomplete=email'
                    ],
                    'label' => __('cms-product-reviews::site.Эл. почта') . '*',
                    'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                    'type' => 'email'
                ])@endcomponent
            </div>
            <div class="_cell _cell--12">
                @component('cms-ui::components.form.textarea', [
                    'name' => 'text',
                    'attributes' => [
                        'required',
                        'wire:model.lazy=text',
                        'wire:key=text'
                    ],
                    'label' => __('cms-product-reviews::site.Комментарий'),
                    'classes' => 'form-item--theme-base-weak _control-padding-xxs',
                    'type' => 'text'
                ])@endcomponent
            </div>
        </div>
        @if(!$replyToReview)
            <div class="box box--rating _mb-sm">
                <div class="_grid _spacer _spacer--lg _items-center _justify-center">
                    <div class="_cell">
                        <div class="text _fw-bold _uppercase">@lang('cms-product-reviews::site.Оценить товар')</div>
                    </div>
                    <div class="_cell">
                        <div class="star-choose _flex-noshrink" wire:key="{{ 'review-form-rating' . microtime() }}">
                            <div class="star-choose__inner">
                                @foreach(array_reverse($ratings, true) as $rating => $text)
                                    <input type="radio"
                                           class="star-choose__input"
                                           required="required"
                                           wire:model="rating"
                                           name="rating"
                                           id="rating-{{ $rating }}"
                                           value="{{ $rating }}"
                                    >
                                    <label for="rating-{{ $rating }}"
                                           class="star-choose__svg-holder star-choose__svg-holder--md"
                                           title="{{ $text }}"
                                    >
                                        @svg('common', 'star', 32, 'star-choose__svg  star-choose__svg--md')
                                        <span class="star-choose__label">{{ $text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="_cell">
                        <div class="text _fw-bold _uppercase">{{ $ratingText }}</div>
                    </div>
                </div>
            </div>
        @endif
        <div class="_mb-sm">
            <div class="checkbox checkbox--default">
                <input class="checkbox__control"
                       type="checkbox"
                       name="notify"
                       id="notify"
                       wire:model="notify"
                       wire:key="notify"
                >
                <label class="checkbox__label" for="notify">
                    <span class="checkbox__checkmark">
                        @svg('common', 'checkmark', [12,12])
                    </span>
                    <span class="checkbox__text _fz-xs _color-black">@lang('cms-product-reviews::site.Уведомлять об ответах по email')</span>
                </label>
                @error('notify')
                    <span class="form-item__error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="_flex _justify-center">
            <button class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-md _flex-grow">
                <span class="button__text">@lang('cms-product-reviews::site.Отправить')</span>
            </button>
        </div>
    </form>
</div>
