@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl($routeName)</th>
                <th width="1%">#</th>
                <th>@lang('cms-newsletter::admin.E-mail')</th>
                <th>@lang('cms-newsletter::admin.IP')</th>
                <th>@lang('cms-newsletter::admin.Locale')</th>
                <th>@lang('cms-newsletter::admin.Created at')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>@editResource($obj, $obj->id)</td>
                    <td>
                        @if($obj->email)
                            <a href="mailto:{{ $obj->email }}">{{ $obj->email }}</a>
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>
                        @if($obj->ip)
                            {{ $obj->ip }}
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>
                        @if($language = array_get((array)app('locales'), $obj->locale))
                            {{ $language }}
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>
                        {{ $obj->created_at->format('d.m.Y') }}
                    </td>
                    <td>
                        <div class="btn-group list-control-buttons" role="group">
                            @smallStatus(['obj' => $obj, 'field' => 'active'])
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
