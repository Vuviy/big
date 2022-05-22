@extends('cms-core::admin.layouts.main')

@section('page-title-buttons')
    @widget('admin:index-buttons')
@endsection

@section('main')
    <div class="card">
        <div class="card-body p-0">
            @foreach($types as $groupKey => $group)
                <div class="card {{ !$loop->last ? 'mb-2' : '' }}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="py-2"><strong>{{ $group }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="dd js-nestable"
                             data-settings-depth="1"
                             data-control-list
                             data-params="{{ json_encode(['model' => encrypt($model), 'update_fields' => ['type' => $groupKey]]) }}">
                            @massControl($routeName)
                            @if(!empty($result[$groupKey][null]))
                                <ol class="dd-list">
                                    @foreach($result[$groupKey][null] as $item)
                                        @include($viewPath . '.index-list-item', ['result' => array_get($result, $groupKey), 'item' => $item])
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
