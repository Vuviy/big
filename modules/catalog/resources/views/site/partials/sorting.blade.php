<div class="form-item form-item--select2 _control-height-md _control-width-select _control-padding-xxs _fz-xs">

    <select
        class="js-select-sort js-dmi js-select select-input"
        name="{{ $sort->getUrlKey() }}"
        @if($products->total() === 0) disabled @endif
    >
        @foreach($sort->getAllSortVariants() as $key => $name)
            <option value="{{ str_replace('default', '', $key) }}" {{ $sort->isThisSort($key) ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>

    @svg('common', 'sorting', 16, 'select__icon')
</div>
