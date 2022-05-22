@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">#</th>
                <th>@lang('cms-newsletter::admin.Subject')</th>
                <th>@lang('cms-newsletter::admin.Count emails')</th>
                <th>@lang('cms-newsletter::admin.Text')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>{{ $obj->id }}</td>
                    <td>{{ $obj->subject }}</td>
                    <td>{{ $obj->count_emails }}</td>
                    <td>{!! str_limit(strip_tags($obj->text), 20) !!}</td>
                    <td>
                        <div class="btn-group list-control-buttons" role="group">
                            @showResource($obj, false)
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
