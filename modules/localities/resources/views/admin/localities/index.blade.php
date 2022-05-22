@extends('cms-core::admin.crud.index')

@php
    /**
     * @var $result WezomCms\Localities\Models\Locality[]
     * @var $model string
     */
@endphp

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="sortable-column"></th>
                <th width="1%">@massControl($routeName)</th>
                <th>@lang('cms-core::admin.layout.Name')</th>
                <th>@lang('cms-localities::admin.City')</th>
                <th>@lang('cms-localities::admin.Delivery cost')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody class="js-sortable"
                   data-params="{{ json_encode(['model' => encrypt($model), 'page' => $result->currentPage(), 'limit' => $result->perPage()]) }}">
            @foreach($result as $obj)
                <tr data-id="{{ $obj->id }}">
                    <td>
                        <div class="js-sortable-handle sortable-handle">
                            <i class="fa fa-arrows"></i>
                        </div>
                    </td>
                    <td>@massCheck($obj)</td>
                    <td>@editResource($obj)</td>
                    <td>@if($obj->city)
                            @editResource(['obj' => $obj->city, 'text' => $obj->city->name, 'ability' => 'cities.edit', 'target' => '_blank'])
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>@money($obj->delivery_cost, true)</td>
                    <td>
                        <div class="btn-group list-control-buttons" role="group">
                            @smallStatus($obj)
                            @editResource($obj, false)
                            @deleteResource($obj)
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
