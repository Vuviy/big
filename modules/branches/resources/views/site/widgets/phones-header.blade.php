@php
/**
 * @var $branches \Illuminate\Database\Eloquent\Collection|\WezomCms\Branches\Models\Branch[]
 */
$multiple = $branches->count() > 1 || count($branches->pluck('phones')) > 1;
$firstBranch = $branches->first();
$firstPhone = array_get($firstBranch->phones, 0);
@endphp
<div>
    <div class="{{ !$multiple ? 'is-alone': ''}}">
        <div>
            <div>
                <svg viewBox="0 0 100 100" width="18" height="18">
                    <use xlink:href="{{ url('assets/images/sprites/icons.svg#tel') }}"></use>
                </svg>
                <div>{{ $firstBranch->name }}</div>
                <a href="tel:{{ preg_replace('/[^\d\+]/', '', $firstPhone) }}">
                    <span>{{ $firstPhone }}</span>
                </a>
                @if($multiple)
                    <svg viewBox="0 0 100 61.6" width="15" height="10">
                        <use xlink:href="{{ url('assets/images/sprites/icons.svg#down') }}"></use>
                    </svg>
                @endif
            </div>
        </div>
        <div>
            @foreach($branches as $branch)
                @foreach($branch->phones as $phone)
                    @continue($loop->first && $loop->parent->first)
                    <div>
                        <div>{{ $branch->name }}</div>
                        <a href="tel:{{ preg_replace('/[^\d\+]/', '', $phone) }}">
                            <span>{{ $phone }}</span>
                        </a>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
