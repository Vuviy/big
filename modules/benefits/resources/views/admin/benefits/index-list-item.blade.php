<li class="dd-item" data-id="{{ $item->id }}">
    @massCheck($item)
    <div class="dd-handle fa fa-arrows"></div>
    <div class="dd-content">
        <div class="row align-items-center">
            <div class="col-md-10">@editResource($item)</div>
            <div class="col-md-2">
                <div class="btn-group list-control-buttons pull-right p-2" role="group">
                    @smallStatus($item)
                    @editResource($item, false)
                    @deleteResource($item)
                </div>
            </div>
        </div>
    </div>
    @if(!empty($result[$item->id]))
        <ol class="dd-list">
            @foreach($result[$item->id] as $subItem)
                @include($viewPath.'.index-list-item', ['result' => $result, 'item' => $subItem])
            @endforeach
        </ol>
    @endif
</li>
