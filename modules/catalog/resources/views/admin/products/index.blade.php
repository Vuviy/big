@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl(compact('routeName', 'deleteText', 'buttons'))</th>
                <th width="1%">#</th>
                <th>@lang('cms-catalog::admin.products.Name')</th>
                <th>@lang('cms-catalog::admin.products.Cost')</th>
                <th>@lang('cms-catalog::admin.products.Group key')</th>
                <th>@lang('cms-catalog::admin.products.Category')</th>
                <th></th>
                <th width="150px">@lang('cms-catalog::admin.products.Position')</th>
                <th>@lang('cms-catalog::admin.products.Created at')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>{{ $obj->id }}</td>
                    <td>@editResource($obj)</td>
                    <td class="text-nowrap">@money($obj->cost, true)</td>
                    <td>{{ $obj->group_key }}</td>
                    <td>
                        @if($obj->category)
                            {{ $obj->category->name }}
                       @endif
                    </td>
                    <td>@gotosite($obj)</td>
                    <td>
                        @can('products.edit', $obj)
                            {!! Form::open(['route' => ['admin.products.set-sort', $obj->id], 'method' => 'post', 'class' => 'js-ajax-form']) !!}
                            <div class="input-group">
                                {!! Form::number('sort', $obj->sort, ['required' => 'required']) !!}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fa fa-floppy-o"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-secondary']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @else
                            {{ $obj->sort }}
                        @endcan
                    </td>
                    <td>{{ $obj->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <div class="btn-group list-control-buttons" role="group">
                            @smallStatus($obj)
                            @editResource($obj, false)
                            @can('products.copy', $obj)
                                <a href="{{ route($routeName . '.copy', $obj) }}" class="btn btn-info"
                                   title="@lang('cms-catalog::admin.products.Copy product')"><i class="fa fa-clone"></i></a>
                            @endcan
                            @deleteResource(['obj' => $obj, 'text' => $deleteText])
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @foreach(array_filter(event('products:index_footer')) as $content)
        {!! $content !!}
    @endforeach

    <div class="modal fade" id="change-category" role="dialog" tabindex="-1" aria-labelledby="change-category-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="preloader"></div>
            </div>
        </div>
    </div>
@endsection
