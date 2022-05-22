<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('read', __('cms-buy-one-click::admin.Read')) !!}
                            {!! Form::status('read') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('product_id', __('cms-buy-one-click::admin.Product')) !!}
                            @include('cms-catalog::admin.products.select', ['products' => $obj->product ? [$obj->product] : []])
                        </div>
                    </div>
                    {{--<div class="col-md-3">
                        @if($obj->product)
                            {!! Form::label('count', __('cms-buy-one-click::admin.Count')) !!}
                            <div class="input-group">
                                {!! Form::text('count', old('count', str_replace(',', '.', $obj->count))) !!}
                                <div class="input-group-append"><span class="input-group-text">{{ $obj->unit() }}</span></div>
                            </div>
                        @else
                            <div class="form-group">
                                {!! Form::label('count', __('cms-buy-one-click::admin.Count')) !!}
                                {!! Form::text('count', old('count', str_replace(',', '.', $obj->count))) !!}
                            </div>
                        @endif
                    </div>--}}
                </div>
               {{-- <div class="form-group">
                    {!! Form::label('name', __('cms-buy-one-click::admin.Name')) !!}
                    {!! Form::text('name') !!}
                </div>--}}
                <div class="form-group">
                    {!! Form::label('phone', __('cms-buy-one-click::admin.Phone')) !!}
                    {!! Form::text('phone') !!}
                </div>
            </div>
        </div>
    </div>
</div>
