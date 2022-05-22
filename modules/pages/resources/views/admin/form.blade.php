<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @langTabs
                    <div class="form-group">
                        {!! Form::label(str_slug($locale . '[published]'), __('cms-core::admin.layout.Published')) !!}
                        {!! Form::status($locale . '[published]', old($locale . '.published', $obj->exists ? $obj->translateOrNew($locale)->published : true))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[name]', __('cms-pages::admin.Name')) !!}
                        {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[slug]', __('cms-core::admin.layout.Slug')) !!}
                        {!! Form::slugInput($locale . '[slug]', old($locale . '.slug', $obj->translateOrNew($locale)->slug), ['source' => 'input[name="' . $locale . '[name]"']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[text]', __('cms-pages::admin.Text')) !!}
                        {!! Form::textarea($locale . '[text]', old($locale . '.text', $obj->translateOrNew($locale)->text), ['class' => 'js-wysiwyg', 'data-lang' => $locale]) !!}
                    </div>

                    @include('cms-core::admin.partials.form-meta-inputs', compact('obj', 'locale'))
                @endLangTabs
            </div>
        </div>
    </div>
</div>
