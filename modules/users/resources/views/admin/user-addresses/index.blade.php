@extends('cms-core::admin.crud.index')

@php
    /**
     * @var $result WezomCms\Orders\Models\UserAddress[]
     * @var $model string
     */
@endphp

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl($routeName)</th>
                <th>@lang('cms-users::admin.Адрес')</th>
                <th>@lang('cms-users::admin.Пользователь')</th>
                <th>@lang('cms-users::admin.Основной адрес')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>@editResource(['obj' => $obj, 'text' => $obj->full_address])</td>
                    <td>@editResource(['obj' => $obj->user, 'text' => $obj->user->full_name, 'ability' => 'users.edit', 'target' => '_blank'])</td>
                    <td>
                        @if($obj->primary)
                            <span class="text-success">@lang('cms-core::admin.layout.Yes')</span>
                        @else
                            <span class="text-warning">@lang('cms-core::admin.layout.No')</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group list-control-buttons" role="group">
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
