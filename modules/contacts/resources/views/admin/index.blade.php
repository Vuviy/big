@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl($routeName)</th>
                <th>@lang('cms-contacts::admin.Name')</th>
                <th>@lang('cms-contacts::admin.E-mail')</th>
                <th width="40%">@lang('cms-contacts::admin.Message')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>@editResource(['obj' => $obj, 'ability' => 'contacts.edit'])</td>
                    <td>
                        @if($obj->email)
                            <a href="mailto:{{ $obj->email }}">{{ $obj->email }}</a>
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>
                        @if($obj->message)
                            <span title="{{ $obj->message }}">{{ str_limit($obj->message, 20) }}</span>
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group list-control-buttons" role="group">
                            @smallStatus(['obj' => $obj, 'field' => 'read'])
                            @editResource(['obj' => $obj, 'text' => false])
                            @deleteResource(['obj' => $obj])
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
