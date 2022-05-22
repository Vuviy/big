@langTabs
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label($locale.'[name]', __('cms-catalog::admin.products.Name')) !!}
                {!! Form::text($locale.'[name]', old($locale.'.name', $obj->translateOrNew($locale)->name)) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label($locale.'[slug]', __('cms-core::admin.layout.Slug')) !!}
                {!! Form::slugInput($locale.'[slug]', old($locale.'.slug', $obj->translateOrNew($locale)->slug), ['source' => 'input[name="' . $locale . '[name]"]']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label($locale . '[text]', __('cms-catalog::admin.products.Text')) !!}
        {!! Form::textarea($locale . '[text]', old($locale . '.text', $obj->translateOrNew($locale)->text), ['class' => 'js-wysiwyg', 'data-lang' => $locale]) !!}
    </div>
@endLangTabs
