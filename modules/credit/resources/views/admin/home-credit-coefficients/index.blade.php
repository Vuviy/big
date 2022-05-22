@extends('cms-core::admin.crud.index')

@php
    /**
     * @var $result WezomCms\Credit\Models\HalykCoefficient[]
     * @var $model string
     */
@endphp

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl($routeName)</th>
                <th>@lang('cms-credit::admin.Month')</th>
                <th>@lang('cms-credit::admin.Type')</th>
                <th>@lang('cms-credit::admin.Coefficient')</th>
                <th>@lang('cms-credit::admin.Price range')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>@editResource(['obj' => $obj, 'text' => $obj->month])</td>
                    <td>{{ \WezomCms\Credit\Enums\CreditType::getDescription($obj->type) }}</td>
                    <td>{{ $obj->coefficient }}</td>
                    <td>@money($obj->availability) - @money($obj->max_sum, true)</td>
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
