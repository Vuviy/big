@if ($links ?? false)
@foreach($links as $link)
[{{ $link['title'] }}]({{ $link['route'] }})
@endforeach
@endif
