<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                    <div class="form-group">
                        {!! Form::label($locale . '[question]', __('cms-faq::admin.Question')) !!}
                        {!! Form::text($locale . '[question]', old($locale . '.question', $obj->translateOrNew($locale)->question)) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[answer]', __('cms-faq::admin.Answer')) !!}
                        {!! Form::textarea($locale . '[answer]', old($locale . '.answer', $obj->translateOrNew($locale)->answer), ['class' => 'js-wysiwyg', 'rows' => 10, 'data-lang' => $locale]) !!}
                    </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                    {!! Form::status('published') !!}
                </div>
                @if(config('cms.faq.faq.use_groups'))
                    <div class="form-group">
                        {!! Form::label('faq_group_id', __('cms-faq::admin.Group')) !!}
                        {!! Form::select('faq_group_id', $groups, null, ['class' => 'js-select2']) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
