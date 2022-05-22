@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl($routeName)</th>
                <th>@lang('cms-about::admin.Name')</th>
                <th>@lang('cms-about::admin.E-mail')</th>
                <th>@lang('cms-about::admin.Notify about replies')</th>
                <th>@lang('cms-about::admin.Date')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>@editResource($obj)</td>
                    <td>
                        @if($obj->email)
                            <a href="mailto:{{ $obj->email }}">{{ $obj->email }}</a>
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>
                        @if($obj->notify)
                            @lang('cms-core::admin.layout.Yes')
                        @else
                            @lang('cms-core::admin.layout.No')
                        @endif
                    </td>
                    <td>
                        @if($obj->created_at)
                            {{ $obj->created_at }}
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
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
