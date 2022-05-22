@langTabs
@include('cms-core::admin.partials.form-meta-inputs')
<div class="form-group">
    {!! Form::label($locale . '[text]', __('cms-core::admin.seo.Seo text')) !!}
    {!! Form::textarea($locale . '[text]', old($locale . '.text', $obj->translateOrNew($locale)->text), ['class' => 'js-wysiwyg', 'data-lang' => $locale]) !!}
</div>
@endLangTabs
