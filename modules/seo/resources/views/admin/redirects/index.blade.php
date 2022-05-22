@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl($routeName)</th>
                <th>@lang('cms-seo::admin.redirects.Name')</th>
                <th>@lang('cms-seo::admin.redirects.Link from')</th>
                <th>@lang('cms-seo::admin.redirects.Link to')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>@editResource($obj)</td>
                    <td>
                        <a href="{{ url($obj->link_from) }}" target="_blank"
                           title="@lang('cms-seo::admin.redirects.Go to site, check link')">{{ str_limit($obj->link_from, 50) }}</a>
                    </td>
                    <td>
                        <a href="{{ url($obj->link_to) }}" target="_blank"
                           title="@lang('cms-seo::admin.redirects.Go to site, check link')">{{ str_limit($obj->link_to, 50) }}</a>
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
