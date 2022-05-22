@extends('cms-core::admin.crud.index')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="sortable-column"></th>
                <th width="1%">@massControl($routeName)</th>
                <th>@lang('cms-faq::admin.Question')</th>
                <th>@lang('cms-faq::admin.Answer')</th>
                @if(config('cms.faq.faq.use_groups'))
                    <th>@lang('cms-faq::admin.Group')</th>
                @endif
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
                    <td>
                        @editResource(['obj'=> $obj, 'text' => str_limit($obj->question, 100)])
                    </td>
                    <td>
                        @if($obj->answer)
                            {!! str_limit(strip_tags($obj->answer)) !!}
                        @else
                            <span class="text-info">@lang('cms-core::admin.layout.Not set')</span>
                        @endif
                    </td>
                    @if(config('cms.faq.faq.use_groups'))
                        <td>
                            @if($obj->group)
                                @editResource(['obj'=> $obj->group, 'text' => $obj->group->name, 'ability' => 'faq-groups.edit', 'target' => '_blank'])
                            @endif
                        </td>
                    @endif
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
