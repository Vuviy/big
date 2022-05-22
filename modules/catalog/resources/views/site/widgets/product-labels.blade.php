@foreach($product->flags as $flag)
    <div class="label label--{{ $flag['color'] }}">
        <div class="label__text text _fz-xxxs">
            {{ $flag['text'] }}
        </div>
    </div>
@endforeach
