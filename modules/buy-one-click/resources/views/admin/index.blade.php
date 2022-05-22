@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="1%">@massControl($routeName)</th>
                <th width="1%">#</th>
               {{-- <th>@lang('cms-buy-one-click::admin.Name')</th>--}}
                <th>@lang('cms-buy-one-click::admin.Phone')</th>
                <th>@lang('cms-buy-one-click::admin.Product')</th>
              {{--  <th>@lang('cms-buy-one-click::admin.Count')</th>--}}
                <th>@lang('cms-buy-one-click::admin.Read')</th>
                <th>@lang('cms-buy-one-click::admin.Date')</th>
                <th width="1%" class="text-center">@lang('cms-core::admin.layout.Manage')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $obj)
                <tr>
                    <td>@massCheck($obj)</td>
                    <td>{{ $obj->id }}</td>
                   {{-- <td>@editResource($obj)</td>--}}
                    <td>
                        @if($obj->phone)
                            <a href="tel:{{ preg_replace('/[^\d\+]/', '', $obj->phone) }}">{{ $obj->phone }}</a>
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    <td>
                        @if($obj->product)
                            <a href="{{ route('admin.products.edit', $obj->product->id) }}"
                               title="{{ $obj->product->name }}"
                               target="_blank">{{ $obj->product->name }}</a>
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                  {{--  <td>
                        {{ $obj->count . ' ' . $obj->unit() }}
                    </td>--}}
                    <td>
                        @if($obj->read)
                            <span class="text-success">@lang('cms-core::admin.layout.Yes')</span>
                        @else
                            <span class="text-warning">@lang('cms-core::admin.layout.No')</span>
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
