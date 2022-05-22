<div class="popup popup--theme-order-reviews">
	<div class="popup__title">
        @lang('cms-catalog::site.Оставить отзыв')
	</div>
	@foreach($items as $item)
		<div class="products-card products-card--theme-popup {{ !$loop->last ? 'products-card--bordered' : '_mb-none' }} _spacer _spacer--md">
			<div class="_flex _spacer _spacer--md _xs:mb-none">
				<div class="products-card__thumb _mb-none">
					<img src="{{ url('/static/no-image.png') }}"
						 data-lazy-load
						 class="js-static"
						 data-zzload-source-img="{{ $item->product->getImageUrl('small') }}"
						 alt="">
				</div>
				<a title="{{ $item->name }}" class="link link--size-sm link--color-gray _mb-none" href="{{ $item->product->getFrontUrl() }}">
					{{ $item->name }}
				</a>
			</div>
			<div class="_flex-noshrink _mb-none">
				@widget('ui:button', [
					'component' => 'a',
					'attrs' => [
						'href' => $item->product->getFrontUrl().'#rating'
					],
					'text' => __('cms-users::site.Оставить отзыв'),
					'modificators' => ['main']
				])
			</div>
		</div>
	@endforeach
</div>
