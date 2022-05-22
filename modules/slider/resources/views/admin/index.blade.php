@extends('cms-core::admin.crud.index')

@section('content')

    @foreach($result as $sliderKey => $slider)
        <div class="card {{ !$loop->last ? 'mb-2' : '' }}">
            @if(count($result) > 1)
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="py-2"><strong>{{ __($slider['name']) }}</strong></h5>
                </div>
            @endif
            <div class="card-body">
                <div class="dd js-nestable" data-settings-depth="1" data-control-list
                     data-params="{{ json_encode(['model' => encrypt($model), 'update_fields' => ['slider' => $sliderKey]]) }}">
                    @if(!empty($slides[$sliderKey]))
                        @massControl($routeName)
                        <ol class="dd-list">
                            @foreach($slides[$sliderKey] as $item)
                                <li class="dd-item" data-id="{{ $item->id }}">
                                    @massCheck($item)
                                    <div class="dd-handle fa fa-arrows"></div>
                                    <div class="dd-content">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-2">
                                                @if($item->imageExists())
                                                    <a href="{{ url($item->getImageUrl()) }}" data-fancybox>
                                                        <img src="{{ url($item->getImageUrl()) }}"
                                                             alt="{{ $item->name }}" height="50">
                                                    </a>
                                                @else
                                                    <span class="d-block p-2 text-info">@lang('cms-slider::admin.No image')</span>
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-6">
                                                @editResource($item)
                                            </div>
                                            <div class="col-6 col-md-2">
                                                <div class="p-2">
                                                    @statuses(['obj' => $item, 'request' => WezomCms\Core\Http\Requests\ChangeStatus\LocaledNameRequest::class])
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-2">
                                                <div class="btn-group list-control-buttons pull-right p-2" role="group">
                                                    @editResource($item, false)
                                                    @deleteResource($item)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endsection
