<li class="dd-item" data-id="{{ $item->id }}">
    @massCheck($item)
    <div class="dd-handle fa fa-arrows"></div>
    <div class="dd-content">
        <div class="row align-items-center">
            <div class="col-12 col-md-4">@editResource($item)</div>
            <div class="col-12 col-md-4">
                <div class="p-2">
                    @gotosite($item)
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-2">
                    @statuses(['obj' => $item, 'request' => WezomCms\Menu\Http\Requests\MenuRequest::class])
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="btn-group list-control-buttons pull-right p-2" role="group">
                    @editResource($item, false)
                    @can('menu.edit', $item)
                        @include($viewPath.'.copy-button', ['item' => $item])
                    @endcan
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
