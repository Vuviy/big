@extends('cms-core::admin.layouts.main')

@section('main')
    {!! Form::open(['route' => ['admin.newsletter.send'], 'id' => 'form']) !!}
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('subject', __('cms-newsletter::admin.Subject')) !!}
                        {!! Form::text('subject') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('text', __('cms-newsletter::admin.Text')) !!}
                        {!! Form::textarea('text', null, ['class' => 'js-wysiwyg']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('locale', __('cms-newsletter::admin.Locale')) !!}
                        {!! Form::select('locale', $locales) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @widget('admin:form-buttons')
    {!! Form::close() !!}
@endsection
