@extends('cms-core::admin.layouts.main')

@section('main')
    {!! Form::open(['route' => 'admin.seo-redirects.import', 'method' => 'post', 'id' => 'form', 'files' => true]) !!}
        <div class="card">
            <div class="card-body">
                <div>
                    <h5>@lang('cms-seo::admin.redirects.File structure')</h5>
                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th></th>
                            <th><strong>A</strong> <small>@lang('cms-seo::admin.redirects.Link from')</small></th>
                            <th><strong>B</strong> <small>@lang('cms-seo::admin.redirects.Link to')</small></th>
                            <th><strong>C</strong> <small>@lang('cms-seo::admin.redirects.HTTP status not required')</small>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>/old-url</td>
                            <td>/new-url</td>
                            <td>301</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>/old-url2</td>
                            <td>/new-url2</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="form-group">
                    {!! Form::label('file', __('cms-seo::admin.redirects.File')) !!}
                    {!! Form::file('file') !!}
                </div>
            </div>
        </div>
        @widget('admin:form-buttons')
    {!! Form::close() !!}
@endsection
