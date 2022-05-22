@php
    /**
    * @var $reviews \Illuminate\Pagination\LengthAwarePaginator|\WezomCms\ProductReviews\Models\ProductReview[]
    */
@endphp

@forelse($reviews as $review)
    @php
        $childesCount = $review->childes->count();
    @endphp

    @if($childesCount > 1)
        <div x-data="window.app.alpine.singleAccordion({ namespaceRef: 'rev'  })">
            @endif
            <div class="@if($childesCount) _mb-xs @else _mb-sm @endif">
                <div class="box box--review">
                    <div class="_grid _spacer _spacer--xs _items-center _mb-xs">
                        <div class="_cell">
                            <div class="text _fz-def _fw-bold">
                                {{ $review->name }}
                            </div>
                        </div>
                        <div class="_cell">
                            @include('cms-product-reviews::site.partials.rating', ['rating' => $review->rating])
                        </div>
                        <div class="_cell _ml-auto">
                            <div class="text _color-faint-strong">
                                {{ $review->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text _fz-xs _color-faint-strong">
                            {{ $review->text }}
                        </div>
                    </div>
                </div>
            </div>
            @if($childesCount > 1)
                <div x-ref="rev{{ $loop->index }}" style="display: none">
                    @endif
                    @foreach($review->childes as $child)
                        <div class="_flex _flex-nowrap _items-center _mb-xs">
                            <div class="_px-xs _xs:px-sm _lg:px-df">
                                <div class="icon icon--arrow-directive">
                                    @svg('common', 'arrow-curve-bottom-right', 32)
                                </div>
                            </div>
                            <div class="box box--review-child _flex-grow">
                                <div class="_grid _spacer _spacer--xs _items-center _mb-xs">
                                    <div class="_cell">
                                        <div class="text _fz-def _fw-bold">
                                            {{ $child->name }}
                                        </div>
                                    </div>
                                    <div class="_cell _ml-auto">
                                        <div class="text _color-faint-strong">
                                            {{ $child->created_at->format('d.m.Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="text _fz-xs _color-faint-strong">
                                        {{ $child->text }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @if($childesCount > 1)
            </div>
        </div>
    @endif
@empty
    <div>@lang('cms-product-reviews::site.О товаре еще нет отзывов. Будьте первым!')</div>
@endforelse

