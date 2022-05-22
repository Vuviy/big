<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                    <div class="form-group">
                        {!! Form::label(str_slug($locale . '[published]'), __('cms-core::admin.layout.Published')) !!}
                        {!! Form::status($locale . '[published]', old($locale . '.published', $obj->exists ? $obj->translateOrNew($locale)->published : true))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[name]', __('cms-slider::admin.Name')) !!}
                        {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[url]', __('cms-slider::admin.Link')) !!}
                        {!! Form::text($locale . '[url]', old($locale . '.url', $obj->translateOrNew($locale)->url), ['placeholder' => 'http://example.com']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[description_1]', __('cms-slider::admin.Description 1')) !!}
                        {!! Form::textarea($locale . '[description_1]', old($locale . '.description_1', $obj->translateOrNew($locale)->description_1), ['class' => 'js-wysiwyg', 'data-lang' => $locale]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[description_2]', __('cms-slider::admin.Description 2')) !!}
                        {!! Form::textarea($locale . '[description_2]', old($locale . '.description_2', $obj->translateOrNew($locale)->description_2), ['class' => 'js-wysiwyg', 'data-lang' => $locale]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[image]', __('cms-slider::admin.Image')) !!}
                        {!! Form::imageUploader($locale . '[image]', $obj, route($routeName . '.delete-image', [$obj->id, 'image', $locale])) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[image_mobile]', __('cms-slider::admin.Image Mobile')) !!}
                        {!! Form::imageUploader($locale . '[image_mobile]', $obj, route($routeName . '.delete-image', [$obj->id, 'image_mobile', $locale])) !!}
                    </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('open_in_new_tab', __('cms-slider::admin.Open link in new tab')) !!}
                    {!! Form::status('open_in_new_tab', null, false) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('price', __('cms-slider::admin.Price')) !!}
                    <div class="input-group">
                        {!! Form::number('price', str_replace(',', '.', old('price', $obj->price)), ['min' => 0, 'step' => '1']) !!}
                        <div class="input-group-append"><span
                                class="input-group-text">{{ money()->adminCurrencySymbol() }}</span>
                        </div>
                    </div>
                </div>
                @if($sliders->count() > 2)
                    <div class="form-group">
                        {!! Form::label('slider', __('cms-slider::admin.Slider')) !!}
                        {!! Form::select('slider', $sliders, null, ['class' => 'js-menu-group-selector']) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
