@php
    /**
     * @var $product \WezomCms\Catalog\Models\Product
     * @var $variations \Illuminate\Support\Collection|\WezomCms\Catalog\Models\Product[]
     */
@endphp
<div class="_grid _grid--1 _spacer _spacer--sm _lg:spacer--md _mb-none">
    @foreach($variations as $variant)
        @php($specification = $variant->first()->specification)
        @if($specification)
        <div class="_cell">
            <div class="_grid _items-center _spacer _spacer--xs">
                <div class="_cell">
                    <div class="text _fz-def _fw-bold _color-base-strong">{{ $specification->name }}:</div>
                </div>
                @foreach($variant as $specValue)
                    <?php
                        $selected = $selectedSpecValues->has($specValue->id);
                        $classes = [];
                        if (!$specValue->product) { $classes[] = 'disabled'; }
                        if ($selected) { $classes[] = 'is-active'; }
                        $classes = implode(' ', $classes);
                    ?>
                        @if($specification->type === \WezomCms\Catalog\Models\Specifications\Specification::COLOR)
                            <div class="_cell">
                                <a class="button button--variation-color _b-r-full _control-width-xs _control-height-xs {{ $classes }} tooltip js-dmi"
                                   href="{{ optional($specValue->product)->getFrontUrl() }}"
                                   @if($selected || !$specValue->product) disabled @endif
                                   data-tippy="{{ json_encode((object)['placement' => 'top']) }}"
                                   data-template="color-{{$specValue->id}}"
                                >
                                    <span class="button__inner" title="{{ $specValue->name }}"
                                          style="background-color: {{ $specValue->color }}"
                                    ></span>
                                    <template id="color-{{$specValue->id}}">
                                        <div class="tooltip__text text _fz-xxxxs _letter-spacing-def _color-white">
                                            {{ $specValue->name }}
                                        </div>
                                    </template>
                                </a>
                            </div>
                        @else
                            <div class="_cell">
                                <a class="button button--theme-outline-gray _b-r-lg _control-height-xs _control-padding-sm {{ $classes }}"
                                   href="{{ optional($specValue->product)->getFrontUrl() }}"
                                   @if($selected || !$specValue->product) disabled @endif
                                >
                                    <span title="{{ $specValue->name }}">{{ $specValue->name }}</span>
                                </a>
                            </div>
                        @endif
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>
