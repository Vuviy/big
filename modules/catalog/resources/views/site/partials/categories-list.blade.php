@php
    /**
     * @var $viewCategories \Illuminate\Pagination\LengthAwarePaginator|\WezomCms\Catalog\Models\Category[]
     */
@endphp

<div class="grid grid--categories _grid _grid--2 _xs:grid--3 _sm:grid--4 _md:grid--5 _df:grid--7 _lg:grid--9 _spacer _spacer--sm">
    @foreach($viewCategories as $item)
        <div class="grid__cell _cell">
            <a href="{{ $item['frontUrl'] }}" class="category-card">
                <img class="category-card__img"
                    src="{{ $item['imageUrl'] }}"
                    alt="{{ $item['name'] }}"
                >
                <span class="text _fz-xxxs _color-black">{{ $item['name'] }}</span>
            </a>
        </div>
    @endforeach
</div>
