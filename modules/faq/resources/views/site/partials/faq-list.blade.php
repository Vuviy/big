@foreach($questions as $item)
    <div class="accordion accordion--tabs"
         x-data="app.alpine.singleAccordion({ namespaceRef: 'faq', selectedId: {{ 0 }} })"
    >
        <div class="accordion__header"
             @click="open({{ $item->id }})"
        >
            <div class="text _fz-def _fw-bold">
                {{ $item->question }}
            </div>
            <div class="accordion__trigger">
                <div class="accordion__trigger-icon icon"
                     :class="{'is-active' : isOpened({{ $item->id }})}"
                >
                    @svg('common', 'arrow-down', [10, 10])
                </div>
            </div>
        </div>
        <div class="accordion__body"
             x-ref="faq{{ $item->id }}"
             x-show="isOpened({{ $item->id }})"
             style="display: none"
        >
            <div class="accordion__body-inner">
                <div class="wysiwyg js-import" data-wrap-media
                     data-draggable-table>{!! $item->answer !!}</div>
            </div>
        </div>
    </div>
@endforeach
