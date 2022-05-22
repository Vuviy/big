@php
/**
 * @var $branches \Illuminate\Database\Eloquent\Collection|\WezomCms\Branches\Models\Branch[]
 */
@endphp
<div>
    <svg viewBox="0 0 100 100" width="19" height="19">
        <use xlink:href="{{ url('assets/images/sprites/icons.svg#tel') }}"></use>
    </svg>
    <div>
        <div>
            @foreach($branches as $branch)
                <div>
                    <div>{{ $branch->name }}</div>
                    <ul>
                        @foreach($branch->phones as $phone)
                            <li>
                                <a href="tel:{{ preg_replace('/[^\d\+]/', '', $phone) }}" title="{{ $phone }}">
                                    {{ $phone }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
